<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<script type="text/javascript" language="javascript">
    $('#breadcrumb').append('<li class="selected"><a href="/"><?php echo lang('breadcrumb_home') ?></a></li>');

<?php if (isset($categories_name)) { ?>
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

<?php } ?>
</script>