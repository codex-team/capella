'use strict';

var uploader = {

  uploadUrl: '/upload',

  uploadFileButton: 'uploadFileButton',
  uploadLinkField: 'uploadLinkField',

  /**
   * Initialize uploader module. Add listeners
   */
  init: function init() {
    var uploadFileButton = document.getElementById(uploader.uploadFileButton),
        uploadLinkField = document.getElementById(uploader.uploadLinkField);

    if (uploadFileButton) {
      uploadFileButton.addEventListener('click', uploader.chooseFile, false);
    }

    if (uploadLinkField) {
      uploadLinkField.addEventListener('keydown', uploader.enterLink, false);
    }
  },

  /**
   * Enter-press handler for link field
   */
  enterLink: function enterLink(e) {
    /** Check for Enter key */
    if (e.keyCode !== 13) {
      return;
    }
    e.preventDefault();

    var uploadLinkField = this;

    if (uploadLinkField && uploadLinkField.value) {
      capella.ajax.call({
        type: 'POST',
        url: uploader.uploadUrl,
        data: {'link': uploadLinkField.value},
        before: function before() {},
        progress: function progress(percentage) {
          console.log(percentage + '%');
          // ...
        },
        success: function success(response) {
          response = JSON.parse(response);
          console.log(response);
          // ...
        },
        error: function error(response) {
          response = JSON.parse(response);
          console.log(response);
          // ...
        },
        after: function after() {}
      });
    };
  },

  /**
   * Handler for upload file button
   */
  chooseFile: function chooseFile() {
    capella.transport.init({
      url: uploader.uploadUrl,
      multiple: false,
      accept: 'image/*',
      data: {},
      before: function () {},
      progress: function (percentage) {
        console.log(percentage + '%');
        // ...
      },
      success: function (response) {
        response = JSON.parse(response);
        console.log(response);
        // ...
      },
      error: function (response) {
        response = JSON.parse(response);
        console.log(response);
        // ...
      },
      after: function () {},
    });
  }
};

module.exports = {
  init: uploader.init
};
