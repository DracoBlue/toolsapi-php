<?php

class ToolsApi
{
    protected $client = null;
    
    public function __construct($url, $key)
    {
        $this->client = new \Guzzle\Http\Client($url);
    }
    
    public function run($cmd, $files)
    {
        $request = $this->client->post($cmd);
        $request->addPostFiles($files);
        $temp_file = tempnam(sys_get_temp_dir(), 'ToolsApiResponse');
        $responseBody = \Guzzle\Http\EntityBody::factory(fopen($temp_file, 'w+'));
        $request->setResponseBody($responseBody);
        $response = $request->send();
        unlink($temp_file);
        // var_dump((string) $response->getBody());
        // var_dump($response);
    }
}
