var capella =
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./public/app/entry.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/codex.ajax/lib/bundle.js":
/*!***********************************************!*\
  !*** ./node_modules/codex.ajax/lib/bundle.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("!function(t,e){ true?module.exports=e():undefined}(this,function(){return function(t){function e(r){if(n[r])return n[r].exports;var a=n[r]={i:r,l:!1,exports:{}};return t[r].call(a.exports,a,a.exports,e),a.l=!0,a.exports}var n={};return e.m=t,e.c=n,e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,\"a\",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p=\"\",e(e.s=0)}([function(t,e,n){\"use strict\";t.exports=function(){var t=function(t){return t instanceof FormData};return{call:function(e){if(e&&e.url){var n=window.XMLHttpRequest?new window.XMLHttpRequest:new window.ActiveXObject(\"Microsoft.XMLHTTP\"),r=e.progress||null,a=e.success||function(){},o=e.error||function(){},u=e.before||null,i=e.after?e.after.bind(null,e.data):null;if(e.async=!0,e.type=e.type||\"GET\",e.data=e.data||\"\",e[\"content-type\"]=e[\"content-type\"]||\"application/json; charset=utf-8\",\"GET\"===e.type&&e.data&&(e.url=/\\?/.test(e.url)?e.url+\"&\"+e.data:e.url+\"?\"+e.data),e.withCredentials&&(n.withCredentials=!0),u&&\"function\"==typeof u){if(!1===u(e.data))return}if(n.open(e.type,e.url,e.async),!t(e.data)){var c=new FormData;for(var f in e.data)c.append(f,e.data[f]);e.data=c}r&&\"function\"==typeof r&&n.upload.addEventListener(\"progress\",function(t){var e=parseInt(t.loaded/t.total*100);r(e)},!1),n.setRequestHeader(\"X-Requested-With\",\"XMLHttpRequest\"),n.onreadystatechange=function(){if(4===n.readyState){var t=n.responseText;try{t=JSON.parse(t)}catch(t){}200===n.status?a(t):o(t),i&&\"function\"==typeof i&&i()}},n.send(e.data)}}}}()}])});\n//# sourceMappingURL=bundle.js.map\n\n//# sourceURL=webpack://capella/./node_modules/codex.ajax/lib/bundle.js?");

/***/ }),

/***/ "./node_modules/codex.transport/lib/bundle.js":
/*!****************************************************!*\
  !*** ./node_modules/codex.transport/lib/bundle.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("!function(t,e){ true?module.exports=e():undefined}(this,function(){return function(t){function e(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,e),o.l=!0,o.exports}var n={};return e.m=t,e.c=n,e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,\"a\",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p=\"\",e(e.s=0)}([function(t,e,n){\"use strict\";var r=\"function\"==typeof Symbol&&\"symbol\"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&\"function\"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?\"symbol\":typeof t},o=n(1);t.exports=function(t){var e=null;t.input=null;var n=function(){t.input.click()},u=function(){e.before(t.input.files)},a=function(){var n=e.url,a=e.data,i=u,c=e.progress,f=e.success,s=e.error,p=e.after,l=new FormData,d=t.input.files;if(d.length>1)for(var y=0;y<d.length;y++)l.append(\"files[]\",d[y],d[y].name);else l.append(\"file\",d[0],d[0].name);if(null!==a&&\"object\"===(void 0===a?\"undefined\":r(a)))for(var b in a)l.append(b,a[b]);o.call({type:\"POST\",data:l,url:n,before:i,progress:c,success:f,error:s,after:p})};return t.init=function(r){if(!r.url)return void console.log(\"Can't send request because `url` is missed\");e=r;var o=document.createElement(\"INPUT\");o.type=\"file\",e&&e.multiple&&o.setAttribute(\"multiple\",\"multiple\"),e&&e.accept&&o.setAttribute(\"accept\",e.accept),o.addEventListener(\"change\",a,!1),t.input=o,n()},t}({})},function(t,e,n){!function(e,n){t.exports=n()}(0,function(){return function(t){function e(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,e),o.l=!0,o.exports}var n={};return e.m=t,e.c=n,e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,\"a\",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p=\"\",e(e.s=0)}([function(t,e,n){\"use strict\";t.exports=function(){var t=function(t){return t instanceof FormData};return{call:function(e){if(e&&e.url){var n=window.XMLHttpRequest?new window.XMLHttpRequest:new window.ActiveXObject(\"Microsoft.XMLHTTP\"),r=e.progress||null,o=e.success||function(){},u=e.error||function(){},a=e.before||null,i=e.after?e.after.bind(null,e.data):null;if(e.async=!0,e.type=e.type||\"GET\",e.data=e.data||\"\",e[\"content-type\"]=e[\"content-type\"]||\"application/json; charset=utf-8\",\"GET\"===e.type&&e.data&&(e.url=/\\?/.test(e.url)?e.url+\"&\"+e.data:e.url+\"?\"+e.data),e.withCredentials&&(n.withCredentials=!0),a&&\"function\"==typeof a&&!1===a(e.data))return;if(n.open(e.type,e.url,e.async),!t(e.data)){var c=new FormData;for(var f in e.data)c.append(f,e.data[f]);e.data=c}r&&\"function\"==typeof r&&n.upload.addEventListener(\"progress\",function(t){var e=parseInt(t.loaded/t.total*100);r(e)},!1),n.setRequestHeader(\"X-Requested-With\",\"XMLHttpRequest\"),n.onreadystatechange=function(){if(4===n.readyState){var t=n.responseText;try{t=JSON.parse(t)}catch(t){}200===n.status?o(t):u(t),i&&\"function\"==typeof i&&i()}},n.send(e.data)}}}}()}])})}])});\n//# sourceMappingURL=bundle.js.map\n\n//# sourceURL=webpack://capella/./node_modules/codex.transport/lib/bundle.js?");

/***/ }),

