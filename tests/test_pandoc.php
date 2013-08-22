<?php

$output_directory = setupAndCleanTestOutputDirectory();

$tool = $app->createTool('pandoc');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/test_file.md');
$tool->addArgument('-o');
$tool->addLocalOutputFile($output_directory . '/test_file.pdf');
echo $tool->execute();
