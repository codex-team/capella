'use strict';

/**
 * Class to control upload screen appearance
 *
 * @property {HTMLElement} mainContainer — page wrapper
 * @property {HTMLElement} progressBar — progress bar slider element
 * @property {String} loadingClass — upload screen class
 *
 */
export default class UploadScreen {
  /**
   * @constructor
   * Get needed elements from page
   */
  constructor() {
    this.mainContainer = document.querySelector('.capella');
    this.progressBar = document.querySelector('.js-capella__uploading-progress');
    this.loadingClass = 'capella--loading';
  }

  /**
   * Show loading screen by adding loadingClass to page wrapper
   *
   * @param {String} filename — file which is uploading now
   */
  show(filename) {
    let filenameHolder = this.mainContainer.querySelector('.capella__uploading-filename');

    filenameHolder.textContent = filename;
    this.mainContainer.classList.add(this.loadingClass);
  }

  /**
   * Hide loading screen by removing loadingClass from page wrapper
   */
  hide() {
    this.mainContainer.classList.remove(this.loadingClass);
  }

  /**
   * Method to control loading progress bar
   *
   * @param {Number} percents — uploading percentage
   */
  progress(percents) {
    this.progressBar.style.width = percents + '%';
  }
}