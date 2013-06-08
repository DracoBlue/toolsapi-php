<?php

// $app->run('fontcustom', array('file' => dirname(__FILE__) . '/fixtures/yes.svg', 'file2' => dirname(__FILE__) . '/fixtures/no.svg'));

$tool = $app->createTool('jsl');
$tool->addArgument('-stdin');
$tool->pipeLocalFileToStdIn(dirname(__FILE__) . '/fixtures/invalid_js_file.txt');
echo $tool->execute();