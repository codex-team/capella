'use strict';


const capella = {};

let Uploader = require('./uploader').default;
let Clipboard = require('./clipboard').default;
let DNDFileUploader = require('./dragndrop').default;

/**
 * Require modules
 */
capella.ajax = require('codex.ajax');
capella.transport = require('codex.transport');
capella.scene = require('./scene');
capella.uploader = require('./uploader');

capella.uploader = new Uploader();
capella.clipboard = new Clipboard();
capella.dnd = new DNDFileUploader('.capella');

capella.init = function () {};

module.exports = capella;
