'use strict';


const capella = {};

/**
 * Require modules
 */
capella.ajax = require('codex.ajax');
capella.transport = require('codex.transport');
capella.uploader = require('./uploader');
capella.buffer = require('./buffer');

/**
 * Capella init function
 */
capella.init = function () {
  capella.uploader.init();
};

module.exports = capella;
