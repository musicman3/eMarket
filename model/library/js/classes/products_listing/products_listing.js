/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
/* global Helpers, bootstrap, Ajax */

/**
 * Listing products in the catalog
 *
 * @package ProductsListing
 * @author eMarket
 * 
 */
class ProductsListing {
    /**
     * Constructor
     *
     */
    constructor() {
        ProductsListing.init();
    }
    /**
     * Init
     *
     */
    static init() {
        document.addEventListener("DOMContentLoaded", function () {
            sessionStorage.setItem('listing_url', window.location.href);
            if (document.querySelector('#nav_data').dataset.sortflag === 'on') {
                sessionStorage.removeItem('sort_id');
            }
            ProductsListing.initGrid();

            document.querySelector('#list').addEventListener('click', (e) => {
                ProductsListing.setList();
                sessionStorage.setItem('grid_list', 'list');
            });
            document.querySelector('#grid').addEventListener('click', (e) => {
                ProductsListing.setGrid();
                sessionStorage.setItem('grid_list', 'grid');
            });
        });

        Helpers.on('body', 'click', '.sorting', function (e) {
            if (document.querySelector('#primary-outlined').checked) {
                var change = 'on';
            } else {
                var change = 'off';
            }
            sessionStorage.setItem('sort_id', event.target.id);
            ProductsListing.getData(event.target.id, change);
        });

        Helpers.on('body', 'click', 'input[name="show_in_stock"]', function (e) {
            if (document.querySelector('#primary-outlined').checked) {
                var change = 'on';
            } else {
                var change = 'off';
            }
            if (sessionStorage.getItem('sort_id') === null) {
                sort_id = 'default';
            } else {
                var sort_id = sessionStorage.getItem('sort_id');
            }
            ProductsListing.getData(sort_id, change);
        });

        Helpers.on('body', 'click', '.navigation', function (e) {
            if (document.querySelector('#primary-outlined').checked) {
                var change = 'on';
            } else {
                var change = 'off';
            }
            if (sessionStorage.getItem('sort_id') === null) {
                sort_id = 'default';
            } else {
                var sort_id = sessionStorage.getItem('sort_id');
            }
            var prev = document.querySelector('#nav_data').dataset.prev;
            var next = document.querySelector('#nav_data').dataset.next;

            if (event.target.id === 'prev') {
                ProductsListing.getData(sort_id, change, '', '', prev, next);
            }
            if (event.target.id === 'next') {
                ProductsListing.getData(sort_id, change, prev, next);
            }
        });
    }

    /**
     * List display initialization
     *
     */
    static initGrid() {
        if (sessionStorage.getItem('grid_list') === 'list') {
            ProductsListing.setList();
        }
        if (sessionStorage.getItem('grid_list') === 'grid' || sessionStorage.getItem('grid_list') === null) {
            ProductsListing.setGrid();
        }
    }

    /**
     * Sending data to server
     * @param sort_id {String} (value sort)
     * @param change {String} (value change)
     * @param start {String} (value start)
     * @param finish {String} (value finish)
     * @param backstart {String} (value backstart)
     * @param backfinish {String} (value backfinish)
     *
     */
    static getData(sort_id, change, start = '', finish = '', backstart = '', backfinish = '') {
        let xhr = new XMLHttpRequest();
        var url = Helpers.urlFromArray(window.location.href, {
            sort: sort_id,
            change: change,
            start: start,
            finish: finish,
            backstart: backstart,
            backfinish: backfinish
        });
        sessionStorage.setItem('listing_url', url);
        xhr.open('GET', url, false);
        xhr.send();
        if (xhr.status === 200) {
            var data = xhr.response;
            var dataXHR = document.createElement('div');
            dataXHR.innerHTML = data;
            document.querySelector('#csrf_token').replaceWith(dataXHR.querySelector('#csrf_token'));
            document.querySelector('#ajax_data').replaceWith(dataXHR.querySelector('#ajax_data'));
            document.querySelector('.button-sort').replaceWith(dataXHR.querySelector('.button-sort'));
            document.querySelector('#listing').replaceWith(dataXHR.querySelector('#listing'));
            ProductsListing.initGrid();
    }
    }

