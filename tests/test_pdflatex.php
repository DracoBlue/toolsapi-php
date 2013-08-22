<?php

$output_directory = setupAndCleanTestOutputDirectory();

$tool = $app->createTool('pdflatex');
$tool->addArgument('-output-directory');
$tool->addLocalOutputFolder($output_directory);
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/valid_latex.tex');
$tool->pipeStdOutToLocalFile($output_directory . '/pdflatex-out-stdout.txt');
$tool->pipeStdErrToLocalFile($output_directory . '/pdflatex-out-stderr.txt');
$tool->execute();