/***/ "./node_modules/exports-loader/index.js?notifier!./node_modules/codex-notifier/notifier.js":
/*!****************************************************************************************!*\
  !*** ./node_modules/exports-loader?notifier!./node_modules/codex-notifier/notifier.js ***!
  \****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("var notifier=function(e){function t(r){if(n[r])return n[r].exports;var c=n[r]={i:r,l:!1,exports:{}};return e[r].call(c.exports,c,c.exports,t),c.l=!0,c.exports}var n={};return t.m=e,t.c=n,t.i=function(e){return e},t.d=function(e,n,r){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:r})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,\"a\",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p=\"\",t(t.s=2)}([function(e,t,n){\"use strict\";e.exports=function(){var e={wrapper:\"cdx-notifies\",notification:\"cdx-notify\",crossBtn:\"cdx-notify__cross\",okBtn:\"cdx-notify__button--confirm\",cancelBtn:\"cdx-notify__button--cancel\",input:\"cdx-notify__input\",btn:\"cdx-notify__button\",btnsWrapper:\"cdx-notify__btns-wrapper\"},t=function(t){var n=document.createElement(\"DIV\"),r=document.createElement(\"DIV\"),c=t.message,i=t.style;return n.classList.add(e.notification),i&&n.classList.add(e.notification+\"--\"+i),n.innerHTML=c,r.classList.add(e.crossBtn),r.addEventListener(\"click\",n.remove.bind(n)),n.appendChild(r),n};return{alert:t,confirm:function(n){var r=t(n),c=document.createElement(\"div\"),i=document.createElement(\"button\"),a=document.createElement(\"button\"),o=r.querySelector(e.crossBtn),d=n.cancelHandler,s=n.okHandler;return c.classList.add(e.btnsWrapper),i.innerHTML=n.okText||\"Confirm\",a.innerHTML=n.cancelText||\"Cancel\",i.classList.add(e.btn),a.classList.add(e.btn),i.classList.add(e.okBtn),a.classList.add(e.cancelBtn),d&&\"function\"==typeof d&&(a.addEventListener(\"click\",d),o.addEventListener(\"click\",d)),s&&\"function\"==typeof s&&i.addEventListener(\"click\",s),i.addEventListener(\"click\",r.remove.bind(r)),a.addEventListener(\"click\",r.remove.bind(r)),c.appendChild(i),c.appendChild(a),r.appendChild(c),r},prompt:function(n){var r=t(n),c=document.createElement(\"div\"),i=document.createElement(\"button\"),a=document.createElement(\"input\"),o=r.querySelector(e.crossBtn),d=n.cancelHandler,s=n.okHandler;return c.classList.add(e.btnsWrapper),i.innerHTML=n.okText||\"Ok\",i.classList.add(e.btn),i.classList.add(e.okBtn),a.classList.add(e.input),n.placeholder&&a.setAttribute(\"placeholder\",n.placeholder),n.default&&(a.value=n.default),n.inputType&&(a.type=n.inputType),d&&\"function\"==typeof d&&o.addEventListener(\"click\",d),s&&\"function\"==typeof s&&i.addEventListener(\"click\",function(){s(a.value)}),i.addEventListener(\"click\",r.remove.bind(r)),c.appendChild(a),c.appendChild(i),r.appendChild(c),r},wrapper:function(){var t=document.createElement(\"DIV\");return t.classList.add(e.wrapper),t}}}()},function(e,t){},function(e,t,n){\"use strict\";/*!\n * Codex JavaScript Notification module\n * https://github.com/codex-team/js-notifier\n *\n * Codex Team - https://ifmo.su\n *\n * MIT License | (c) Codex 2017\n */\ne.exports=function(){function e(){if(i)return!0;i=r.wrapper(),document.body.appendChild(i)}function t(t){if(t.message){e();var n=null,a=t.time||8e3;switch(t.type){case\"confirm\":n=r.confirm(t);break;case\"prompt\":n=r.prompt(t);break;default:n=r.alert(t),window.setTimeout(function(){n.remove()},a)}i.appendChild(n),n.classList.add(c)}}n(1);var r=n(0),c=\"cdx-notify--bounce-in\",i=null;return{show:t}}()}]);\n\n/*** EXPORTS FROM exports-loader ***/\nmodule.exports = notifier;\n\n//# sourceURL=webpack://capella/./node_modules/codex-notifier/notifier.js?./node_modules/exports-loader?notifier");

/***/ }),

/***/ "./public/app/css/main.css":
/*!*********************************!*\
  !*** ./public/app/css/main.css ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("// removed by extract-text-webpack-plugin\n\n//# sourceURL=webpack://capella/./public/app/css/main.css?");

/***/ }),

