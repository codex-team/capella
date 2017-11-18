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
        let formData = new FormData();

        formData.append('files', blob, blob.name);
        Clipboard.send(formData);
      };
      reader.readAsDataURL(blob);
    }
  }

  /**
   * Send image to the server
   *
   * @param {data} - data of the file
   */
  static send(data) {
    capella.ajax.call({
      type: 'POST',
      url: '/upload',
      data: data,
      before() {},
      progress(percentage) {
        console.log(percentage + '%');
      },
      success(response) {
        console.log(response);

        if (response.success) {
          window.location.href = response.url;
        }
      },
      error(response) {
        console.log(response);
      },
      after() {},
    });
  }
}