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

      /** as long as we make sure it is always in focus */
      this.pasteCatcher.focus();
      document.addEventListener('click', () => {
        this.pasteCatcher.focus();
      });

      /**
       * Add paste listener
       */
      document.body.addEventListener('paste', event => {
        this.pasteHandler(event);
      });

      // /**
      //  * Add paste listener for catcher
      //  */
      // this.pasteCatcher.addEventListener('paste', event => {
      //   event.stopPropagation();
      //   this.pasteHandler(event);
      // });
      //
      // /**
      //  * Add global listener which will dispatch event
      //  */
      // document.body.addEventListener('paste', event => {
      //   event.stopPropagation();
      //   event.preventDefault();
      //   this.pasteCatcher.dispatchEvent(event);
      // });
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
   * Handle Image paste events
   */
  pasteImageHandler(event) {
    /**
     * We need to check if event.clipboardData is supported (Chrome)
     */
    let isChrome = /Chrome/.test(window.navigator.userAgent) && /Google Inc/.test(window.navigator.vendor);

    if (event.clipboardData && isChrome) {
      /**
       * Prevent pasting image data
       */
      event.preventDefault();

      /** Get the items from the clipboard */
      let items = event.clipboardData.items;

      if (items) {
        /** Loop through all items, looking for any kind of image */
        for (let i = 0; i < items.length; i++) {
          if (items[i].type.indexOf('image') !== -1) {
            /** We need to represent the image as a file */
            let blob = items[i].getAsFile();

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
      setTimeout(() => this.checkPasteCatcher(), 1);
    }
  }

  /**
   * Parse the input in the paste catcher element
   */
  checkPasteCatcher() {
    if (!this.pasteCatcher) {
      return;
    }

    /** Store the pasted content in a variable */
    let child = this.pasteCatcher.childNodes[0];

    /**
     * Clear the inner html to make sure we're always
     * getting the latest inserted content
     */
    this.pasteCatcher.innerHTML = '';

    if (child) {
      console.log(child);
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
   * @param source
   *
   * @returns {Promise<any>}
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
   * @param url
   *
   * @returns {Promise<any>}
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

