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

let DNDFileUploader = require('./dragndrop').default;

capella.dnd = new DNDFileUploader('.capella', '.capella__drag-n-drop');

/**
 * Capella init function
 */
capella.init = function () {
  capella.uploader.init();
};

module.exports = capella;