/***/ "./public/app/entry.js":
/*!*****************************!*\
  !*** ./public/app/entry.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n/**\n * Require CSS build\n */\n__webpack_require__(/*! ./css/main.css */ \"./public/app/css/main.css\");\n\nmodule.exports = __webpack_require__(/*! ./js/main.js */ \"./public/app/js/main.js\");\n\n//# sourceURL=webpack://capella/./public/app/entry.js?");

/***/ }),

/***/ "./public/app/js/checkForSafari.js":
/*!*****************************************!*\
  !*** ./public/app/js/checkForSafari.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n/**\n * TEMP fix. Detect Safari and add class to body\n */\n\nmodule.exports = function () {\n  var init = function init() {\n    var userAgent = window.navigator.userAgent;\n\n    if (userAgent.indexOf('Safari') >= 0 && userAgent.indexOf('Chrome') < 0) {\n      document.body.classList.add('safari');\n    }\n  };\n\n  return {\n    init: init\n  };\n}();\n\n//# sourceURL=webpack://capella/./public/app/js/checkForSafari.js?");

/***/ }),

/***/ "./public/app/js/clipboard.js":
/*!************************************!*\
  !*** ./public/app/js/clipboard.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nObject.defineProperty(exports, \"__esModule\", {\n  value: true\n});\n\nvar _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\n/**\n * Paste from clipboard module\n *\n * Thanks to http://joelb.me/blog/2011/code-snippet-accessing-clipboard-images-with-javascript/\n */\nvar Clipboard = function () {\n  /**\n   * Initialization of Clipboard module\n   */\n  function Clipboard() {\n    var _this = this;\n\n    _classCallCheck(this, Clipboard);\n\n    this.pasteCatcher = null;\n\n    /**\n     * We start by checking if the browser supports the\n     * Clipboard object. If not, we need to create a\n     * contenteditable element that catches all pasted data\n     */\n    if (!window.Clipboard) {\n      this.pasteCatcher = document.createElement('DIV');\n\n      /** Safari allows images to be pasted into contenteditable elements */\n      this.pasteCatcher.setAttribute('contenteditable', '');\n\n      /** We can hide the element and append it to the body */\n      this.pasteCatcher.style.opacity = 0;\n      document.body.appendChild(this.pasteCatcher);\n\n      /**\n       * Add global paste listener\n       */\n      document.body.addEventListener('paste', function (event) {\n        _this.pasteCatcher.focus();\n        _this.pasteHandler(event);\n      });\n    } else {\n      /**\n       * Add the paste event listener to the page body\n       */\n      document.body.addEventListener('paste', function (event) {\n        _this.pasteHandler(event);\n      });\n    }\n  }\n\n  /**\n   * Paste handler\n   *\n   * @param event\n   */\n\n\n  _createClass(Clipboard, [{\n    key: 'pasteHandler',\n    value: function pasteHandler(event) {\n      // event.stopPropagation();\n\n      var clipboard = event.clipboardData || event.originalEvent.clipboardData || window.clipboardData;\n\n      /**\n       * Checking if clipboard has a link\n       */\n      var data = clipboard.getData('Text');\n\n      if (data) {\n        /**\n         * Prevent pasting text data\n         */\n        event.preventDefault();\n\n        /**\n         * Parsing on valid URL\n         */\n        var regex = /^((http[s]?):\\/)?\\/?([^:\\/\\s]+)((\\/\\w+)*\\/)([\\w\\-\\.]+[^#?\\s]+)(.*)?(#[\\w\\-]+)?$/;\n\n        if (data.match(regex)) {\n          capella.uploader.upload({ 'link': data });\n          return;\n        } else {\n          document.getElementById('uploadLinkField').value = data;\n        }\n      }\n\n      /**\n       * Try to catch pasted image\n       */\n      this.pasteImageHandler(event);\n    }\n\n    /**\n     * Handle Image paste events\n     */\n\n  }, {\n    key: 'pasteImageHandler',\n    value: function pasteImageHandler(event) {\n      var _this2 = this;\n\n      /**\n       * We need to check if event.clipboardData is supported (Chrome)\n       */\n      var isChrome = /Chrome/.test(window.navigator.userAgent) && /Google Inc/.test(window.navigator.vendor);\n\n      if (event.clipboardData && isChrome) {\n        /**\n         * Prevent pasting image data\n         */\n        event.preventDefault();\n\n        /**\n         * Get the items from the clipboard\n         */\n        var items = event.clipboardData.items;\n\n        if (items) {\n          /**\n           * Loop through all items, looking for any kind of image\n           */\n          for (var i = 0; i < items.length; i++) {\n            if (items[i].type.indexOf('image') !== -1) {\n              /**\n               * We need to represent the image as a file\n               */\n              var blob = items[i].getAsFile();\n\n              /**\n               * Upload image blob to server\n               */\n              capella.uploader.uploadBlob(blob);\n\n              break;\n            }\n          }\n        }\n      } else {\n        /**\n         * If we can't handle clipboard data directly (Safari),\n         * we need to read what was pasted from the contenteditable element\n         *\n         * This is a cheap trick to make sure we read the data\n         * AFTER it has been inserted.\n         */\n        setTimeout(function () {\n          return _this2.checkPasteCatcher();\n        }, 1);\n      }\n    }\n\n    /**\n     * Parse the input in the paste catcher element\n     */\n\n  }, {\n    key: 'checkPasteCatcher',\n    value: function checkPasteCatcher() {\n      if (!this.pasteCatcher) {\n        return;\n      }\n\n      /** Store the pasted content in a variable */\n      var child = this.pasteCatcher.childNodes[0];\n\n      /**\n       * Clear the inner html to make sure we're always\n       * getting the latest inserted content\n       */\n      this.pasteCatcher.innerHTML = '';\n\n      if (child) {\n        /**\n         * If the user pastes an image, the src attribute\n         * will represent the image as a base64 encoded string.\n         */\n        if (child.tagName === 'IMG') {\n          this.createImage(child.src).then(function (blob) {\n            return capella.uploader.uploadBlob(blob);\n          }).catch(console.log);\n        }\n      }\n    }\n\n    /**\n     * Creates a new blob image from a given source\n     *\n     * @param source\n     *\n     * @returns {Promise<any>}\n     */\n\n  }, {\n    key: 'createImage',\n    value: function createImage(source) {\n      var _this3 = this;\n\n      return new Promise(function (resolve, reject) {\n        var pastedImage = new Image();\n\n        pastedImage.onload = function () {\n          /** Try to get blob image by it's source url */\n          _this3.loadXHR(source).then(resolve).catch(reject);\n        };\n\n        pastedImage.src = source;\n      });\n    }\n\n    /**\n     * Return blob data by url\n     * Need to get blob image from blob:http://... path\n     *\n     * @param url\n     *\n     * @returns {Promise<any>}\n     */\n\n  }, {\n    key: 'loadXHR',\n    value: function loadXHR(url) {\n      return new Promise(function (resolve, reject) {\n        try {\n          var xhr = new XMLHttpRequest();\n\n          xhr.open('GET', url);\n          xhr.responseType = 'blob';\n          xhr.onerror = function () {\n            reject('Network error.');\n          };\n          xhr.onload = function () {\n            if (xhr.status === 200) {\n              resolve(xhr.response);\n            } else {\n              reject('Loading error: ' + xhr.statusText);\n            }\n          };\n          xhr.send();\n        } catch (err) {\n          reject(err.message);\n        }\n      });\n    }\n  }]);\n\n  return Clipboard;\n}();\n\nexports.default = Clipboard;\n\n//# sourceURL=webpack://capella/./public/app/js/clipboard.js?");

/***/ }),

/***/ "./public/app/js/copyable.js":
/*!***********************************!*\
  !*** ./public/app/js/copyable.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n/**\n  * Copyable module allows you to add text to copy buffer by click\n  * Just add 'js-copyable' name to element and call init method\n  *\n  * @usage\n  * <span name='js-copyable'>Click to copy</span>\n  *\n  * You can pass callback function to init method. Callback will fire when something has copied\n  *\n  * @type {{init}}\n  */\nmodule.exports = function () {\n  var NAMES = {\n    copyable: 'js-copyable',\n    authorized: 'js-copyable-authorize'\n  };\n\n  /**\n   * Take element by name and pass it to prepareElement function\n   *\n   * @param {Function} copiedCallback - fires when something has copied\n   */\n  var init = function init(copiedCallback) {\n    var elems = document.getElementsByName(NAMES.copyable);\n\n    if (!elems) {\n      console.log('There are no copyable elements');\n      return;\n    }\n\n    for (var i = 0; i < elems.length; i++) {\n      prepareElement(elems[i], copiedCallback);\n    }\n\n    var authorizedElems = document.getElementsByName(NAMES.authorized);\n\n    for (var _i = 0; _i < authorizedElems.length; _i++) {\n      authorize(authorizedElems[_i]);\n    }\n\n    console.log('Copyable module initialized');\n\n    this.clipboardButton = document.querySelector('.js-result__copy');\n\n    if (this.clipboardButton) {\n      this.clipboardButton.addEventListener('click', capella.notificationToggler.toggleCopiedIcon, true);\n    }\n  };\n\n  /**\n   * Add click and copied listeners to copyable element\n   *\n   * @param element\n   * @param copiedCallback\n   */\n  var prepareElement = function prepareElement(element, copiedCallback) {\n    element.addEventListener('click', elementClicked);\n    element.addEventListener('copied', copiedCallback);\n  };\n\n  /**\n   * Add click listener for authorized element\n   *\n   * @param element\n   */\n  var authorize = function authorize(element) {\n    element.addEventListener('click', authorizedCopy);\n  };\n\n  /**\n   * Click handler for authorized elements\n   */\n  var authorizedCopy = function authorizedCopy() {\n    var authorizedElem = this;\n    var copyable = authorizedElem.querySelector('[name=' + NAMES.copyable + ']');\n\n    copyable.click();\n  };\n\n  /**\n   * Click handler\n   * Create new range, select copyable element and add range to selection. Then exec 'copy' command\n   */\n  var elementClicked = function elementClicked(event) {\n    var selection = window.getSelection(),\n        range = document.createRange();\n\n    range.selectNodeContents(this);\n    selection.removeAllRanges();\n    selection.addRange(range);\n\n    document.execCommand('copy');\n    selection.removeAllRanges();\n\n    /**\n     * We create new CustomEvent and dispatch it on copyable element\n     * Consist copied text in detail property\n     */\n    var CopiedEvent = new CustomEvent('copied', {\n      bubbles: false,\n      cancelable: false,\n      detail: range.toString()\n    });\n\n    this.dispatchEvent(CopiedEvent);\n    event.stopPropagation();\n  };\n\n  return {\n    init: init\n  };\n}();\n\n//# sourceURL=webpack://capella/./public/app/js/copyable.js?");

/***/ }),

/***/ "./public/app/js/dragndrop.js":
/*!************************************!*\
  !*** ./public/app/js/dragndrop.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nObject.defineProperty(exports, \"__esModule\", {\n  value: true\n});\n\nvar _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\n/**\n * Class for working with drag and drop files to browser\n *\n * @class DNDFileUploader\n *\n * @property {HTMLElement} wrapper — page wrapper element\n *\n */\nvar DNDFileUploader = function () {\n  /**\n   * Bind drag and drop events\n   *\n   * @param {String} wrapper - page wrapper selector\n   */\n  function DNDFileUploader(wrapper) {\n    _classCallCheck(this, DNDFileUploader);\n\n    this.wrapper = document.querySelector(wrapper);\n\n    this.wrapper.addEventListener('dragenter', this.dragover.bind(this));\n    this.wrapper.addEventListener('dragover', this.dragover.bind(this));\n    this.wrapper.addEventListener('dragleave', this.drageleave.bind(this));\n    this.wrapper.addEventListener('drop', this.drop.bind(this));\n  }\n\n  /**\n   *\n   * File dragover handler\n   *\n   * @param {Event} event — dragover event\n   */\n\n\n  _createClass(DNDFileUploader, [{\n    key: 'dragover',\n    value: function dragover(event) {\n      event.preventDefault();\n\n      this.wrapper.classList.add('capella--dark');\n    }\n\n    /**\n     *\n     * File dragleave handler\n     *\n     * @param {Event} event — dragleave event\n     */\n\n  }, {\n    key: 'drageleave',\n    value: function drageleave(event) {\n      event.preventDefault();\n\n      this.wrapper.classList.remove('capella--dark');\n    }\n\n    /**\n     * File drop handler\n     *\n     * @param {Event} event — drop event\n     */\n\n  }, {\n    key: 'drop',\n    value: function drop(event) {\n      this.wrapper.classList.remove('capella--dark');\n\n      var file = event.dataTransfer.files[0];\n\n      capella.uploader.uploadBlob(file);\n\n      event.preventDefault();\n    }\n  }]);\n\n  return DNDFileUploader;\n}();\n\nexports.default = DNDFileUploader;\n\n//# sourceURL=webpack://capella/./public/app/js/dragndrop.js?");

/***/ }),

