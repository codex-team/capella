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
    let items = (event.clipboardData  || event.originalEvent.clipboardData).items;
    let blob = null;

    /**
     * Checking all clipboard's files and choosing last image file
     */
    for (let i = items.length - 1; i >= 0; --i) {
      if (items[i].type.indexOf('image') === 0) {
        blob = items[i].getAsFile();
        break;
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
