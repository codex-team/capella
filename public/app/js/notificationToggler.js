'use strict';

module.exports = function () {
  const CSS = {
    /* Class of 'Copied' notification element */
    notificationClass: '.js-result__is-copied',

    /* Class used to hide notification after showTimeout */
    notificationHideClass: 'js-hidden'
  };

  /* 'Copied' notification element */
  const notificationElement = document.querySelector(CSS.notificationClass);

  /* Timeout after which notificationElement will be hidden */
  const showTimeout = 2000;

  /* Timer to hide notification */
  let notificationIsVisibleTimer;

  /**
   * Show and hide after showTimeout seconds copy-notifications
   */
  let toggleCopiedIcon = function (event) {
    /* Don't open link in new window unless one of these keys is pressed */
    if (event.ctrlKey || event.metaKey || event.which === 2) {
      return false;
    } else {
      event.preventDefault();
    }

    /* Clear timer if it was set previously */
    if (notificationIsVisibleTimer) {
      clearTimeout(notificationIsVisibleTimer);
    }

    /* First reveal zero-opacity notification elem, then after timeout hide it again */
    notificationElement.classList.remove(CSS.notificationHideClass);
    notificationIsVisibleTimer = setTimeout(function () {
      notificationElement.classList.add(CSS.notificationHideClass);
    }, showTimeout);
  };

  return {
    toggleCopiedIcon : toggleCopiedIcon
  };
}();
