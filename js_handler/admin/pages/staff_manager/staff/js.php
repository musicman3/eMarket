<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<script type="text/javascript">
    document.querySelector('#index').addEventListener('show.bs.modal', function (event) {
            document.querySelector('#edit').value = '';
            document.querySelector('#add').value = 'ok';
            document.querySelectorAll('form').forEach(e => e.reset());
            document.querySelector('#generate_password').addEventListener('click', (e) => {
            var randomizer = new Randomizer();
            document.querySelector("#password").value = randomizer.uid(20);
        });
    });
</script>

<script type="text/javascript" src="/model/library/js/classes/ajax/ajax.js"></script>
<script type="text/javascript">
    new Ajax();
</script>
