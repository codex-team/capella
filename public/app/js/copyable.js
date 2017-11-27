/**
  * Copyable module allows you to add text to copy buffer by click
  * Just add 'js-copyable' name to element and call init method
  *
  * @usage
  * <span name='js-copyable'>Click to copy</span>
  *
  * You can pass callback function to init method. Callback will fire when something has copied
  *
  * @type {{init}}
  */
module.exports = function () {
  const NAMES = {
    copyable: 'js-copyable',
    authorized: 'js-copyable-authorize'
  };

  /**
   * Take element by name and pass it to prepareElement function
   *
   * @param {Function} copiedCallback - fires when something has copied
   */
  let init = function (copiedCallback) {
    let elems = document.getElementsByName(NAMES.copyable);

    if (!elems) {
      console.log('There are no copyable elements');
      return;
    }

    for (let i = 0; i < elems.length; i++) {
      prepareElement(elems[i], copiedCallback);
    }

    let authorizedElems = document.getElementsByName(NAMES.authorized);

    for (let i = 0; i < authorizedElems.length; i++) {
      authorize(authorizedElems[i]);
    }

    console.log('Copyable module initialized');

    this.clipboardButton = document.querySelector('.js-result__copy-text');
    this.copiedLink = document.querySelector('.js-result__copy-link');

    if (this.clipboardButton) {
      this.clipboardButton.addEventListener('click', toggleButtonText, false);
    }

    if (this.copiedLink) {
      this.copiedLink.addEventListener('click', toggleCopiedIcon, false);
    }
  };

  /**
   * Add click and copied listeners to copyable element
   *
   * @param element
   * @param copiedCallback
   */
  let prepareElement = function (element, copiedCallback) {
    element.addEventListener('click', elementClicked);
    element.addEventListener('copied', copiedCallback);
  };

  /**
   * Add click listener for authorized element
   *
   * @param element
   */
  let authorize = function (element) {
    element.addEventListener('click', authorizedCopy);
  };

  /**
   * Change clicked elem's text
   */
  let toggleButtonText = function () {
    const cachedText = this.innerHTML;

    this.innerHTML =  'Copied';

    setTimeout(function () {
      document.querySelector('.js-result__copy-text').innerHTML = cachedText;
    }, 3500);
  };

  /**
   * Show Copied notification on desktop
   */
  let toggleCopiedIcon = function (event) {
    let notificationClass = '.js-result__copied-desktop';
    let urlClass = '.js-result__copy-link';
    let notificationElement = document.querySelector(notificationClass);

    notificationElement.classList.remove('invisible');

    let iteration = setTimeout(function () {
      notificationElement.classList.add('invisible');
    }, 3500);

    if (event.ctrlKey || event.metaKey || event.mousewheel || event.which == 2) {
      let url = document.querySelector(urlClass).innerHTML;

      window.open(url, '_blank');
    }
    clearTimeout(iteration);
  };

  /**
   * Click handler for authorized elements
   */
  let authorizedCopy = function () {
    let authorizedElem = this;
    let copyable = authorizedElem.querySelector('[name='+NAMES.copyable+']');

    copyable.click();
  };

  /**
   * Click handler
   * Create new range, select copyable element and add range to selection. Then exec 'copy' command
   */
  let elementClicked = function (event) {
    let selection = window.getSelection(),
        range     = document.createRange();

    range.selectNodeContents(this);
    selection.removeAllRanges();
    selection.addRange(range);

    document.execCommand('copy');
    selection.removeAllRanges();

    /**
     * We create new CustomEvent and dispatch it on copyable element
     * Consist copied text in detail property
     */
    let CopiedEvent = new CustomEvent('copied', {
      bubbles: false,
      cancelable: false,
      detail: range.toString()
    });

    this.dispatchEvent(CopiedEvent);
    event.stopPropagation();
  };

  return {
    init: init
  };
}();