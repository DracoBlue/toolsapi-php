<?php
$client = new \ToolsApi\HalClient('http://toolsapi.com/');
$client->getDefaultHeaders()->set('Accept', 'application/hal+json');
/*
 * Test with multiple navigations
 */
$client->navigateByLinks(array('http://toolsapi.com/rels/tools', 'self', 'self'));

/*
 * Test multiple requests at once
 */
$client->send(array($client->get(), $client->get()));

/*
 * Test multiple requests at once (with and without json+hal)
 */
$client->send(array($client->get(), $client->get('favicon.ico')));

/*
 * Test retrieving rels with multiple values
 */
$client->get()->send()->getLink('http://toolsapi.com/rels/tools')->get()->send()->getLinks('http://toolsapi.com/rels/tool');

 
/*
 * Should give an invalid HAL response for api index, when navigation
 */
$client = new \ToolsApi\HalClient('http://toolsapi.com/favicon.ico');
try
{
    $client->navigateByLinks('http://toolsapi.com/rels/tools');
    assert(false);
}
catch (Exception $exception)
{
    
}
