<?php

if (is_dir(dirname(__FILE__) . '/pandoc-out/'))
{
    foreach (glob(dirname(__FILE__) . '/pandoc-out/*') as $filename)
    {
        unlink($filename);
    }
    rmdir(dirname(__FILE__) . '/pandoc-out/');
}

$tool = $app->createTool('pandoc');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/test_file.md');
$tool->addArgument('-o');
$tool->addLocalOutputFile(dirname(__FILE__) . '/pandoc-out/test_file.pdf');
echo $tool->execute();
