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
        $this->arguments[] = $key;
    }
    
    public function execute()
    {
        // $request->addPostFiles($files);
        $this->request->addPostFields(array('args' => $this->arguments));
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
