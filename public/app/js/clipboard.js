/**
 * Paste from clipboard module
 */
export default class Clipboard {
  /**
   * Initialization of Clipboard module
   */
  constructor() {
    document.body.addEventListener('paste', this.pasteFromClipboard);
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
      let regex = '/^((http[s]?):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$/';

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
