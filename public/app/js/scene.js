'use strict';

module.exports = (function () {
  let mainContainer = document.getElementsByClassName('capella')[0];
  let progressBar = document.getElementsByClassName('js-capella__uploading-progress')[0].querySelector('div');

  let uploadScreen = {
    show: function () {
      mainContainer.classList.add('capella--loading');
    },

    hide: function () {
      mainContainer.classList.remove('capella--loading');
    },

    progress: function (percents) {
      progressBar.style.width = percents + '%';
    }
  };

  return {
    uploadScreen
  };
}());
