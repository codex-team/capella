let Clipboard = function () {
  'use strict';

  let image = document.createElement('img');
  let text = document.createTextNode('UPLOADING');

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
        document.body.removeChild(text);

        let formData = new FormData();

        formData.append('ImageFile', blob, blob.name);
        send(formData);
      };
      reader.readAsDataURL(blob);
    }
  }

  /**
   * Send image to the server
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

  document.body.appendChild(image);
}();