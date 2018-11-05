<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

?>

<!--Мультиселект-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#example-enableCollapsibleOptGroups-collapsedClickableOptGroups-enableFiltering-includeSelectAllOption').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            buttonContainer: '<div id="example-enableCollapsibleOptGroups-collapsed-container" />',
            includeSelectAllOption: true
        });
        $('#example-enableCollapsibleOptGroups-collapsed-container .caret-container').click();
    });
</script>