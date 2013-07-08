<?php

$usage_before = $app->getUsage();

$tool = $app->createTool('dig');
$tool->addArgument('+time=1');
$tool->addArgument('+tries=1');
$tool->addArgument('toolsapi.com');
$response = $tool->execute();
assert(strpos($response, ' toolsapi.com') > 0);

$usage_after = $app->getUsage();
assert($usage_after > $usage_before);
