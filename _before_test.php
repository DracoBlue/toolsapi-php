<?php

if (file_exists(dirname(__FILE__)) . '/vendor/autoload.php')
{
    require_once(dirname(__FILE__) . '/vendor/autoload.php');
}

function setupAndCleanTestOutputDirectory()
{
    $backtrace = debug_backtrace(false);
    
    $folder_name = preg_replace('/.php$/', '', basename($backtrace[0]['file']));
    
    $output_directory = dirname(__FILE__) . '/tests/out/' . $folder_name;
    
    if (is_dir($output_directory))
    {
        shell_exec('rm -rf ' . escapeshellarg($output_directory));
    }
    
    mkdir($output_directory);
    
    return $output_directory;
}

$app = ToolsApi::createInstance();
