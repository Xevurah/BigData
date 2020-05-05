<?php
require 'vendor/autoload.php';

$hosts = ['localhost:9200'];
//$hosts = ['https://elastic:ZH8bWoMLTUobqR4lLM60hVl4@1624ac56bdb14b76a4a42fb9b47cfe77.us-east-1.aws.found.io:9243'];

$client = Elasticsearch\ClientBuilder::create()
					->setHosts($hosts)
					->build();

$params = [
		'index' => 'idxdvcovid001',
		'type' => '_doc',
		'body' => [
			'query'=> [
				'match' => [
					'Name' => 'Eduardo'
			]
		]
	]
];

$response = $client->search($params);

$hits = count($response['hits']['hits']);
$result = null;
$i = 0;

while ($i < $hits){
			$result[$i] = $response['hits']['hits'][$i]['_source'];
			$i++;
}

foreach ($result as $key => $value){
			echo $value['Name'] . "<br>";
}

?>