/***/ "./public/app/js/main.js":
/*!*******************************!*\
  !*** ./public/app/js/main.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nvar capella = {};\n\nvar Uploader = __webpack_require__(/*! ./uploader */ \"./public/app/js/uploader.js\").default;\nvar Clipboard = __webpack_require__(/*! ./clipboard */ \"./public/app/js/clipboard.js\").default;\nvar DNDFileUploader = __webpack_require__(/*! ./dragndrop */ \"./public/app/js/dragndrop.js\").default;\nvar UploadScreen = __webpack_require__(/*! ./uploadScreen */ \"./public/app/js/uploadScreen.js\").default;\n\n/**\n * Require modules\n */\ncapella.ajax = __webpack_require__(/*! codex.ajax */ \"./node_modules/codex.ajax/lib/bundle.js\");\ncapella.transport = __webpack_require__(/*! codex.transport */ \"./node_modules/codex.transport/lib/bundle.js\");\ncapella.uploader = __webpack_require__(/*! ./uploader */ \"./public/app/js/uploader.js\");\ncapella.copyable = __webpack_require__(/*! ./copyable */ \"./public/app/js/copyable.js\");\ncapella.notificationToggler = __webpack_require__(/*! ./notificationToggler */ \"./public/app/js/notificationToggler.js\");\ncapella.checkForSafari = __webpack_require__(/*! ./checkForSafari */ \"./public/app/js/checkForSafari.js\");\ncapella.notifier = __webpack_require__(/*! exports-loader?notifier!codex-notifier */ \"./node_modules/exports-loader/index.js?notifier!./node_modules/codex-notifier/notifier.js\");\n\ncapella.uploadScreen = new UploadScreen();\ncapella.uploader = new Uploader();\ncapella.clipboard = new Clipboard();\ncapella.dnd = new DNDFileUploader('.capella');\n\ncapella.init = function () {\n  capella.copyable.init();\n  capella.checkForSafari.init();\n};\n\nmodule.exports = capella;\n\n//# sourceURL=webpack://capella/./public/app/js/main.js?");

