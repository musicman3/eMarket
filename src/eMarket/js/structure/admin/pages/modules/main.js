/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* global Helpers */

/**
 * Modules
 *
 * @package Modules
 * @author eMarket
 * 
 */
class Modules {
    /**
     * Constructor
     *
     */
    constructor() {
        this.download();
    }

    /**
     * Download
     * 
     */
    download() {
        Helpers.on('body', 'click', '#module-download', function (e) {
            Ajax.callAdd('download', window.location.href);
        });
    }

    /**
     * Ajax Success
     *
     *@param data {Object} (ajax data)
     */
    static AjaxSuccess(data) {
        setTimeout(function () {
            alert(123);
        }, 100);
    }
}