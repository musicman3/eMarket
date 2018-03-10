<?php
/****** Copyright © 2018 eMarket ******* 
	Copyright © 2018 eMarket    
* https://github.com/musicman3/eMarket *
****************************************/

	namespace Model\Classes\View;

	class ViewClass {

		function Routing (){

			$str = str_replace('controller','view/default',$_SERVER['SCRIPT_FILENAME']);

			return $str;
		}

	}

?>