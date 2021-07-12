/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global bootstrap, Ajax */

/**
 * Reviews
 *
 * @package Tabs
 * @author eMarket
 * 
 */
class Reviews {

    /**
     * Add review
     *
     */
    static addReview() {
        Ajax.postData(window.location.href, {
            stars: document.querySelector('input[name="stars"]:checked').value,
            review: document.querySelector('#review').value.replace(/\n/g, '<br/>')
        }, true, null, AjaxUpdate).then((data) => {
        });

        function AjaxUpdate(data) {
            Ajax.postData(window.location.href, {
            }, true, null, AjaxSuccess).then((data) => {
            });
        }

        function AjaxSuccess(data) {
            var ajax_data = document.createElement('div');
            ajax_data.innerHTML = data;
            document.querySelector('#reviews_count').replaceWith(ajax_data.querySelector('#reviews_count'));
            document.querySelector('#reviews_block').replaceWith(ajax_data.querySelector('#reviews_block'));
            new Reviews();
        }
    }

    /**
     * Show more
     *
     */
    static more() {
        if (document.querySelector('#more_count').value === null) {
            document.querySelector('#more_count').value = 0;
        }
        document.querySelector('#more_count').value = Number(document.querySelector('#more_count').value) + Number(document.querySelector('#lines_on_page').value);

        if (Number(document.querySelector('#more_count').value) < Number(document.querySelector('#reviews_count').innerHTML)) {
            Ajax.postData(window.location.href, {
                start_review: document.querySelector('#more_count').value
            }, true, null, AjaxSuccess).then((data) => {
            });
        } else {
            document.querySelector('#button_more').setAttribute('disabled', true);
        }

        function AjaxSuccess(data) {
            var ajax_data = document.createElement('div');
            ajax_data.innerHTML = data;
            document.querySelector('#reviews_data').insertAdjacentHTML('beforeend', ajax_data.querySelector('#reviews_data').innerHTML);
            if (ajax_data.querySelector('#more_block') !== null) {
                document.querySelector('#more_block').replaceWith(ajax_data.querySelector('#more_block'));
            } else {
                document.querySelector('#button_more').setAttribute('disabled', true);
            }
            new Reviews();
        }
    }

}