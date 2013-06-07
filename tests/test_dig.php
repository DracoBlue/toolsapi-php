<?php

$tool = $app->createTool('dig');
$tool->addArgument('toolsapi.com');
echo $tool->execute();

