<?php

if (is_dir(dirname(__FILE__) . '/fontcustom-out/'))
{
    foreach (glob(dirname(__FILE__) . '/fontcustom-out/*') as $filename)
    {
        unlink($filename);
    }
    foreach (glob(dirname(__FILE__) . '/fontcustom-out/.font*') as $filename)
    {
        unlink($filename);
    }
    rmdir(dirname(__FILE__) . '/fontcustom-out/');
}


$tool = $app->createTool('fontcustom');
$tool->addArgument('compile');
$tool->addLocalFolder(dirname(__FILE__) . '/icons/');
$tool->addArgument('--debug');
$tool->addLocalOutputFolder(dirname(__FILE__) . '/fontcustom-out/', '--output=');
echo $tool->execute();