/*
 * Admin app
 */

// require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

import Inputmask from 'inputmask';

$(document).ready(function() {
    Inputmask().mask($('.input-mask'));
});