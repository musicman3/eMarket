/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/**
 * Basic Settings
 *
 * @package BasicSettings
 * @author eMarket
 * 
 */
class BasicSettings {
    /**
     * Constructor
     *
     */
    constructor() {
        this.change();
    }

    /**
     * Change
     * 
     */
    change() {
        var smtp_status = document.querySelector('#smtp_status');
        if (smtp_status.options.selectedIndex === 1) {
            BasicSettings.disableInput();
        }

        smtp_status.addEventListener('change', function (event) {
            if (smtp_status.options.selectedIndex === 1) {
                BasicSettings.disableInput();
            } else {
                document.querySelector('#smtp_auth').removeAttribute('disabled');
                document.querySelector('#host_email').removeAttribute('disabled');
                document.querySelector('#username_email').removeAttribute('disabled');
                document.querySelector('#password_email').removeAttribute('disabled');
                document.querySelector('#smtp_secure').removeAttribute('disabled');
                document.querySelector('#smtp_port').removeAttribute('disabled');
            }
        });
    }

    /**
     * Disable Input
     * 
     */
    static disableInput() {
        document.querySelector('#smtp_auth').setAttribute('disabled', 'disabled');
        document.querySelector('#host_email').setAttribute('disabled', 'disabled');
        document.querySelector('#username_email').setAttribute('disabled', 'disabled');
        document.querySelector('#password_email').setAttribute('disabled', 'disabled');
        document.querySelector('#smtp_secure').setAttribute('disabled', 'disabled');
        document.querySelector('#smtp_port').setAttribute('disabled', 'disabled');
    }
}