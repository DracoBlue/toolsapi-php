<?php

$tool = $app->createTool('jshint');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/invalid_js_file.txt');
$response = $tool->execute();
assert(strpos($response, 'Missing name in function declaration') !== false);
