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
    let pasteCatcher;

    /**
     * We start by checking if the browser supports the
     * Clipboard object. If not, we need to create a
     * contenteditable element that catches all pasted data
     */
    if (!window.Clipboard) {
      pasteCatcher = document.createElement('DIV');

      /** Firefox allows images to be pasted into contenteditable elements */
      pasteCatcher.setAttribute('contenteditable', '');

      /** We can hide the element and append it to the body */
      pasteCatcher.style.opacity = 0;
      document.body.appendChild(pasteCatcher);

      /** as long as we make sure it is always in focus */
      pasteCatcher.focus();
      document.addEventListener('click', () => {
        pasteCatcher.focus();
      });
    }

    /** Add the paste event listener */
    document.body.addEventListener('paste', pasteHandler);

    /**
     * Handle paste events
     */
    function pasteHandler(e) {
      console.log('PASTER WAS CALLED');
      // We need to check if event.clipboardData is supported (Chrome)
      var isChrome = /Chrome/.test(window.navigator.userAgent) && /Google Inc/.test(window.navigator.vendor);

      if (e.clipboardData && isChrome) {
        /** Get the items from the clipboard */
        let items = e.clipboardData.items;

        if (items) {
          // Loop through all items, looking for any kind of image
          for (let i = 0; i < items.length; i++) {
            if (items[i].type.indexOf('image') !== -1) {
              // We need to represent the image as a file,
              let blob = items[i].getAsFile();

              // and use a URL or webkitURL (whichever is available to the browser)
              // to create a temporary URL to the object
              let URLObj = window.URL || window.webkitURL;
              let source = URLObj.createObjectURL(blob);

              // The URL can then be used as the source of an image
              createImage(source);
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
        setTimeout(checkInput, 1);
      }
    }

    /**
     * Parse the input in the paste catcher element
     */
    function checkInput() {
      // Store the pasted content in a variable
      var child = pasteCatcher.childNodes[0];

      // Clear the inner html to make sure we're always
      // getting the latest inserted content
      pasteCatcher.innerHTML = '';

      console.log(child);


      if (child) {
        console.log(child);
        // If the user pastes an image, the src attribute
        // will represent the image as a base64 encoded string.
        if (child.tagName === 'IMG') {
          createImage(child.src);
        }
      }
    }

    /**
     * Load blob data by url
     * Need to get blob image from blob:http://... path
     *
     * @param url
     *
     * @returns {Promise<any>}
     */
    function loadXHR(url) {
      return new Promise(function (resolve, reject) {
        try {
          var xhr = new XMLHttpRequest();

          xhr.open('GET', url);
          xhr.responseType = 'blob';
          xhr.onerror = function () {
            reject('Network error.');
          };
          xhr.onload = function () {
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

    /**
     * Creates a new image from a given source
     */
    function createImage(source) {
      let pastedImage = new Image();

      pastedImage.onload = function () {
        // You now have the image!
        loadXHR(source)
          .then(function (blob) {
            let reader = new FileReader();

            reader.onload = function () {
              capella.uploader.uploadBlob(blob);
            };
            reader.readAsDataURL(blob);
          })
          .catch(console.log);
        console.log('IMAGE: ', pastedImage);
      };
      pastedImage.src = source;
    }
  }

  /**
   * Pasted image from clipboard
   */
  pasteFromClipboard(event) {
    let clipboard = (event.clipboardData  || event.originalEvent.clipboardData || window.clipboardData);

    /**
     * items - for images
     * data - for links
     */
    let items = clipboard.items;
    let data = clipboard.getData('Text');
    let blob = null;

    event.stopPropagation();
    event.preventDefault();

    /**
     * Checking if clipboard has a link
     */
    if (data) {
      /**
       * Parsing on valid URL
       */
      let regex = /^((http[s]?):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$/;

      if (data.match(regex)) {
        capella.uploader.upload({'link': data});
      } else {
        document.getElementById('uploadLinkField').value = data;
      }
    }

    if (items) {
      /**
       * Checking all clipboard's files and choosing last image file
       */
      for (let i = items.length - 1; i >= 0; --i) {
        if (items[i].type.indexOf('image') === 0) {
          blob = items[i].getAsFile();
          break;
        }
      }
    }

    if (blob !== null) {
      /**
       * FilerReader is used for asynchronous image reading from blob: function at onload
       */
      let reader = new FileReader();

      reader.onload = function () {
        capella.uploader.uploadBlob(blob);
      };
      reader.readAsDataURL(blob);
    }
  }
}

