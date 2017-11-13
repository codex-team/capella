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
    uploader.uploadLinkField = document.getElementById('uploadLinkField');
    uploader.imageWrapper = document.getElementById('imageWrapper');
    uploader.imageLinkWrapper = document.getElementById('imageLinkWrapper');

    if (uploader.uploadFileButton) {
      uploader.uploadFileButton.addEventListener('click', uploader.chooseFile, false);
    }

    // if (uploader.uploadLinkField) {
    //     uploader.uploadLinkField.addEventListener('keydown', uploader.enterLink, false);
    // }
    if (uploader.uploadLinkField) {
      uploader.uploadLinkField.addEventListener('mouseup', uploader.urlLink, false);
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
        before() {
        },
        progress(percentage) {
          console.log(percentage + '%');
        },
        success(response) {
          console.log(response);

          /** Redirect to uploaded image */
          window.location.href = response.data.url;
        },
        error(response) {
          console.log(response);
        },
        after() {
        }
      });
    }
    ;
  },
  /**
     * mouse-up handler for link field
     */
  urlLink(e) {
    e.preventDefault();

    if (uploader.uploadLinkField) {
      capella.ajax.call({
        type: 'POST',
        url: uploader.uploadUrl,
        data: {'link': uploader.uploadLinkField.value},
        before() {
        },
        progress(percentage) {
          console.log(percentage + '%');
        },
        success(response) {
          console.log(response);

          /** Redirect to uploaded image */
          window.location.href = response.data.url;
        },
        error(response) {
          console.log(response);
        },
        after() {
        }
      });
    }
    ;
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
      before() {
      },
      progress(percentage) {
        console.log(percentage + '%');
      },
      success(response) {
        console.log(response);

        /** Redirect to uploaded image */
        window.location.href = response.data.url;
      },
      error(response) {
        console.log(response);
      },
      after() {
      },
    });
  }
};

module.exports = {
  init: uploader.init
};
