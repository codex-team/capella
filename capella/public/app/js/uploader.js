'use strict';

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
      this.uploadLinkField.addEventListener('keydown', this.uploadByUrl.bind(this), false);
    }
  }

  /**
   * Init codex.transport to select image from user's computer
   */
  uploadByTransport() {
    capella.transport.init({
      url: this.uploadUrl,
      multiple: false,
      accept: 'image/png, image/gif, image/jpg, image/jpeg, image/bmp,  image/tiff',
      data: {},
      before: this.before,
      progress: this.progress,
      success: this.success,
      error: this.error,
      after: this.after
    });
  }

  /**
   * Handle upload by image url
   *
   * @param e
   */
  uploadByUrl(e) {
    /** Check for Enter key */
    if (e.keyCode !== 13) {
      return;
    }
    e.preventDefault();

    if (this.uploadLinkField) {
      this.upload({'link': this.uploadLinkField.value});
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

    this.upload(formData);
  }

  /**
   * Send AJAX request to uploadUrl with passed data
   *
   * @param {*} data — data to send
   */
  upload(data) {
    capella.ajax.call({
      type: 'POST',
      url: this.uploadUrl,
      data: data,
      before: this.before.bind(this),
      progress: this.progress,
      success: this.success,
      error: this.error,
      after: this.after
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
   *  Handle upload progress
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
   * @param {Object} response — response object
   * @param {Boolean} response.success — upload status
   * @param {String} response.url — if upload was successful, contains uploaded image url
   * @param {String} response.id — if upload was succesful, contains uploaded image id
   * @param {String} response.message — if upload failed, contains reason
   */
  success(response) {
    console.log(response);

    if (response.success) {
      capella.uploadScreen.progress(100);

      /** Redirect to uploaded image */
      window.location.href = '/image/' + response.id;
    } else {
      capella.uploadScreen.hide();
    }
  }

  /**
   * Upload error handler
   *
   * @param {Error} error — raised error
   */
  error(response) {
    capella.notifier.show({
      message: '<i class=\'cdx-notify__warning-sign\'></i>' + response.message,
      time: 7000
    });
    capella.uploadScreen.hide();
  }

  /**
   * Method to call after upload
   */
  after() {}
}
