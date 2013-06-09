<?php
namespace ToolsApi;

class Tool
{
    protected $request = null;
    protected $name = null;
    
    protected $arguments = array();
    protected $local_file_as_stdin = null;
    protected $local_file_as_stdout = null;
    
    public function __construct($request, $name)
    {
        $this->request = $request;
        $this->name = $name;
    }
    
    public function addArgument($key, $value = null)
    {
        $this->arguments[] = array('string', $key);
    }
    
    public function pipeLocalFileToStdIn($file_path)
    {
        $this->local_file_as_stdin = $file_path;
    }
    
    public function pipeStdOutToLocalFile($file_path)
    {
        $this->local_file_as_stdout = $file_path;
    }
    
    public function addLocalFile($file_path)
    {
        $this->arguments[] = array('local_file', $file_path);
    }
    
    public function addLocalFolder($folder_path)
    {
        $this->arguments[] = array('local_folder', $folder_path);
    }
    
    public function addLocalOutputFolder($folder_path, $key = '')
    {
        $this->arguments[] = array('local_output_folder', $folder_path, $key);
    }
    
    public function execute()
    {
        $post_fields = array(
            'args' => array()
        );
        
        $pos = 0;
        $next_subfile_id = 0;
        
        $output_folders = array();
        
        foreach ($this->arguments as $argument)
        {
            if ($argument[0] === 'string')
            {
                $post_fields['arg' . $pos] = $argument[1];
            }
            elseif ($argument[0] === 'local_file')
            {
                $this->request->addPostFile('file' . $pos, $argument[1]);
            }
            elseif ($argument[0] === 'local_folder')
            {
                $subfile_ids_for_folder = array();
                foreach (glob($argument[1] . '/*') as $file_path)
                {
                    $subfile_id = $next_subfile_id;
                    $this->request->addPostFile('subfile' . $subfile_id, $file_path);
                    $subfile_ids_for_folder[] = $subfile_id;
                    $next_subfile_id++;
                };
                
                $post_fields['folder' . $pos] = implode(',', $subfile_ids_for_folder);
            }
            elseif ($argument[0] === 'local_output_folder')
            {
                $post_fields['outputfolder' . $pos] = $argument[2];
                $output_folders[$pos] = $argument[1];
            }
            $pos++;
        }

        if ($this->local_file_as_stdin)
        {
            $this->request->addPostFile('stdinfile', $this->local_file_as_stdin);
        }

        if ($this->local_file_as_stdout)
        {
            $post_fields['stdoutfile'] = 'true';
        }

        $this->request->addPostFields($post_fields);
        
        if (count($output_folders) || $this->local_file_as_stdout)
        {
            $temp_file = tempnam(sys_get_temp_dir(), 'ToolsApiResponse') . '.zip';
            $this->request->setResponseBody(fopen($temp_file, 'w'));
            $response = $this->request->send();
            
            $zip = new \ZipArchive();
            $zip->open($temp_file);
            
            if ($this->local_file_as_stdout)
            {
                if (!$zip->renameName('stdout.txt', basename($this->local_file_as_stdout)))
                {
                    throw new \Exception('Cannot rename stdout.txt to '  . basename($this->local_file_as_stdout));
                }
                if (!$zip->extractTo(dirname($this->local_file_as_stdout), array(basename($this->local_file_as_stdout))))
                {
                    throw new \Exception('Cannot extract ' . basename($this->local_file_as_stdout) . ' to ' . dirname($this->local_file_as_stdout));
                }
            }
            
            foreach ($output_folders as $i => $target_path)
            {
                if (!is_dir($target_path))
                {
                    @mkdir($target_path);
                }
                
                for($p = 0; $p < $zip->numFiles; $p++)
                {
                    $path_to_extract = $zip->getNameIndex($p);
                    
                    if (substr($path_to_extract, 0, strlen('outputfolder' . $i) + 1) === 'outputfolder' . $i . '/' )
                    {
                        $path_for_this_file  = $target_path . '/' . substr($path_to_extract, strlen('outputfolder' . $i) + 1);
                        if (realpath($path_for_this_file) !== realpath($target_path))
                        {
                            $folder_for_this_file = dirname($path_for_this_file);
                            if (!is_dir($folder_for_this_file))
                            {
                                @mkdir($folder_for_this_file);
                            }
                            $path_without_folder = substr($path_to_extract, strlen('outputfolder' . $i) + 1);
                            /*
                             * This CAN make problems, if a project has a folder called outputfolder1 ...
                             */
                            $zip->renameIndex($p, $path_without_folder);
                            $zip->extractTo($folder_for_this_file . '/', array($path_without_folder));
                        }
                    }
                }
            }
            
            $zip->close();
            
            unlink($temp_file);
            return '';
        }
        else
        {
            $response = $this->request->send();
            return $response->getBody(true);
        }
    }
}
