<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div class="lbox-horz"></div>
<div id="login" class="lbox-vert">
    <?php if ($login_error == TRUE) { ?>
        <div id="alert" class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $login_error ?><button type="button" class="close" data-dismiss="alert">×</button>
        </div>
    <?php } ?>
</div>

<div class="login_logo">eMarket</div>


<div class="login-box side-form">
    <form  action='index.php' method='post'>
        
        <input hidden name="autorize" value="ok">
        
        <div class="form-group">
            <input type="text" name="login" class="input-sm form-control" placeholder="<?php echo lang('email') ?>">
        </div>
        <div class="form-group">
            <input type="password" name="pass" class="input-sm form-control" placeholder="<?php echo lang('password') ?>">
        </div>

        <input type="submit" name='ok' class="btn btn-block btn-xs" value="<?php echo lang('entrance') ?>">
    </form>
</div>

<script>
    $(function () {
        window.setTimeout(function () {
            $('#alert').alert('close');
        }, 3000);
    });
</script>