/***/ }),

/***/ "./public/app/js/notificationToggler.js":
/*!**********************************************!*\
  !*** ./public/app/js/notificationToggler.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nmodule.exports = function () {\n  var CSS = {\n    /* Class of 'Copied' notification element */\n    notificationClass: '.js-result__is-copied',\n\n    /* Class used to hide notification after showTimeout */\n    notificationHideClass: 'js-hidden'\n  };\n\n  /* 'Copied' notification element */\n  var notificationElement = document.querySelector(CSS.notificationClass);\n\n  /* Timeout after which notificationElement will be hidden */\n  var showTimeout = 2000;\n\n  /* Timer to hide notification */\n  var notificationIsVisibleTimer = void 0;\n\n  /**\n   * Show and hide after showTimeout seconds copy-notifications\n   */\n  var toggleCopiedIcon = function toggleCopiedIcon(event) {\n    /* Don't open link in new window unless one of these keys is pressed */\n    if (event.ctrlKey || event.metaKey || event.which === 2) {\n      return false;\n    }\n\n    event.preventDefault();\n\n    /* Clear timer if it was set previously */\n    if (notificationIsVisibleTimer) {\n      clearTimeout(notificationIsVisibleTimer);\n    }\n\n    /* First reveal zero-opacity notification elem, then after timeout hide it again */\n    notificationElement.classList.remove(CSS.notificationHideClass);\n    notificationIsVisibleTimer = setTimeout(function () {\n      notificationElement.classList.add(CSS.notificationHideClass);\n    }, showTimeout);\n  };\n\n  return {\n    toggleCopiedIcon: toggleCopiedIcon\n  };\n}();\n\n//# sourceURL=webpack://capella/./public/app/js/notificationToggler.js?");

