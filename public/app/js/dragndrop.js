/**
 *
 */
export default class DNDFileUploader {
  /**
   *
   * @param dropzone
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
   * @param event
   */
  dragover(event) {
    event.preventDefault();

    this.wrapper.classList.add('capella--dark');
  }

  /**
   *
   * @param event
   */
  drageleave(event) {
    event.preventDefault();

    this.wrapper.classList.remove('capella--dark');
  }

  /**
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