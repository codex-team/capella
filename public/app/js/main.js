'use strict';


const capella = {};

let Uploader = require('./uploader').default;
let Clipboard = require('./clipboard').default;
let DNDFileUploader = require('./dragndrop').default;
let UploadScreen = require('./uploadScreen').default;

/**
 * Require modules
 */
capella.ajax = require('codex.ajax');
capella.transport = require('codex.transport');
capella.uploader = require('./uploader');
capella.copyable = require('./copyable');
capella.checkForSafari = require('./checkForSafari');
capella.notifier = require('exports-loader?notifier!codex-notifier');

capella.uploadScreen = new UploadScreen();
capella.uploader = new Uploader();
capella.clipboard = new Clipboard();
capella.dnd = new DNDFileUploader('.capella');

capella.init = function () {
  capella.copyable.init();
  capella.checkForSafari.init();
};

module.exports = capella;
