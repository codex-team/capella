'use strict';

module.exports = (function () {
  let mainContainer = document.getElementsByClassName('capella')[0];
  let progressBar = document.getElementsByClassName('js-capella__uploading-progress')[0];
  let loadingClass = 'capella--loading';

  let uploadScreen = {
    show: function (filename) {
      let filenameHolder = mainContainer.querySelector('.capella__uploading-filename');

      filenameHolder.textContent = filename;
      mainContainer.classList.add(loadingClass);
    },

    hide: function () {
      mainContainer.classList.remove(loadingClass);
    },

    progress: function (percents) {
      progressBar.style.width = percents + '%';
    }
  };

  return {
    uploadScreen
  };
}());
