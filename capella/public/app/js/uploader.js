'use strict';

const ajax = require('@codexteam/ajax');
const Methods = require('./methods').default;

/**
 * @typedef {Object} AjaxResponse
 * @property {String} body
 * @property {Number} code
 * @property {Object} headers
 */

/**
 * @class Uploader
 * Handle images uploading
 *
 * @property {String} uploadUrl — url to upload images
 * @property {HTMLElement} uploadFilButton — transport initialization trigger
 * @property {HTMLElement} uploadLinkField — input to insert image link
 */
export default class Uploader {
  /**
   * Uploader class constructor. Get needed elements and bind events
   */
  constructor() {
    this.uploadUrl = '/upload';
    this.uploadFileButton = document.getElementById('uploadFileButton');
    this.uploadLinkField = document.getElementById('uploadLinkField');

    if (this.uploadFileButton) {
      this.uploadFileButton.addEventListener('click', this.uploadByTransport.bind(this), false);
    }

    if (this.uploadLinkField) {
      this.uploadLinkField.addEventListener('keydown', this.handleKeydownEvent.bind(this), false);
    }

    this.token = Methods.getCookie('token');
  }

  /**
   * Select image from user's computer
   */
  uploadByTransport() {
    Promise.resolve()
      .then(() => {
        return ajax.transport({
          url: this.uploadUrl,
          multiple: false,
          accept: 'image/png, image/gif, image/jpg, image/jpeg, image/bmp, image/tiff',
          progress: this.progress,
          fieldName: 'file',
          beforeSend: this.before,
          data: {
            /** Append token from cookies to data to be sent */
            token: this.token
          }
        });
      })
      .then(this.success)
      .catch((err) => {
        this.error(err);
      });
  }

  /**
   * Handle keydown event on the upload link field
   *
   * @param {Event} e
   */
  handleKeydownEvent(e) {
    /** Check for Enter key */
    if (e.keyCode !== 13) {
      return;
    }
    e.preventDefault();

    if (this.uploadLinkField) {
      this.uploadByUrl(this.uploadLinkField.value);
    }
  }

  /**
   * Upload by image url
   *
   * @param {string} url
   */
  uploadByUrl(url) {
    if (url) {
      this.upload({
        'link': url,
        'token': this.token
      });
    }
  }

  /**
   * Handler to upload blob data using FormData
   *
   * @param {Blob|File} file — file to send
   */
  uploadBlob(file) {
    let formData = new FormData();

    this.currentFileName = file.name;

    formData.append('file', file, file.name);

    /** Append token from cookies to data to be sent */
    formData.append('token', this.token);

    this.upload(formData);
  }

  /**
   * Send AJAX request to uploadUrl with passed data
   *
   * @param {*} data — data to send
   */
  upload(data) {
    Promise.resolve()
      .then(() => {
        this.before(data);
        return Promise.resolve();
      })
      .then(() => {
        return ajax.post({
          url: this.uploadUrl,
          data: data,
          type: ajax.contentType.FORM,
          progress: this.progress
        });
      })
      .then(this.success)
      .catch((err) => {
        this.error(err);
      });
  }

  /**
   * Method to call before upload starts
   */
  before(data) {
    let filename;

    if (data instanceof FormData) {
      filename = this.currentFileName;
    }
    if (data && data.link) {
      filename = data.link;
    }
    if (data[0] instanceof File) {
      filename = data[0].name;
    }

    capella.uploadScreen.show(filename);
  }

  /**
   * Handle upload progress
   *
   * @param percentage — upload percentage
   */
  progress(percentage) {
    percentage = 0.95 * percentage;
    capella.uploadScreen.progress(percentage);
  }

  /**
   * Successful upload handler
   *
   * @param {AjaxResponse} response
   */
  success(response) {
    const responseBody = response.body;

    if (responseBody.success) {
      capella.uploadScreen.progress(100);

      /** Redirect to uploaded image */
      window.location.href = '/image/' + responseBody.id;
    } else {
      capella.uploadScreen.hide();
    }
  }

  /**
   * Upload error handler
   *
   * @param {AjaxResponse} response
   */
  error(response) {
    const responseBody = response.body;

    capella.notifier.show({
      message: '<i class=\'cdx-notify__warning-sign\'></i>' + responseBody.message,
      time: 7000
    });
    capella.uploadScreen.hide();
  }
}
