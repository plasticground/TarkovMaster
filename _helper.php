<?php

function d($param) {
    echo '<pre>';
    var_export($param);
    echo '</pre>';
}

function dd($param) {
    d($param);
    die();
}