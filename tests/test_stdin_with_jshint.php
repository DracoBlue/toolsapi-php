<?php

$tool = $app->createTool('jshint');
$tool->addArgument('/dev/stdin');
$tool->pipeLocalFileToStdIn(dirname(__FILE__) . '/fixtures/invalid_js_file.txt');
$response = $tool->execute();
assert(strpos($response, 'Missing name in function declaration') > 0);
