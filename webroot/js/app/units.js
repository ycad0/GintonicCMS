define(function (require) {
    var $ = require('jquery');
    var jqueryvalidate = require('jqueryvalidate');

    function roundit(which)
    {
        return Math.round(which * 100) / 100
    }

    function cmconvert() 
    {
        with (document.cminch) {
            feet.value = roundit(cm.value / 30.84);
            inch.value = roundit(cm.value / 2.54);
        }
    }

    function inchconvert() 
    {
        with (document.cminch) {
            cm.value = roundit(inch.value * 2.54);
            feet.value = roundit(inch.value / 12);
        }
    }

    function feetconvert() 
    {
        with (document.cminch) {
            cm.value = roundit(feet.value * 30.48);
            inch.value = roundit(feet.value * 12);
        }
    }
    $(document).ready(function () 
    {

    });
});