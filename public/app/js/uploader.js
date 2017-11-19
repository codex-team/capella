'use strict';
/**
 * @class Uploader
 * Handle images uploading
 *
 * @property {String} uploadUrl — url to upload images
 * @property {HTMLElement} uploadFilButton — transport initialization trigger
 * @property {HTMLElement} uploadLinkField — input to insert image link
 *
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
      accept: 'image/*',
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
   * Send AJAX request to uploadUrl with passed data
   *
   * @param {*} data — data to send
   */
  upload(data) {
    capella.ajax.call({
      type: 'POST',
      url: this.uploadUrl,
      data: data,
      before: this.before,
      progress: this.progress,
      success: this.success,
      error: this.error,
      after: this.after
    });
  }

  /**
   * Method to call before upload starts
   */
  before() {}

  /**
   *  Handle upload progress
   *
   * @param percentage — upload percentage
   */
  progress(percentage) {
    console.log(percentage + '%');
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
      /** Redirect to uploaded image */
      window.location.href = response.url;
    }
  }

  /**
   * Upload error handler
   *
   * @param {Error} error — raised error
   */
  error(error) {
    console.log(error);
  }

  /**
   * Method to call after upload
   */
  after() {}
}
