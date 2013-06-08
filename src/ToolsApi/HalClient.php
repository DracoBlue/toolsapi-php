<?php

namespace ToolsApi;

class HalClient extends \Guzzle\Http\Client
{
    public function send($requests)
    {
        $responses = parent::send($requests);
        
        if (is_array($responses))
        {
            $responses = array();
            
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
