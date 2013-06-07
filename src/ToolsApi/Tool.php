<?php
namespace ToolsApi;

class Tool
{
    protected $request = null;
    protected $name = null;
    
    protected $arguments = array();
    
    public function __construct($client, $name)
    {
        $this->request = $client->post($name);
        $this->name = $name;
    }
    
    public function addArgument($key, $value = null)
    {
        $this->arguments[] = array('string', $key);
    }
    
    public function addLocalFile($file_path)
    {
        $this->arguments[] = array('local_file', $file_path);
    }
    
    public function execute()
    {
        $post_fields = array(
            'args' => array()
        );
        
        $pos = 0;
        
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
            $pos++;
        }
        
        $this->request->addPostFields($post_fields);
        
        // $temp_file = tempnam(sys_get_temp_dir(), 'ToolsApiResponse');
        // $responseBody = \Guzzle\Http\EntityBody::factory(fopen($temp_file, 'w+'));
        // $request->setResponseBody($responseBody);
        $response = $this->request->send();
        
        return $response->getBody(true);
        // unlink($temp_file);
        // var_dump((string) $response->getBody());
        // var_dump($response);
    }
}
