'use strict';


const capella = {};

/**
 * Require modules
 */
capella.ajax = require('codex.ajax');
capella.transport = require('codex.transport');

let Clipboard = require('./clipboard').default;

capella.clipboard = new Clipboard();

let DNDFileUploader = require('./dragndrop').default;

capella.dnd = new DNDFileUploader('.capella');

capella.init = function () {
  let Uploader = require('./uploader').default;

  capella.uploader = new Uploader();
};

module.exports = capella;
