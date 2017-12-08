'use strict';


/**
 * TEMP fix. Detect Safari and add class to body
 */
module.exports = function () {
  let init = function () {
    let userAgent = window.navigator.userAgent;

    if (userAgent.indexOf('Safari') >= 0 && userAgent.indexOf('Chrome') < 0) {
      document.body.classList.add('safari');
    }
  };

  return {
    init
  };
}();
