<?php

if (is_dir(dirname(__FILE__) . '/pdflatex-out/'))
{
    foreach (glob(dirname(__FILE__) . '/pdflatex-out/*') as $filename)
    {
        unlink($filename);
    }
    rmdir(dirname(__FILE__) . '/pdflatex-out/');
}

$tool = $app->createTool('pdflatex');
$tool->addArgument('-output-directory');
$tool->addLocalOutputFolder(dirname(__FILE__) . '/pdflatex-out/');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/valid_latex.tex');
echo $tool->execute();