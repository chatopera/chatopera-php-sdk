<?php
// Just include this to load the files correctly
function __autoload($className) {
    require_once(__DIR__.DIRECTORY_SEPARATOR.str_replace("\\", DIRECTORY_SEPARATOR, $className).".php");
}