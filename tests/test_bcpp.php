<?php

$tool = $app->createTool('bcpp');
$tool->addArgument('-fnc');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/bcpp.cfg');
$tool->addArgument('-fi');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/test_c_file.txt');
$real_content = file_get_contents(dirname(__FILE__) . '/fixtures/test_c_file.txt');
$response = $tool->execute();

$real_lines_count = count(explode("\n", $real_content));
$lines_count = count(explode("\n", $response));

assert($lines_count === 6);
assert($real_lines_count === 7);