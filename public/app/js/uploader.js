'use strict';

let uploader = {

  uploadUrl: '/upload',

  uploadFileButton: null,
  uploadLinkField: null,

  imageWrapper: null,
  imageLinkWrapper: null,

  /**
   * Initialize uploader module. Add listeners
   */
  init() {
    uploader.uploadFileButton = document.getElementById('uploadFileButton');
    uploader.uploadLinkField  = document.getElementById('uploadLinkField');
    uploader.imageWrapper     = document.getElementById('imageWrapper');
    uploader.imageLinkWrapper = document.getElementById('imageLinkWrapper');

    if (uploader.uploadFileButton) {
      uploader.uploadFileButton.addEventListener('click', uploader.chooseFile, false);
    }

    if (uploader.uploadLinkField) {
      uploader.uploadLinkField.addEventListener('keydown', uploader.enterLink, false);
    }
  },

  /**
   * Enter-press handler for link field
   */
  enterLink(e) {
    /** Check for Enter key */
    if (e.keyCode !== 13) {
      return;
    }
    e.preventDefault();

    if (uploader.uploadLinkField) {
      capella.ajax.call({
        type: 'POST',
        url: uploader.uploadUrl,
        data: {'link': uploader.uploadLinkField.value},
        before: function before() {},
        progress: function progress(percentage) {
          console.log(percentage + '%');
        },
        success: function success(response) {
          response = JSON.parse(response);
          console.log(response);
        },
        error: function error(response) {
          response = JSON.parse(response);
          console.log(response);
        },
        after: function after() {}
      });
    };
  },

  /**
   * Handler for upload file button
   */
  chooseFile() {
    capella.transport.init({
      url: uploader.uploadUrl,
      multiple: false,
      accept: 'image/*',
      data: {},
      before: function () {},
      progress: function (percentage) {
        console.log(percentage + '%');
      },
      success: function (response) {
        response = JSON.parse(response);
        console.log(response);
      },
      error: function (response) {
        response = JSON.parse(response);
        console.log(response);
      },
      after: function () {},
    });
  }
};

module.exports = {
  init: uploader.init
};
