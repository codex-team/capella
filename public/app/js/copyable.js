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
    this.button = document.querySelector('.js-result__copy-text');
    selectButton(this.button);

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
  };

  /**
   * Select elem to change text
   *
   * @param element
   */
  let selectButton = function (element) {
    element.addEventListener('click', changeText);
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
  let changeText = function () {
    this.innerHTML = 'Copied';
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