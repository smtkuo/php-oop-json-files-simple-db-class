<?php
include 'include/classes-autoloader.inc.php';

$PhpJSON = new DB\phpjson(array(
    "dburl" => "./JSON_Data.json"
));

$Results = $PhpJSON->view(array(
    "search" => array(
        "query" => array(
            array(
                "*",
                "title"
            )
        ) ,
        "querytype" => "or",
        "page_totalcount" => 4,
        "page" => 0
    ) ,
    "options" => array(
        "view" => "all"
    )
));

new Functions\jsonWrite($Results);

