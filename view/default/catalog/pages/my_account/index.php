<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}
?>

<!--Выводим уведомление об успешном действии-->
<?php \eMarket\Messages::alert(); ?>
<h1>Мой Аккаунт</h1>

<div class="form-group">
    <small class="form-text text-muted">Имя</small>
    <div class="input-group has-error">
        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
        <input class="input-sm form-control" placeholder="Укажите имя" type="text" name="firstname" id="firstname" required />
    </div>
    
    <small class="form-text text-muted">Фамилия</small>
    <div class="input-group has-error">
        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
        <input class="input-sm form-control" placeholder="Укажите фамилию" type="text" name="lastname" id="lastname" required />
    </div>
</div>
