<?php

$client = new \ToolsApi\HalClient('http://toolsapi.com/');

try
{
    $link_for_tool = $client->navigateByLinks(array(
        'http://toolsapi.com/rels/invalid',
    ));
    assert(false);
}
catch (\Exception $exception)
{
    
}

try
{
    $link = new \ToolsApi\HalLink($client, array());
    assert(false);
}
catch (\Exception $exception)
{
    
}

$link_for_tools = new \ToolsApi\HalLink($client, array('href' => 'http://toolsapi.com/rels/invalid'));

try
{
    $link_for_tools->head()->send();
    assert(false);
}
catch (\Exception $exception)
{
    
}

try
{
    $link_for_tools->get()->send();
    assert(false);
}
catch (\Exception $exception)
{
    
}
try
{
    $link_for_tools->options()->send();
    assert(false);
}
catch (\Exception $exception)
{
    
}

try
{
    $link_for_tools->post()->send();
    assert(false);
}
catch (\Exception $exception)
{
    
}
        
        
try
{
    $link_for_tools->patch()->send();
    assert(false);
}
catch (\Exception $exception)
{
    
}
        
try
{
    $link_for_tools->put()->send();
    assert(false);
}
catch (\Exception $exception)
{
    
}
        
        
try
{
    $link_for_tools->delete()->send();
    assert(false);
}
catch (\Exception $exception)
{
    
}
        

        