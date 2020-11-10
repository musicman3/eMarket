<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<!--Атрибуты -->
<script type="text/javascript" src="/model/js/classes/attributes/group_attributes.js"></script>
<script type="text/javascript" src="/model/js/classes/attributes/attributes.js"></script>
<script type="text/javascript" src="/model/js/classes/attributes/values_attribute.js"></script>
<script type="text/javascript" src="/model/js/classes/attributes/attributes_processing.js"></script>
<script type="text/javascript" src="/model/js/classes/jsdata/jsdata.js"></script>

<?php $lang_for_button = json_encode([
    lang('confirm-yes'), 
    lang('confirm-no'), 
    lang('button_delete'), 
    lang('button_edit'),
    lang('#lang_all')[0]
    ]); ?>
<script type="text/javascript">
    var lang = $.parseJSON('<?php echo $lang_for_button ?>');
    new GroupAttributes(lang);
    new Attributes(lang);
    new ValuesAttribute(lang);
</script>