<?php
include 'include/classes-autoloader.inc.php';

$PhpJSON = new DB\phpjson(array(
    "dburl" => "./JSON_Data.json"
));

echo $PhpJSON->add(array(
    "data" => array(
        array(
            "title" => "Content Title ".rand(0,10),
            "description" => "Content Description",
            "keywords" => "Content Keyword",
            "time" => time()
        )
    ) ,
    "options" => array(
        "unique" => array(
            1,
            "title"
        )
    )
)); 