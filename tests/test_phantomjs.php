<?php

$tool = $app->createTool('phantomjs');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/phantomjs_loadspeed.js');
$tool->addArgument('http://en.wikipedia.org/wiki/Main_Page');
$tool->addLocalOutputFolder(dirname(__FILE__) . '/pictures/');
#$tool->pipeStdOutToLocalFile(dirname(__FILE__) . '/phantomjs-out-stdout.txt');
$response_raw = $tool->execute();
$response = json_decode($response_raw, true);
assert($response !== false);
assert(isset($response['time']));
$time_in_ms = (int) $response['time'];
assert($time_in_ms > 0);
assert(file_exists(dirname(__FILE__) . '/pictures/output.png'));
#echo file_get_contents(dirname(__FILE__) . '/phantomjs-out-stdout.txt');
