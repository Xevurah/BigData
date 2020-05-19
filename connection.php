<?php
require 'vendor/autoload.php';

$hosts = ['localhost:9200'];
//$hosts = ['https://elastic:ZH8bWoMLTUobqR4lLM60hVl4@1624ac56bdb14b76a4a42fb9b47cfe77.us-east-1.aws.found.io:9243'];

$client = Elasticsearch\ClientBuilder::create()
					->setHosts($hosts)
					->build();

$json = $_POST['latitudlon'];

$respuesta1 = $_POST["Respuesta1"];
$respuesta2 = $_POST["Respuesta2"];
$respuesta3 = $_POST["Respuesta3"];
$respuesta4 = $_POST["Respuesta4"];
$respuesta5 = $_POST["Respuesta5"];
$respuesta6 = $_POST["Respuesta6"];

$datetime = $_POST["datetimepicker1"];
$nombre = $_POST["inputnombre"];
$apellidos = $_POST["inputapellidos"];
$email = $_POST["inputemail"];
$municipio = $_POST["inputmunicipio"];
$ciudad = $_POST["inputciudad"];
$gen = $_POST["inputgen"];
$curp = $_POST["inputcurp"];

$tos = $_POST["tosCheck"];
$fiebre = $_POST["fiebreCheck"];
$check = $_POST["cabezaCheck"];
$respir = $_POST["respirCheck"];
$garga = $_POST["gargaCheck"];
$escur = $_POST["escurCheck"];
$ojos = $_POST["ojosCheck"];
$dolor = $_POST["dolorCheck"];

echo $respuesta1. "<br>";
echo $respuesta2. "<br>";
echo $respuesta3. "<br>";
echo $respuesta4. "<br>";
echo $respuesta5. "<br>";
echo $respuesta6. "<br>";

echo $datetime. "<br>";
echo $nombre. "<br>";
echo $apellidos. "<br>";
echo $email. "<br>";
echo $municipio. "<br>";
echo $ciudad. "<br>";
echo $gen. "<br>";
echo $curp. "<br>";

echo $tos. "<br>";
echo $fiebre. "<br>";
echo $check. "<br>";
echo $respir. "<br>";
echo $garga. "<br>";
echo $escur. "<br>";
echo $ojos. "<br>";
echo $dolor. "<br>";

$jsondecoded = json_decode($json,true);


$norte = $jsondecoded["north"];
$sur = $jsondecoded["south"];
$este = $jsondecoded["east"];
$oeste = $jsondecoded["west"];

echo $norte. "<br>";
echo $sur. "<br>";
echo $este. "<br>";
echo $oeste. "<br>";


$params = [
		'index' => 'id_equipo3',
		'type' => '_doc',
		'body' => [
			'query'=> [
				'match' => [
					'name' => 'Monica'
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
			echo $value['name'] . "<br>";
			echo $value['lastName'] . "<br>";
			echo $value['edad'] . "<br>";
			echo $value['genero'] . "<br>";
			echo $value['municipio'] . "<br>";			
			echo $value['location']["lat"] . "<br>";
			echo $value['location']["lon"] . "<br>";
			echo $value['fecha'] . "<br>";
			
			if (($value['location']["lat"]."" < $norte && $value['location']["lat"]."" > $sur) && ($value['location']["lon"]."" < $este && $value['location']["lon"]."" > $oeste)) 
			{echo "se encuentra entre la geocerca";}
}

//{"south":21.85047776866842,"west":-102.32387956115721,"north":21.914195116426935,"east":-102.24131043884276}
?>