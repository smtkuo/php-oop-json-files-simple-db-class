<?php 
namespace Functions;

class jsonWrite{
	public function __construct($array = 0)
    { 
		if(!is_array($array)){
			return 0;
		}
		header('Content-Type: application/json');
		echo json_encode($array);
    }
}