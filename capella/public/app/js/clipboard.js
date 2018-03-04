/**
 * Paste from clipboard module
 *
 * Thanks to http://joelb.me/blog/2011/code-snippet-accessing-clipboard-images-with-javascript/
 */
export default class Clipboard {
  /**
   * Initialization of Clipboard module
   */
  constructor() {
    this.pasteCatcher = null;

    /**
     * We start by checking if the browser supports the
     * Clipboard object. If not, we need to create a
     * contenteditable element that catches all pasted data
     */
    if (!window.Clipboard) {
      this.pasteCatcher = document.createElement('DIV');

      /** Safari allows images to be pasted into contenteditable elements */
      this.pasteCatcher.setAttribute('contenteditable', '');

      /** We can hide the element and append it to the body */
      this.pasteCatcher.style.opacity = 0;
      document.body.appendChild(this.pasteCatcher);

      /**
       * Add global paste listener
       */
      document.body.addEventListener('paste', event => {
        this.pasteCatcher.focus();
        this.pasteHandler(event);
      });
    } else {
      /**
       * Add the paste event listener to the page body
       */
      document.body.addEventListener('paste', event => {
        this.pasteHandler(event);
      });
    }
  }

  /**
   * Paste handler
   *
   * @param event
   */
  pasteHandler(event) {
    // event.stopPropagation();

    let clipboard = event.clipboardData  || event.originalEvent.clipboardData || window.clipboardData;

    /**
     * Checking if clipboard has a link
     */
    let data = clipboard.getData('Text');

    if (data) {
      /**
       * Prevent pasting text data
       */
      event.preventDefault();

      /**
       * Parsing on valid URL
       */
      let regex = /^((http[s]?):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$/;

      if (data.match(regex)) {
        capella.uploader.upload({'link': data});
        return;
      } else {
        document.getElementById('uploadLinkField').value = data;
      }
    }

    /**
     * Try to catch pasted image
     */
    this.pasteImageHandler(event);
  }

  /**
   * Trying to get Image from clipboardData or pasteCatcher element
   */
  pasteImageHandler(event) {
    /**
     * We need to check if event.clipboardData is supported (Chrome)
     */
    if (!window.Clipboard) {
      /**
       * Prevent pasting image data
       */
      event.preventDefault();

      if (!event.clipboardData) {
        return;
      }

      /**
       * Get the items from the clipboard
       */
      let items = event.clipboardData.items;

      if (items) {
        /**
         * Loop through all items, looking for any kind of image
         */
        for (let i = 0; i < items.length; i++) {
          if (items[i].type.indexOf('image') !== -1) {
            /**
             * We need to represent the image as a file
             */
            let blob = items[i].getAsFile();

            /**
             * Upload image blob to server
             */
            capella.uploader.uploadBlob(blob);

            break;
          }
        }
      }
    } else {
      /**
       * If we can't handle clipboard data directly (Safari),
       * we need to read what was pasted from the contenteditable element
       *
       * This is a cheap trick to make sure we read the data
       * AFTER it has been inserted.
       */
      setTimeout(() => this.checkPasteCatcher(), 50);
    }
  }

  /**
   * Parse the pasteCatcher element for any IMG child
   */
  checkPasteCatcher() {
    /** Store the pasted content in a variable */
    let child = this.pasteCatcher.querySelector('IMG');

    /**
     * Clear the inner html to make sure we're always
     * getting the latest inserted content
     */
    this.pasteCatcher.innerHTML = '';

    if (child) {
      /**
       * If the user pastes an image, the src attribute
       * will represent the image as a base64 encoded string.
       */
      if (child.tagName === 'IMG') {
        this.createImage(child.src)
          .then((blob) => capella.uploader.uploadBlob(blob))
          .catch(console.log);
      }
    }
  }

  /**
   * Creates a new blob image from a given source
   *
   * @param {string} source - uri to blob image "blob:http://..."
   *
   * @returns {Promise<Blob>}
   */
  createImage(source) {
    return new Promise((resolve, reject) => {
      let pastedImage = new Image();

      pastedImage.onload = () => {
        /** Try to get blob image by it's source url */
        this.loadXHR(source)
          .then(resolve)
          .catch(reject);
      };

      pastedImage.src = source;
    });
  }

  /**
   * Return blob data by url
   * Need to get blob image from blob:http://... path
   *
   * @param {string} url - uri to blob image "blob:http://..."
   *
   * @returns {Promise<Blob>}
   */
  loadXHR(url) {
    return new Promise((resolve, reject) => {
      try {
        let xhr = new XMLHttpRequest();

        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.onerror = function () {
          reject('Network error.');
        };
        xhr.onload = () => {
          if (xhr.status === 200) {
            resolve(xhr.response);
          } else {
            reject('Loading error: ' + xhr.statusText);
          }
        };
        xhr.send();
      } catch(err) {
        reject(err.message);
      }
    });
  }
}

