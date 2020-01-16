<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript" language="javascript">
    $('#breadcrumb').append('<li class="selected"><a href="/"><?php echo lang('breadcrumb_home') ?></a></li>');

<?php if (\eMarket\Valid::inGET('route') == 'products') { ?>
        function breadcrumb() {
            var breadcrumbid = $('div#data_breadcrumb').data('breadcrumbid');
            var breadcrumbparentid = $('div#data_breadcrumb').data('breadcrumbparentid');
            var breadcrumbname = $('div#data_breadcrumb').data('breadcrumbname');

            if (breadcrumbid.length > 0) {
                for (x = 0; x < breadcrumbname.length; x++) {
                    $('#breadcrumb').append('<li class="selected"><a href="/?route=listing&category_id=' + breadcrumbid[x] + '&parent_id=' + breadcrumbparentid[x] + '">' + breadcrumbname[x] + '</a></li>');
                }
            }
            $('#breadcrumb').append('<li class="selected"><a href="/?route=listing&category_id=<?php echo \eMarket\Valid::inGET('category_id') ?>&parent_id=<?php echo \eMarket\Valid::inGET('parent_id') ?>"><?php echo $categories_name ?></a></li>');
            $('#breadcrumb').append('<li class="selected"><?php echo $products['name'] ?></li>');
        }

        $(document).ready(function () {
            breadcrumb();
        });

<?php } elseif (\eMarket\Valid::inGET('route') == 'listing') {
    ?>
        function breadcrumb() {
            var breadcrumbid = $('div#data_breadcrumb').data('breadcrumbid');
            var breadcrumbparentid = $('div#data_breadcrumb').data('breadcrumbparentid');
            var breadcrumbname = $('div#data_breadcrumb').data('breadcrumbname');

            if (breadcrumbid.length > 0) {
                for (x = 0; x < breadcrumbname.length; x++) {
                    $('#breadcrumb').append('<li class="selected"><a href="/?route=listing&category_id=' + breadcrumbid[x] + '&parent_id=' + breadcrumbparentid[x] + '">' + breadcrumbname[x] + '</a></li>');
                }
            }
            $('#breadcrumb').append('<li class="selected"><?php echo $categories_name ?></li>');
        }

        $(document).ready(function () {
            breadcrumb();
        });
<?php } elseif (\eMarket\Valid::inGET('route') != '') { ?>
        function breadcrumb() {
            var breadcrumbid = $('div#data_breadcrumb').data('breadcrumbid');
            var breadcrumbparentid = $('div#data_breadcrumb').data('breadcrumbparentid');
            var breadcrumbname = $('div#data_breadcrumb').data('breadcrumbname');

            $('#breadcrumb').append('<li class="selected"><?php echo \eMarket\Set::titleCatalog('false') ?></li>');
        }

        $(document).ready(function () {
            breadcrumb();
        });
<?php } ?>
</script>