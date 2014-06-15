<?php

$output_directory = setupAndCleanTestOutputDirectory();

$tool = $app->createTool('phantomjs');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/phantomjs_loadspeed.js');
$tool->addArgument('http://example.org');
$tool->addLocalOutputFolder($output_directory);
#$tool->pipeStdOutToLocalFile($output_directory . '/phantomjs-out-stdout.txt');
$response_raw = $tool->execute();
$response = json_decode($response_raw, true);
assert($response !== false);
assert(isset($response['time']));
$time_in_ms = (int) $response['time'];
assert($time_in_ms > 0);
assert(file_exists($output_directory . '/output.png'));
#echo file_get_contents($output_directory . '/phantomjs-out-stdout.txt');
