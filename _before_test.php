<?php

if (file_exists(dirname(__FILE__)) . '/vendor/autoload.php')
{
    require_once(dirname(__FILE__) . '/vendor/autoload.php');
}

$app = new ToolsApi('https://ssl.erstmal.com/toolsapi/', "hans");


