<?php

$tool = $app->createTool('dig');
$tool->addArgument('toolsapi.com');
$response = $tool->execute();
assert(strpos($response, ' <<>> toolsapi.com') > 0);