<?php

class ToolsApi
{
    protected $client = null;
    
    public function __construct($url, $username, $password)
    {
        $this->client = new \ToolsApi\HalClient($url);
        $this->client->getDefaultHeaders()->set('Accept', 'application/hal+json');
        $this->client->getDefaultHeaders()->set('Authorization', 'Basic ' . base64_encode($username . ':' . $password));
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
    
    public function getUsage()
    {
        $response = $this->client->get()->send();
        
        $account_link = $this->client->navigateByLinks(array(
            'http://toolsapi.com/rels/account'
        ));
        
        $response = json_decode($account_link->get()->send()->getBody(true), true);
        
        return $response['usage'];
    }
}
