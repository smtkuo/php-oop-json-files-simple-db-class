<?php
include 'include/classes-autoloader.inc.php';

$PhpJSON = new DB\phpjson(array(
    "dburl" => "./JSON_Data.json"
));

$Results = $PhpJSON->del(array(
    "search" => array(
        "query" => array(
            array(
                "3",
                "JSON_KEY"
            )
        ) ,
        "querytype" => "or",
        "page_totalcount" => 10000,
		"page"=>0
    ) ,
    "options" => array(
        "view" => "all"
    ),
    "remove" => 1
));

new Functions\jsonWrite($Results);

