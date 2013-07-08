<?php

/*
 * Let's see if stdout is valid
 */
$tool = $app->createTool('dig');
$tool->addArgument('+time=1');
$tool->addArgument('+tries=1');
$tool->addArgument('toolsapi.com');
$response = $tool->execute();
assert(strpos($response, 'toolsapi.com') !== false);

/*
 * Let's see if stdout is valid in file
 */
$tool = $app->createTool('dig');
$tool->addArgument('+time=1');
$tool->addArgument('+tries=1');
$tool->addArgument('toolsapi.com');
$tool->pipeStdOutToLocalFile(dirname(__FILE__) . '/stderr-test-stdout.txt');
$response = $tool->execute();
assert(strlen(trim($response)) === 0);
assert(strpos(file_get_contents(dirname(__FILE__) . '/stderr-test-stdout.txt'), 'toolsapi.com') !== false);

/*
 * and if normal response contains stderr output, too!
 */
$tool = $app->createTool('dig');
$tool->addArgument('-version');
$response = $tool->execute();
assert(strpos(strtolower($response), 'dig') !== false);

/*
 * and if normal response does not contain stderr output, if we piped it!
 */
$tool = $app->createTool('dig');
$tool->addArgument('-version');
$tool->pipeStdErrToLocalFile(dirname(__FILE__) . '/stderr-test-stderr.txt');
$response = $tool->execute();
assert(strlen(trim($response)) === 0);
assert(strpos(strtolower(file_get_contents(dirname(__FILE__) . '/stderr-test-stderr.txt')), 'dig') !== false);

/*
 * Let's see if response only contains stderr, if we piped stdout into a file
 */
$tool = $app->createTool('dig');
$tool->addArgument('-version');
$tool->pipeStdOutToLocalFile(dirname(__FILE__) . '/stderr-test-stdout.txt');
$response = $tool->execute();
assert(strpos(strtolower($response), 'dig') !== false);

/*
 * Let's see if response contains nothing, if we piped stderr and stdout
 */
$tool = $app->createTool('dig');
$tool->addArgument('-version');
$tool->pipeStdOutToLocalFile(dirname(__FILE__) . '/stderr-test-stdout.txt');
$tool->pipeStdErrToLocalFile(dirname(__FILE__) . '/stderr-test-stderr.txt');
$response = $tool->execute();
assert(strlen(trim($response)) === 0);