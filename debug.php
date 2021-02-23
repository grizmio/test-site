<?php

function debug(...$var) {
    ob_end_clean();
    $bt = debug_backtrace();
    $caller_file = $bt[0]['file'];
    $caller_line = $bt[0]['line'];
    $caller_function = $bt[1]['function'];

    echo "<p><pre>";
    echo "Archivo:     $caller_file <br>";
    echo "Function:    $caller_function <br>";
    echo "Linea debug: $caller_line <br>";
    echo "</pre></p><br>";
    foreach ($var as $v) {
        echo "<p><pre>";
        var_dump($v);
        echo "</pre></p>";
    }
    exit(-1);
}
