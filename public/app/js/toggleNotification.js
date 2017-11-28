'use strict';

module.exports = function () {
  const notificationClass = '.js-result__copied-desktop';
  const notificationTextMobile = '.js-result__copy-text';
  const notificationElement = document.querySelector(notificationClass);
  const showTimeout = 3500;
  let notificationIsVisibleTimer;

  /**
   * Show and hide after showTimeout seconds copy notification
   */
  let toggleCopiedIcon = function (event) {
    if (notificationIsVisibleTimer) {
      clearTimeout(notificationIsVisibleTimer);
    }

    notificationElement.classList.remove('js-hidden');
    notificationIsVisibleTimer = setTimeout(function () {
      notificationElement.classList.add('js-hidden');
    }, showTimeout);

    if (!event.ctrlKey && !event.metaKey && event.which != 2) {
      event.preventDefault();
    }
  };

  /**
   * Change clicked elem's text
   */
  let toggleButtonText = function () {
    const cachedText = this.innerHTML;

    this.innerHTML =  'Copied';

    setTimeout(function () {
      document.querySelector(notificationTextMobile).innerHTML = cachedText;
    }, showTimeout);
  };

  return {
    toggleCopiedIcon : toggleCopiedIcon,
    toggleButtonText : toggleButtonText
  };
}();
