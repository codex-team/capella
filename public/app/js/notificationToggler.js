'use strict';

module.exports = function () {
  /* Class of 'Copied' notification element*/
  const notificationClass = '.js-result__is-copied';
  /* Class used to hide notification after showTimeout*/
  const notificationHideClass = 'js-hidden';
  /* 'Copied' notification element*/
  const notificationElement = document.querySelector(notificationClass);
  /* Timeout after which notificationElement will be hidden*/
  const showTimeout = 2000;
  /* Timer to hide notification on desktop*/
  let notificationIsVisibleTimer;

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

  return {
    toggleCopiedIcon : toggleCopiedIcon
  };
}();
