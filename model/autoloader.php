<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 
//Автозагрузчик классов
set_include_path($_SERVER['DOCUMENT_ROOT'] . '/model/vendor/' . PATH_SEPARATOR . get_include_path()); 
spl_autoload_extensions('.php , .class.php'); 
spl_autoload_register(); 
function linux_namespaces_autoload ($class_name) 
    { 
     /* use if you need to lowercase first char * 
     $class_name = implode(DIRECTORY_SEPARATOR , array_map('lcfirst' , explode('\\' , $class_name)));/* else just use the following : */ 
     $class_name = implode(DIRECTORY_SEPARATOR , explode('\\' , $class_name)); 
     static $extensions = array(); 
     if (empty($extensions)) 
      { 
       $extensions = array_map('trim' , explode(',' , spl_autoload_extensions())); 
      } 
     static $include_paths = array(); 
     if (empty($include_paths)) 
      { 
       $include_paths = explode(PATH_SEPARATOR , get_include_path()); 
      } 
     foreach ($include_paths as $path) 
      { 
       $path .= (DIRECTORY_SEPARATOR !== $path[ strlen($path) - 1 ]) ? DIRECTORY_SEPARATOR : ''; 
       foreach ($extensions as $extension) 
        { 
         $file = $path . $class_name . $extension; 
         if (file_exists($file) && is_readable($file)) 
          { 
           require $file; 
           return; 
          } 
        } 
      } 
     throw new Exception(_('class ' . $class_name . ' could not be found.')); 
     
    } 
spl_autoload_register('linux_namespaces_autoload' , TRUE , FALSE); 

//LOAD CLASS Valid
$VALID = new emarket\classes\core\valid;

//LOAD CLASS Pdo
$PDO = new emarket\classes\core\pdo;

//LOAD CLASS View
$TEMPLATE = 'default'; //название текущего шаблона
$VIEW = new emarket\classes\core\view;

?>
