<?php

namespace ToolsApi;

class HalLink 
{
    protected $client = null;
    protected $uri = null;
    protected $data = array();
    
    public function __construct($client, array $data)
    {
        if (!isset($data['href']))
        {
            throw new \Exception('No href set in HalLink!');
        }
        
        $this->client = $client;
        $this->uri = $data['href'];
        $this->data = $data;
    }
    
    public function getTitle()
    {
        if (isset($this->data['title']))
        {
            return $this->data['title'];
        }

        return '';
    }

    public function get($headers = null, $body = null)
    {
        return $this->client->get($this->uri, $headers, $body);
    }

    public function head($headers = null)
    {
        return $this->client->head($this->uri, $headers);
    }

    public function delete($headers = null, $body = null)
    {
        return $this->client->delete($this->uri, $headers, $body);
    }

    public function put($headers = null, $body = null)
    {
        return $this->client->put($this->uri, $headers, $body);
    }

    public function patch($headers = null, $body = null)
    {
        return $this->client->patch($this->uri, $headers, $body);
    }

    public function post($headers = null, $postBody = null)
    {
        return $this->client->post($this->uri, $headers, $postBody);
    }

    public function options()
    {
        return $this->client->options($this->uri);
    }

}
