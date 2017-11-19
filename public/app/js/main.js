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


let DNDFileUploader = require('./dragndrop').default;

capella.dnd = new DNDFileUploader('.capella');

/**
 * Capella init function
 */
capella.init = function () {
  capella.uploader.init();
};

module.exports = capella;
