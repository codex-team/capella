'use strict';

module.exports = function () {
  /* Class of 'Copied' notification element*/
  const notificationClass = '.js-result__is-copied';
  /* Class used to hide notification after showTimeout*/
  const notificationHideClass = 'js-hidden';
  /* Class for copy-button in mobile*/
  const notificationTextMobileClass = '.js-result__copy-text';
  /* 'Copied' notification element*/
  const notificationElement = document.querySelector(notificationClass);
  /* Timeout after which notificationElement will be hidden*/
  const showTimeout = 2000;
  /* Timer to hide notification on desktop*/
  let notificationIsVisibleTimer;
  /* Timer to change back text on copy-button in mobile*/
  let textIsChangedTimer;

  /**
   * Show and hide after showTimeout seconds copy-notifications, on desktop
   */
  let toggleCopiedIcon = function (event) {
    /* Don't open link in new window unless one of these keys is pressed*/
    if (event.ctrlKey || event.metaKey || event.which == 2) {
      return false;
    } else {
      event.preventDefault();
    }

    /* Clear timer if it was set previously*/
    if (notificationIsVisibleTimer) {
      clearTimeout(notificationIsVisibleTimer);
    }

    /* First reveal zero-opacity notification elem, then after timeout hide it again*/
    notificationElement.classList.remove(notificationHideClass);
    notificationIsVisibleTimer = setTimeout(function () {
      notificationElement.classList.add(notificationHideClass);
    }, showTimeout);
  };

  /**
   * Change clicked elem's text, in mobile
   */
  let toggleButtonText = function () {
    /* Clear timer if it was set previously*/
    if (textIsChangedTimer) {
      clearTimeout(textIsChangedTimer);
    }
    /* Cache initial button text-value*/
    const initialTextValue = this.innerHTML;

    /* Change copy-button value to 'Copied'*/
    this.innerHTML =  'Copied';

    /* Set again initial copy-button text-value after timeout*/
    textIsChangedTimer = setTimeout(function () {
      document.querySelector(notificationTextMobileClass).innerHTML = initialTextValue;
    }, showTimeout);
  };

  return {
    toggleCopiedIcon : toggleCopiedIcon,
    toggleButtonText : toggleButtonText
  };
}();