/***/ }),

/***/ "./public/app/js/uploadScreen.js":
/*!***************************************!*\
  !*** ./public/app/js/uploadScreen.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n/**\n * Class to control upload screen appearance\n *\n * @property {HTMLElement} mainContainer — page wrapper\n * @property {HTMLElement} progressBar — progress bar slider element\n * @property {String} loadingClass — upload screen class\n *\n */\n\nObject.defineProperty(exports, \"__esModule\", {\n  value: true\n});\n\nvar _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nvar UploadScreen = function () {\n  /**\n   * @constructor\n   * Get needed elements from page\n   */\n  function UploadScreen() {\n    _classCallCheck(this, UploadScreen);\n\n    this.mainContainer = document.querySelector('.capella');\n    this.progressBar = document.querySelector('.js-capella__uploading-progress');\n    this.loadingClass = 'capella--loading';\n  }\n\n  /**\n   * Show loading screen by adding loadingClass to page wrapper\n   *\n   * @param {String} filename — file which is uploading now\n   */\n\n\n  _createClass(UploadScreen, [{\n    key: 'show',\n    value: function show(filename) {\n      var filenameHolder = this.mainContainer.querySelector('.capella__uploading-filename');\n\n      filenameHolder.textContent = filename;\n      this.mainContainer.classList.add(this.loadingClass);\n    }\n\n    /**\n     * Hide loading screen by removing loadingClass from page wrapper\n     */\n\n  }, {\n    key: 'hide',\n    value: function hide() {\n      this.mainContainer.classList.remove(this.loadingClass);\n    }\n\n    /**\n     * Method to control loading progress bar\n     *\n     * @param {Number} percents — uploading percentage\n     */\n\n  }, {\n    key: 'progress',\n    value: function progress(percents) {\n      this.progressBar.style.width = percents + '%';\n    }\n  }]);\n\n  return UploadScreen;\n}();\n\nexports.default = UploadScreen;\n\n//# sourceURL=webpack://capella/./public/app/js/uploadScreen.js?");

