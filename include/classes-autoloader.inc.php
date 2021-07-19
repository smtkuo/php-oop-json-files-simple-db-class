<?php  
function my_autoloader($class) { 
	$path = str_replace("\\","/",$class);
	$fileRoad = './classes/' . $path . '.class.php';
	if(!file_exists($fileRoad)){
		return false;
	} 
    include_once $fileRoad;
}
spl_autoload_register('my_autoloader'); 