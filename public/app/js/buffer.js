let Clipboard = function () {
  'use strict';

  document.body.addEventListener('paste', pasteFromClipboard);

  /**
   * Pasted image from clipboard
   */
  function pasteFromClipboard(e) {
    document.body.appendChild(text);
    let items = (e.clipboardData  || e.originalEvent.clipboardData).items;
    let blob = null;

    for (let i = 0; i < items.length; i++) {
      if (items[i].type.indexOf('image') === 0) {
        blob = items[i].getAsFile();
      }
    }

    if (blob !== null) {
      let reader = new FileReader();

      reader.onload = function (event) {
        let formData = new FormData();

        formData.append('files', blob, blob.name);
        send(formData);
      };
      reader.readAsDataURL(blob);
    }
  }

  /**
   * Send image to the server
   *
   * @param {data} - data of the file
   */
  function send(data) {
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
}();