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
    /**
     * items - data from clipboard
     */
    let items = (event.clipboardData  || event.originalEvent.clipboardData || window.clipboardData).items;
    let data = (event.clipboardData  || event.originalEvent.clipboardData || window.clipboardData).getData('Text');
    let blob = null;

    /*
     * Stop data actually being pasted into document {default settings}
     */
    event.stopPropagation();
    event.preventDefault();

    /*
     * Checking if clipboard has a link
     */
    if (data) {
      /**
       * Parsing on valid URL
       */
      if (data.match(/^((http[s]?):\/)?\/?([^:\/\s]+)((\/\w+)*\/)([\w\-\.]+[^#?\s]+)(.*)?(#[\w\-]+)?$/)) {
        capella.uploader.upload({'link': data});
      }
    } else if (items) {
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
