'use strict';

let capella = {};

let Uploader = require('./uploader').default;
let Clipboard = require('./clipboard').default;
let DNDFileUploader = require('./dragndrop').default;
let UploadScreen = require('./uploadScreen').default;

/**
 * Require modules
 */
capella.uploader = require('./uploader');
capella.copyable = require('./copyable');
capella.notificationToggler = require('./notificationToggler');
capella.notifier = require('codex-notifier');

capella.uploadScreen = new UploadScreen();
capella.uploader = new Uploader();
capella.clipboard = new Clipboard();
capella.dnd = new DNDFileUploader('.capella');

capella.init = function () {
  capella.copyable.init();
};

module.exports = capella;
