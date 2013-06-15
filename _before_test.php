<?php

if (file_exists(dirname(__FILE__)) . '/vendor/autoload.php')
{
    require_once(dirname(__FILE__) . '/vendor/autoload.php');
}

#$app = new ToolsApi('https://ssl.erstmal.com/toolsapi/', "tester", "password");
#$app = new ToolsApi('http://toolsapi.local/', "tester", "password");
#$app = new ToolsApi('http://toolsapi.com/', "tester", "password");
$app = ToolsApi::createInstance();
