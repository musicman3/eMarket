/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
 |    GNU GENERAL PUBLIC LICENSE v.3.0    |
 |  https://github.com/musicman3/eMarket  |
 =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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
        $(document).ready(function () {
            if ($('div#nav_data').data('sortflag') === 'on') {
                sessionStorage.removeItem('sort_id');
            }
            ProductsListing.initGrid();

            $('#list').click(function () {
                ProductsListing.setList();
                sessionStorage.setItem('grid_list', 'list');
            });
            $('#grid').click(function () {
                ProductsListing.setGrid();
                sessionStorage.setItem('grid_list', 'grid');
            });
        });

        $('.sorting').click(function (event) {
            if (document.getElementById('show_in_stock').checked) {
                var change = 'on';
            } else {
                var change = 'off';
            }
            sessionStorage.setItem('sort_id', event.target.id);
            ProductsListing.getData(event.target.id, change);
        });

        $('#show_in_stock').on('switchChange.bootstrapSwitch', function (event, state) {
            if (document.getElementById('show_in_stock').checked) {
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

        $('.navigation').click(function (event) {
            if (document.getElementById('show_in_stock').checked) {
                var change = 'on';
            } else {
                var change = 'off';
            }
            if (sessionStorage.getItem('sort_id') === null) {
                sort_id = 'default';
            } else {
                var sort_id = sessionStorage.getItem('sort_id');
            }
            var prev = $('div#nav_data').data('prev');
            var next = $('div#nav_data').data('next');

            if (event.target.id === 'prev') {
                ProductsListing.getData(sort_id, change, null, null, prev, next);
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
    static getData(sort_id, change, start = null, finish = null, backstart = null, backfinish = null) {
        jQuery.get(window.location.href,
                {sort: sort_id,
                    change: change,
                    start: start,
                    finish: finish,
                    backstart: backstart,
                    backfinish: backfinish},
                AjaxSuccess);
        function AjaxSuccess(data) {
            $('#listing').replaceWith($(data).find('#listing'));
            $('#show_in_stock').bootstrapSwitch();
            new ProductsListing();
    }
    }

    /**
     * Display in strings
     *
     */
    static setList() {
        $('.popover').popover('hide');
        $('#listing .item').removeClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
        $('#listing .item').addClass('col-xs-12 list-group-item');
        $('#listing .item-grid').removeClass('active');
        $('#listing .item-list').addClass('active');
    }

    /**
     * Grid display
     *
     */
    static setGrid() {
        $('.popover').popover('hide');
        $('#listing .item').removeClass('col-xs-12 list-group-item');
        $('#listing .item').addClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 grid-group-item');
        $('#listing .item-list').removeClass('active');
        $('#listing .item-grid').addClass('active');
    }

    /**
     * Quantity of products in input
     * @param val {String} (label value)
     * @param id {String} (product id)
     * @param max_quantity {String} (Maximum order quantity)
     *
     */
    static pcsProduct(val, id, max_quantity = null) {
        var a = $('#number_' + id).val();

        $(document).click(function (e) {
            if ($(e.target).closest('.button-plus').length) {
                return;
            }
            $('.popover').popover('hide');
        });

        if (val === 'minus' && a > 1) {
            $('#number_' + id).val(+a - 1);
        }
        if (val === 'plus' && Number(a) < Number(max_quantity)) {
            $('#number_' + id).val(+a + 1);
        }
        if (Number(a) === Number(max_quantity)) {
            $('#number_' + id).popover('show');
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
            jQuery.ajaxSetup({async: false});
            jQuery.get(window.location.href,
                    {add_to_cart: id,
                        add_quantity: pcs},
                    AjaxSuccess);
            function AjaxSuccess(data) {
                $('#product_image').empty();
                var product_edit = $('div#ajax_data').data('product')[id];

                $('#product_name').html(product_edit['name']);
                $('#product_price_formated').html(product_edit['price_formated']);
                $('#product_quantity').html(pcs);
                $('#product_image').append('<img class="img-responsive center-block" src="/uploads/images/products/resize_0/' + product_edit['logo_general'] + '" alt="' + product_edit['name'] + '" />');

                $('#cart_bar').replaceWith($(data).find('#cart_bar'));
                $('#product-data').replaceWith($(data).find('#product-data'));
                $('#cart_message').modal('show');
                $('#show_in_stock').bootstrapSwitch();
                new ProductsListing();

                new ProductsListing();
            }
        }
    }

}