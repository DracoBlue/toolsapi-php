<?php
$client = new \ToolsApi\HalClient('http://toolsapi.com/');

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
$client->send(array($client->get(), $client->get('browser/browser.html')));

/*
 * Test retrieving rels with multiple values
 */
$client->get()->send()->getLink('http://toolsapi.com/rels/tools')->get()->send()->getLinks('http://toolsapi.com/rels/tool');

 
/*
 * Should give an invalid HAL response for api index, when navigation
 */
$client = new \ToolsApi\HalClient('http://toolsapi.com/browser/browser.html');
try
{
    $client->navigateByLinks('http://toolsapi.com/rels/tools');
    assert(false);
}
catch (Exception $exception)
{
    
}
