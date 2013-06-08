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
        
        if (!$response instanceof \ToolsApi\HalResponse)
        {
            throw new Exception('Invalid Response on Api Index (expected HalReponse!)');
        }
        
        $tools_response = $response->getLink('http://toolsapi.com/rels/tools')->get()->send();
        
        if (!$tools_response instanceof \ToolsApi\HalResponse)
        {
            throw new Exception('Invalid Response on Tools Index (expected HalReponse!)');
        }
        
        $link_for_tool = $tools_response->getLink('http://toolsapi.com/rels/' . $name);
        
        return new ToolsApi\Tool($link_for_tool->post(), $name);
    }
}
