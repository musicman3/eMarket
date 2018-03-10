<?php
/*******************************
	Copyright © 2018 eMarket    
GNU GENERAL PUBLIC LICENSE v.3.0
********************************/

	namespace Model\Classes\View;

	class ViewClass {

		function Routing (){

			$str = str_replace('controller','view/default',$_SERVER['SCRIPT_FILENAME']);

			return $str;
		}

	}

?>