    /**
     * Display in strings
     *
     */
    static setList() {
        document.querySelectorAll('.popover').forEach(e => bootstrap.Popover.getInstance(e).hide());
        document.querySelectorAll('.item').forEach(e => e.classList.remove('col-xl-3', 'col-lg-4', 'col-md-6', 'col-12', 'grid-group-item'));
        document.querySelectorAll('#card').forEach(e => e.classList.remove('card'));
        document.querySelectorAll('#image').forEach(e => e.classList.remove('h-100'));
        document.querySelectorAll('.item').forEach(e => e.classList.add('col-12', 'list-group-item'));
        document.querySelector('.item-grid').classList.remove('active');
        document.querySelector('.item-list').classList.add('active');
    }

    /**
     * Grid display
     *
     */
    static setGrid() {
        document.querySelectorAll('.popover').forEach(e => bootstrap.Popover.getInstance(e).hide());
        document.querySelectorAll('.item').forEach(e => e.classList.remove('col-12', 'list-group-item'));
        document.querySelectorAll('.item').forEach(e => e.classList.add('col-xl-3', 'col-lg-4', 'col-md-6', 'col-12', 'grid-group-item'));
        document.querySelectorAll('#card').forEach(e => e.classList.add('card'));
        document.querySelectorAll('#image').forEach(e => e.classList.add('h-100'));
        document.querySelector('.item-list').classList.remove('active');
        document.querySelector('.item-grid').classList.add('active');
    }

    /**
     * Quantity of products in input
     * @param val {String} (label value)
     * @param id {String} (product id)
     * @param max_quantity {String} (Maximum order quantity)
     *
     */
    static pcsProduct(val, id, max_quantity = null) {
        var a = document.querySelector('#number_' + id).value;

        document.querySelector('body').addEventListener('click', (e) => {
            if (e.target.closest('.button-plus') !== null) {
                return;
            }
            document.querySelectorAll('.popover').forEach(e => bootstrap.Popover.getInstance(e).hide());
        });

        if (val === 'minus' && a > 1) {
            document.querySelector('#number_' + id).value = +a - 1;
        }
        if (val === 'plus' && Number(a) < Number(max_quantity)) {
            document.querySelector('#number_' + id).value = +a + 1;
        }
        if (Number(a) === Number(max_quantity)) {
            new bootstrap.Popover(document.querySelector('#number_' + id)).show();
    }

    }

    /**
     * Add to cart
     * @param id {String} (product id)
     * @param pcs {String} (quantity)
     *
     */
    static addToCart(id, pcs) {
        if (pcs > 0) {
            Ajax.postData(sessionStorage.getItem('listing_url'), {
                add_to_cart: id,
                add_quantity: pcs
            }, true, null, AjaxSuccess).then((data) => {
            });
            function AjaxSuccess(data) {
                document.querySelector('#product_image').innerHTML = '';
                var product_edit = JSON.parse(document.querySelector('#ajax_data').dataset.product)[id];
                var ajax_data = document.createElement('div');
                ajax_data.innerHTML = data;

                document.querySelector('#cart_bar').replaceWith(ajax_data.querySelector('#cart_bar'));
                document.querySelector('#product_name').innerHTML = product_edit.name;
                document.querySelector('#product_price_formated').innerHTML = product_edit.price_formated;
                document.querySelector('#product_quantity').innerHTML = pcs;
                document.querySelector('#product_image').insertAdjacentHTML('afterbegin', '<img class="img-thumbnail mx-auto d-block" src="/uploads/images/products/resize_0/' + product_edit.logo_general + '" alt="' + product_edit.name + '" />');

                document.querySelector('#listing').replaceWith(ajax_data.querySelector('#listing'));
                new bootstrap.Modal(document.querySelector('#cart_message')).show();
                new ProductsListing();
                ProductsListing.initGrid();
            }
        }
    }

}