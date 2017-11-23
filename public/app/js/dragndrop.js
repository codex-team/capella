/**
 * Class for working with drag and drop files to browser
 *
 * @class DNDFileUploader
 *
 * @property {HTMLElement} wrapper — page wrapper element
 *
 */
export default class DNDFileUploader {
  /**
   * Bind drag and drop events
   *
   * @param {String} wrapper - page wrapper selector
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
   * @param {Event} event — dragover event
   */
  dragover(event) {
    event.preventDefault();

    this.wrapper.classList.add('capella--dark');
  }

  /**
   *
   * File dragleave handler
   *
   * @param {Event} event — dragleave event
   */
  drageleave(event) {
    event.preventDefault();

    this.wrapper.classList.remove('capella--dark');
  }

  /**
   * File drop handler
   *
   * @param {Event} event — drop event
   */
  drop(event) {
    this.wrapper.classList.remove('capella--dark');

    let file = event.dataTransfer.files[0];

    capella.uploader.uploadBlob(file);

    event.preventDefault();
  }
}