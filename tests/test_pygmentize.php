<?php

$tool = $app->createTool('pygmentize');
$tool->addArgument('-l');
$tool->addArgument('php');
/* Yes, we use our own test file to test :) */
$tool->addLocalFile(__FILE__);
$response = $tool->execute();

/* Let's see if parts of the file are part of the output stream! */
assert(strpos($response, 'createTool') !== false);
assert(strpos($response, 'pygmentize') !== false);
