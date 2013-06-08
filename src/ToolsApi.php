<?php

class ToolsApi
{
    protected $client = null;
    
    public function __construct($url, $key)
    {
        $this->client = new \ToolsApi\HalClient($url);
    }
    
    public function createTool($name)
    {
        $response = $this->client->get()->send();
        
        $link_for_tool = $this->client->navigateByLinks(array(
            'http://toolsapi.com/rels/tools',
            'http://toolsapi.com/rels/' . $name
        ));
        
        return new \ToolsApi\Tool($link_for_tool->post(), $name);
    }
}
