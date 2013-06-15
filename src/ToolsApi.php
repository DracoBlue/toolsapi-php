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

    public static function createInstance()
    {
        $properties_file_paths = array(
            getcwd() . '/toolsapi.properties',
            '~/toolsapi.properties',
            '/etc/toolsapi.properties',
        );

        foreach ($properties_file_paths as $properties_file_path)
        {
            if (file_exists($properties_file_path))
            {
                $properties_content = file_get_contents($properties_file_path);
                preg_match_all('/^([^\=]+)\=(.*)$/m', $properties_content, $properties_matches);

                unset($properties_matches[0]);

                $properties = array();
                foreach ($properties_matches[1] as $pos => $properties_match)
                {
                    $properties[$properties_match] = $properties_matches[2][$pos];
                }

                if (!isset($properties['user']) || !isset($properties['password']) || !isset($properties['url']))
                {
                    throw new Exception('toolsapi.properties must contain user, password and url key!');
                }

                return new self($properties['url'], $properties['user'], $properties['password']);
            }
        }

        throw new \Exception("Cannot find toolsapi.properties at any of those paths: " . implode(', ', $properties_file_paths));
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

    public function getTools()
    {
        $link_for_tools = $this->client->navigateByLinks(array(
            'http://toolsapi.com/rels/tools'
        ));

        $tools = array();

        foreach ($link_for_tools->get()->send()->getLinks('http://toolsapi.com/rels/tool') as $link_for_tool)
        {
            $tools[] = new \ToolsApi\Tool($link_for_tool->post(), $link_for_tool->getTitle());
        }

        return $tools;
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
