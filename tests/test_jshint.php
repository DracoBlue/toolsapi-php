<?php

$tool = $app->createTool('jshint');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/invalid_js_file.txt');
echo $tool->execute();