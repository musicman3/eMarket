<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!-- Summernote" -->
<script type="text/javascript" src="/ext/summernote/summernote.min.js"></script>
<link href="/ext/summernote/summernote.min.css" rel="stylesheet">
<script src="/ext/summernote/lang/summernote-<?php echo lang('language_code') ?>.min.js"></script>
<script type="text/javascript">

    // Настройка Summernote
    var summernote_pref = {
        lang: '<?php echo lang('language_code') ?>',
        dialogsInBody: true,
        dialogsFade: true,
        height: '100px',
        placeholder: '<?php echo lang('stock_product_create_description') ?>',
        toolbar: [
            ['fullscreen ', ['fullscreen']],
            ['style', ['style']],
            ['font_set', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
            ['hr', ['hr']],
            ['color', ['color']],
            ['forecolor', ['forecolor']],
            ['font_type', ['fontsize', 'fontname']],
            ['undo ', ['undo', 'redo', 'clear']],
            ['paragraph ', ['ol', 'ul', 'paragraph', 'height']],
            ['link', ['link', 'linkDialogShow', 'unlink']],
            ['insert', ['table', 'picture', 'video']],
            ['misc', ['codeview', 'help']]
        ]
    };
    //Если закрыли модальное окно #index_product
    $('#index_product').on('hidden.bs.modal', function (event) {
        // Destroy Summernote
        var count_lang = '<?php echo \eMarket\Lang::$COUNT ?>';
        for (var x = 0; x < count_lang; x++) {
            $('#description_product_stock_' + x).summernote('destroy');
        }
    });
    // Фикс модала в модале
    $(document).on('hidden.bs.modal', '.modal', function (event) {
        $('.modal:visible').length && $('body').addClass('modal-open');
    });
    // Фикс Fullscreen в модале
    $(document).on('click', '.btn-fullscreen', function () {
        $('body').css({overflow: 'hidden'});
        $(this).tooltip('hide');
    });
    $(document).on('click', '.note-fullscreen', function () {
        $('body').css({overflow: ''});
    });
</script>