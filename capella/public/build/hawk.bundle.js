var hawk =
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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	return __webpack_require__(__webpack_require__.s = "./public/app/js/hawk.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/hawk.javascript/dist/hawk.js":
/*!***************************************************!*\
  !*** ./node_modules/hawk.javascript/dist/hawk.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("!function(e,o){ true?module.exports=o():undefined}(window,function(){return function(e){var o={};function n(t){if(o[t])return o[t].exports;var r=o[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,n),r.l=!0,r.exports}return n.m=e,n.c=o,n.d=function(e,o,t){n.o(e,o)||Object.defineProperty(e,o,{enumerable:!0,get:t})},n.r=function(e){\"undefined\"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:\"Module\"}),Object.defineProperty(e,\"__esModule\",{value:!0})},n.t=function(e,o){if(1&o&&(e=n(e)),8&o)return e;if(4&o&&\"object\"==typeof e&&e&&e.__esModule)return e;var t=Object.create(null);if(n.r(t),Object.defineProperty(t,\"default\",{enumerable:!0,value:e}),2&o&&\"string\"!=typeof e)for(var r in e)n.d(t,r,function(o){return e[o]}.bind(null,r));return t},n.n=function(e){var o=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(o,\"a\",o),o},n.o=function(e,o){return Object.prototype.hasOwnProperty.call(e,o)},n.p=\"\",n(n.s=1)}([function(e,o,n){\"use strict\";e.exports.log=function(e,o,n){o=o||\"info\",e=\"[CodeX Hawk]: \"+e,\"console\"in window&&window.console[o]&&(void 0!==n?window.console[o](e,n):window.console[o](e))}},function(e,o,n){\"use strict\";e.exports=n(2)},function(e,o,n){\"use strict\";\n/*!\n * Codex Hawk client side module\n * https://github.com/codex-team/hawk.client\n *\n * Codex Hawk - https://hawk.so\n * Codex Team - https://ifmo.su\n *\n * @license MIT (c) CodeX 2017\n */e.exports=function(){var e=n(3),o=n(4),t=n(0),r=null,i=void 0,c=void 0,s={message:function(e){var o=void 0,n=void 0;try{n=(e=JSON.parse(e.data)).type,o=e.message}catch(t){o=e.data,n=\"info\"}t.log(\"Hawk says: \"+o,n)},close:function(){t.log(\"Connection lost. Errors won't be save. Please, refresh the page\",\"warn\")}};function a(e){return e.replace(/\\/'/,\"'\")}var u=function(e){var o={token:i,message:a(e.message),error_location:{file:e.filename,line:e.lineno,col:e.colno,revision:c||null},location:{url:window.location.href,origin:window.location.origin,host:window.location.hostname,path:window.location.pathname,port:window.location.port},stack:e.error.stack||e.error.stacktrace,time:Date.now(),navigator:{ua:a(window.navigator.userAgent),frame:{width:window.innerWidth,height:window.innerHeight}}};r.send(o)};return{init:function(n){var a=void 0,l=void 0,f=void 0,d=void 0,p=void 0,w=void 0;if(\"string\"==typeof n?a=n:(a=n.token,l=n.host,f=n.port,d=n.path,p=n.secure,w=n.revision),e.socket.host=l||e.socket.host,e.socket.port=f||e.socket.port,e.socket.path=d||e.socket.path,e.socket.secure=void 0!==p?p:e.socket.secure,a){i=a,w&&(c=w);var h=e.socket;h.onmessage=s.message,h.onclose=s.close,r=o(h),window.addEventListener(\"error\",u)}else t.log(\"Please, pass your verification token for Hawk error tracker. You can get it on hawk.so\",\"warn\")},test:function(){u({message:\"Hawk client catcher test\",filename:\"hawk.js\",lineno:0,colno:0,error:{stack:\"hawk.js\"}})}}}()},function(e,o,n){\"use strict\";e.exports={socket:{host:\"hawk.so\",path:\"catcher/client\",port:8070,secure:!0}}},function(e,o,n){\"use strict\";e.exports=function(e){var o=null,t=n(0),r=1,i=function(){return new Promise(function(n,t){var r=\"ws\"+(e.secure?\"s\":\"\")+\"://\",i=e.host||\"localhost\",c=e.path?\"/\"+e.path:\"\",s=e.port?\":\"+e.port:\"\";o=new WebSocket(r+i+s+c),\"function\"==typeof e.onmessage&&(o.onmessage=e.onmessage),o.onclose=function(o){\"function\"==typeof e.onclose&&e.onclose.call(this,o),t()},o.onopen=function(o){\"function\"==typeof e.onopen&&e.onopen.call(this,o),n()}})};return i().catch(function(e){t.log(\"Error while opening socket connection\",\"error\",e)}),{send:function(e){null!==o&&(e=JSON.stringify(e),o.readyState!==r?function e(){var o=arguments.length>0&&void 0!==arguments[0]?arguments[0]:1;return new Promise(function(n,r){i().then(function(){t.log(\"Successfully reconnect to socket server\",\"info\"),n()},function(){o>0?e(o-1).then(n,r):(t.log(\"Can't reconnect to socket server\",\"warn\"),r())}).catch(function(e){t.log(\"Error while reconnecting to socket server\",\"error\",e)})})}().then(function(){o.send(e)},function(){t.log(\"Can't send your data\",\"warn\")}):o.send(e))}}}}])});\n\n//# sourceURL=webpack://%5Bname%5D/./node_modules/hawk.javascript/dist/hawk.js?");

/***/ }),

/***/ "./public/app/js/hawk.js":
/*!*******************************!*\
  !*** ./public/app/js/hawk.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nmodule.exports = __webpack_require__(/*! hawk.javascript */ \"./node_modules/hawk.javascript/dist/hawk.js\");\n\n//# sourceURL=webpack://%5Bname%5D/./public/app/js/hawk.js?");

/***/ })

/******/ });