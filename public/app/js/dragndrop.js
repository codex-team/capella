/**
 * Class for working with drag and drop files to browser
 */
export default class DNDFileUploader {
  /**
   * Bind drag and drop events
   *
   * @param wrapper - page wrapper selector
   */
  constructor(wrapper) {
    this.wrapper = document.querySelector(wrapper);

    this.wrapper.addEventListener('dragenter', this.dragover.bind(this));
    this.wrapper.addEventListener('dragover', this.dragover.bind(this));
    this.wrapper.addEventListener('dragleave', this.drageleave.bind(this));
    this.wrapper.addEventListener('drop', this.drop.bind(this));
  }

  /**
   *
   * File dragover handler
   *
   * @param event
   */
  dragover(event) {
    event.preventDefault();

    this.wrapper.classList.add('capella--dark');
  }

  /**
   *
   * File dragleave handler
   *
   * @param event
   */
  drageleave(event) {
    event.preventDefault();

    this.wrapper.classList.remove('capella--dark');
  }

  /**
   * File drop handler
   *
   * @param event
   */
  drop(event) {
    this.wrapper.classList.remove('capella--dark');

    this.upload(event.dataTransfer.files[0]);
    event.preventDefault();
  }

  /**
   *
   * Upload file to server via AJAX
   *
   * @param file
   */
  upload(file) {
    let formData = new FormData();

    formData.append('file', file, file.name);

    capella.ajax.call({
      type: 'POST',
      url: '/upload',
      data: formData,
      before() {},
      progress(percentage) {
        console.log(percentage + '%');
      },
      success(response) {
        console.log(response);

        if (response.success) {
          /** Redirect to uploaded image */
          window.location.href = response.url;
        }
      },
      error(response) {
        console.log(response);
      },
      after() {}
    });
  }
}