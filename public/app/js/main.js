'use strict';


const capella = {};

/**
 * Require modules
 */
capella.ajax = require('codex.ajax');
capella.transport = require('codex.transport');
capella.uploader = require('./uploader');
let Clipboard = require('./clipboard').default;

capella.clipboard = new Clipboard();

/**
 * Capella init function
 */
capella.init = function () {
  capella.uploader.init();
};

module.exports = capella;
