'use strict';

module.exports = function () {
  const notificationClass = '.js-result__is-copied';
  const notificationTextMobile = '.js-result__copy-text';
  const notificationElement = document.querySelector(notificationClass);
  const showTimeout = 3500;
  let notificationIsVisibleTimer;
  let textIsChangedTimer;

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
    if (textIsChangedTimer) {
      clearTimeout(textIsChangedTimer);
    }

    const cachedText = this.innerHTML;

    this.innerHTML =  'Copied';

    textIsChangedTimer = setTimeout(function () {
      document.querySelector(notificationTextMobile).innerHTML = cachedText;
    }, showTimeout);
  };

  return {
    toggleCopiedIcon : toggleCopiedIcon,
    toggleButtonText : toggleButtonText
  };
}();
