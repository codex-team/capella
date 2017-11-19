/**
 *
 */
export default class DNDFileUploader {
  /**
   *
   * @param dropzone
   */
  constructor(dropzone, borderzone) {
    this.dropzone = document.querySelector(dropzone);
    this.borderzone = document.querySelector(borderzone);

    this.dropzone.addEventListener('dragenter', this.dragover.bind(this));
    this.dropzone.addEventListener('dragover', this.dragover.bind(this));
    this.dropzone.addEventListener('dragleave', this.drageleave.bind(this));
    this.dropzone.addEventListener('drop', this.drop.bind(this));
  }

  /**
   *
   * @param event
   */
  dragover(event) {
    event.preventDefault();

    this.dropzone.classList.add('capella--dragover');
    this.borderzone.classList.add('capella__drag-n-drop--dragover');
  }

  /**
   *
   * @param event
   */
  drageleave(event) {
    event.preventDefault();

    this.dropzone.classList.remove('capella--dragover');
    this.borderzone.classList.remove('capella__drag-n-drop--dragover');
  }

  /**
   *
   * @param event
   */
  drop(event) {
    this.dropzone.classList.remove('capella--dragover');
    this.borderzone.classList.remove('capella__drag-n-drop--dragover');

    this.upload(event.dataTransfer.files[0]);
    event.preventDefault();
  }

  /**
   *
   * @param file
   */
  upload(file) {
    let formData = new FormData();

    formData.append('files', file, file.name);

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