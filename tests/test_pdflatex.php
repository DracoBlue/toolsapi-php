<?php

$tool = $app->createTool('pdflatex');
$tool->addLocalFile(dirname(__FILE__) . '/fixtures/valid_latex.tex');
echo $tool->execute();