/***/ }),

/***/ "./public/app/js/uploader.js":
/*!***********************************!*\
  !*** ./public/app/js/uploader.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n/**\n * @class Uploader\n * Handle images uploading\n *\n * @property {String} uploadUrl — url to upload images\n * @property {HTMLElement} uploadFilButton — transport initialization trigger\n * @property {HTMLElement} uploadLinkField — input to insert image link\n */\n\nObject.defineProperty(exports, \"__esModule\", {\n  value: true\n});\n\nvar _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nvar Uploader = function () {\n  /**\n   * Uploader class constructor. Get needed elements and bind events\n   */\n  function Uploader() {\n    _classCallCheck(this, Uploader);\n\n    this.uploadUrl = '/upload';\n    this.uploadFileButton = document.getElementById('uploadFileButton');\n    this.uploadLinkField = document.getElementById('uploadLinkField');\n\n    if (this.uploadFileButton) {\n      this.uploadFileButton.addEventListener('click', this.uploadByTransport.bind(this), false);\n    }\n\n    if (this.uploadLinkField) {\n      this.uploadLinkField.addEventListener('keydown', this.uploadByUrl.bind(this), false);\n    }\n  }\n\n  /**\n   * Init codex.transport to select image from user's computer\n   */\n\n\n  _createClass(Uploader, [{\n    key: 'uploadByTransport',\n    value: function uploadByTransport() {\n      capella.transport.init({\n        url: this.uploadUrl,\n        multiple: false,\n        accept: 'image/png, image/gif, image/jpg, image/jpeg, image/bmp,  image/tiff',\n        data: {},\n        before: this.before,\n        progress: this.progress,\n        success: this.success,\n        error: this.error,\n        after: this.after\n      });\n    }\n\n    /**\n     * Handle upload by image url\n     *\n     * @param e\n     */\n\n  }, {\n    key: 'uploadByUrl',\n    value: function uploadByUrl(e) {\n      /** Check for Enter key */\n      if (e.keyCode !== 13) {\n        return;\n      }\n      e.preventDefault();\n\n      if (this.uploadLinkField) {\n        this.upload({ 'link': this.uploadLinkField.value });\n      }\n    }\n\n    /**\n     * Handler to upload blob data using FormData\n     *\n     * @param {Blob|File} file — file to send\n     */\n\n  }, {\n    key: 'uploadBlob',\n    value: function uploadBlob(file) {\n      var formData = new FormData();\n\n      this.currentFileName = file.name;\n\n      formData.append('file', file, file.name);\n\n      this.upload(formData);\n    }\n\n    /**\n     * Send AJAX request to uploadUrl with passed data\n     *\n     * @param {*} data — data to send\n     */\n\n  }, {\n    key: 'upload',\n    value: function upload(data) {\n      capella.ajax.call({\n        type: 'POST',\n        url: this.uploadUrl,\n        data: data,\n        before: this.before.bind(this),\n        progress: this.progress,\n        success: this.success,\n        error: this.error,\n        after: this.after\n      });\n    }\n\n    /**\n     * Method to call before upload starts\n     */\n\n  }, {\n    key: 'before',\n    value: function before(data) {\n      var filename = void 0;\n\n      if (data instanceof FormData) {\n        filename = this.currentFileName;\n      }\n      if (data && data.link) {\n        filename = data.link;\n      }\n      if (data[0] instanceof File) {\n        filename = data[0].name;\n      }\n\n      capella.uploadScreen.show(filename);\n    }\n\n    /**\n     *  Handle upload progress\n     *\n     * @param percentage — upload percentage\n     */\n\n  }, {\n    key: 'progress',\n    value: function progress(percentage) {\n      percentage = 0.95 * percentage;\n      capella.uploadScreen.progress(percentage);\n    }\n\n    /**\n     * Successful upload handler\n     *\n     * @param {Object} response — response object\n     * @param {Boolean} response.success — upload status\n     * @param {String} response.url — if upload was successful, contains uploaded image url\n     * @param {String} response.id — if upload was succesful, contains uploaded image id\n     * @param {String} response.message — if upload failed, contains reason\n     */\n\n  }, {\n    key: 'success',\n    value: function success(response) {\n      console.log(response);\n\n      if (response.success) {\n        capella.uploadScreen.progress(100);\n\n        /** Redirect to uploaded image */\n        window.location.href = '/image/' + response.id;\n      } else {\n        capella.uploadScreen.hide();\n      }\n    }\n\n    /**\n     * Upload error handler\n     *\n     * @param {Error} error — raised error\n     */\n\n  }, {\n    key: 'error',\n    value: function error(response) {\n      capella.notifier.show({\n        message: '<i class=\\'cdx-notify__warning-sign\\'></i>' + response.message,\n        time: 7000\n      });\n      capella.uploadScreen.hide();\n    }\n\n    /**\n     * Method to call after upload\n     */\n\n  }, {\n    key: 'after',\n    value: function after() {}\n  }]);\n\n  return Uploader;\n}();\n\nexports.default = Uploader;\n\n//# sourceURL=webpack://capella/./public/app/js/uploader.js?");

/***/ })

/******/ });