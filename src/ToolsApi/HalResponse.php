<?php

namespace ToolsApi;

class HalResponse extends \Guzzle\Http\Message\Response
{
    protected $hal_client = null;
    
    public function setHalClient(HalClient $client)
    {
        $this->hal_client = $client;
    }
    
    public function getLink($rel)
    {
        $links = $this->getLinks($rel);
        
        if (empty($links))
        {
            throw new \Exception('Cannot find link: ' . $rel . ' on response!');
        }
        
        return $links[0];
    }
    
    public function getLinks($rel)
    {
        $body = $this->getBody(true);
        $json = json_decode($body, true);
        
        if (!isset($json['_links']) || !isset($json['_links'][$rel]))
        {
            return array();
        }
        
        if (isset($json['_links'][$rel][0]))
        {
            $links = array();
            
            foreach ($json['_links'][$rel] as $link)
            {
                $links[] = new HalLink($this->hal_client, $link);
            }
            
            return $links;
        }
        
        return array(new HalLink($this->hal_client, $json['_links'][$rel]));
    }
}
