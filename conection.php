<?php   
require 'vendor/autoload.php';
$hosts =  ['https://elastic:ZH8bWoMLTUobqR4lLM60hVl4@1624ac56bdb14b76a4a42fb9b47cfe77.us-east-1.aws.found.io:9243'];

// Kibana
//https://2bbe200001a241a5bdbbf0e45db1b3da.us-east-1.aws.found.io:9243/app/kibana#/dev_tools/console
//elastic
//YA 
$client = Elasticsearch\ClientBuilder::create()
                    ->setHosts($hosts)
                    ->build();
$params = [
    'index' => 'idxdvcovid001'
];

$response = $client->search($params);
//print_r($response);
$hits = count($response['hits']['hits']);
$result = null;
$i = 0;

while ($i < $hits) {
    $result[$i] = $response['hits']['hits'][$i]['_source'];
    $i++;
}

foreach ($result as $key => $value) {
    echo $value['Name'] . "<br>";
}
?>