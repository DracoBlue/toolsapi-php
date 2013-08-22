<?php

$output_directory = setupAndCleanTestOutputDirectory();

$tool = $app->createTool('fontcustom');
$tool->addArgument('compile');
$tool->addLocalFolder(dirname(__FILE__) . '/icons/');
$tool->addArgument('--debug');
$tool->addLocalOutputFolder($output_directory, '--output=');
$response = $tool->execute();
assert(strpos($response, 'fontcustom.css') !== false);
