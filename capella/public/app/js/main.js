'use strict';

let capella = {};

const Uploader = require('./uploader').default;
const Clipboard = require('./clipboard').default;
const DNDFileUploader = require('./dragndrop').default;
const UploadScreen = require('./uploadScreen').default;

/**
 * Require modules
 */
capella.uploader = require('./uploader');
capella.copyable = require('./copyable');
capella.projectForm = require('./project-form');
capella.notificationToggler = require('./notificationToggler');
capella.notifier = require('codex-notifier');

capella.uploadScreen = new UploadScreen();
capella.uploader = new Uploader();
capella.clipboard = new Clipboard();
capella.dnd = new DNDFileUploader('.capella');

capella.init = function () {
  capella.copyable.init();
  capella.projectForm.init();
};

module.exports = capella;
