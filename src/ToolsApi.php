<?php

class ToolsApi
{
    protected $client = null;
    
    public function __construct($url, $key)
    {
        $this->client = new \Guzzle\Http\Client($url);
    }
    
    public function createTool($name)
    {
        return new ToolsApi\Tool($this->client, $name);
    }
}
