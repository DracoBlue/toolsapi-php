<?php

namespace ToolsApi;

class HalClient extends \Guzzle\Http\Client
{
    /**
     * @return \ToolsApi\HalLink
     */
    public function navigateByLinks($links)
    {
        if (!is_array($links))
        {
            $links = array($links);
        }
        
        $response = $this->get()->send();
        
        if (!$response instanceof \ToolsApi\HalResponse)
        {
            throw new \Exception('Invalid Response on Api Index (expected HalReponse!)');
        }
        
        for ($i = 0; $i < count($links) - 2; $i++)
        {
            $response = $response->getLink($links[$i])->get()->send();
            
            if (!$response instanceof \ToolsApi\HalResponse)
            {
                throw new \Exception('Invalid Response on Link ' . $links[$i] . ' (expected HalReponse!)');
            }
        }
        
        return $response->getLink($links[count($links) - 1]);
    }
    
    public function send($requests)
    {
        $responses = parent::send($requests);
        
        if (is_array($responses))
        {
            $converted_responses = array();
            
            foreach ($responses as $response)
            {
                if ($response->isContentType('application/hal+json'))
                {
                    $converted_responses[] = HalResponse::fromMessage($response->getMessage());
                    $converted_responses[count($converted_responses) - 1]->setHalClient($this);
                }
                else
                {
                    $converted_responses[] = $response;
                }
            }
            
            return $converted_responses;
        }
        
        $response = $responses;
        
        if ($response->isContentType('application/hal+json'))
        {
            $response = HalResponse::fromMessage($response->getMessage());
            $response->setHalClient($this);
        }
        
        return $response;
    }
}
