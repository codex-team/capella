'use strict';


const capella = {};

/**
 * Require modules
 */
capella.ajax = require('codex.ajax');
capella.transport = require('codex.transport');
capella.uploader = require('./uploader');
capella.screensToggler = require('./screensToggler');
let Clipboard = require('./clipboard').default;

capella.clipboard = new Clipboard();

window.docReady = function (f) {
  /in/.test(document.readyState) ? window.setTimeout(window.docReady, 9, f) : f();
};

/**
 * Capella init function
 */
capella.init = function () {
  capella.uploader.init();
};

module.exports = capella;
