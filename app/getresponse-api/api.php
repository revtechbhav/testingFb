<?php 

include 'GetResponseAPI3.class.php';
$getresponse = new GetResponse('8c0553655d39ed5a789e34228a0dec3e');
//$getresponse->api_url = 'https://api3.getresponse360.pl/v3';
$details = $getresponse->getCampaigns();

/*echo "<pre>";
print_r($details);
echo "</pre>";*/

$result = $getresponse->addContact(array(
    'name'              => 'My virtual',
    'email'             => 'revin.testing@gmail.com',
    'dayOfCycle'        => 10,
    'campaign'          => array('campaignId' => '4zGYw'),
    'description'   => 'sdgdsg sdgdsgd',
));

echo "<pre>";
print_r($result);
echo "</pre>";
die;

