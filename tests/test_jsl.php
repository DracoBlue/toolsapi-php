<?php

$tool = $app->createTool('jsl');
$tool->addArgument('-process');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/invalid_js_file.txt');
$response = $tool->execute();
assert(strpos($response, ' missing } after function body') > 0);
