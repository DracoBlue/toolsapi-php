<?php

// $app->run('fontcustom', array('file' => dirname(__FILE__) . '/fixtures/yes.svg', 'file2' => dirname(__FILE__) . '/fixtures/no.svg'));

$tool = $app->createTool('fontcustom');
$tool->addArgument('compile');
$tool->addLocalFolder(dirname(__FILE__) . '/icons/');
$tool->addArgument('--debug');
$tool->addArgument('--output=out/');
echo $tool->execute();