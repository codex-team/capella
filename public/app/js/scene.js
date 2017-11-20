'use strict';

module.exports = (function () {
  let mainContainer = document.getElementsByClassName('capella')[0];
  let progressBar = document.getElementsByClassName('js-capella__uploading-progress')[0];

  let uploadScreen = {
    show: function () {
      mainContainer.classList.add('capella--loading');
    },

    hide: function () {
      mainContainer.classList.remove('capella--loading');
    },

    progress: function (percents) {
      progressBar.setAttribute('value', percents);
    }
  };

  return {
    uploadScreen
  };
}());
