<?php

function debug(...$var){
    foreach($var as $v){
        echo "<p><pre>";
        var_dump($v);
        echo "</pre></p>";
    }
    exit(-1);
}
