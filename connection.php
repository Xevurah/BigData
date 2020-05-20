<?php
require 'vendor/autoload.php';

$hosts = ['localhost:9200'];
//$hosts = ['https://elastic:ZH8bWoMLTUobqR4lLM60hVl4@1624ac56bdb14b76a4a42fb9b47cfe77.us-east-1.aws.found.io:9243'];

$client = Elasticsearch\ClientBuilder::create()
					->setHosts($hosts)
					->build();

if (isset($_POST['latitudlon'])){
    $json = $_POST["latitudlon"];
}else $json = "{\"south\":21.85047776866842,\"west\":-102.32387956115721,\"north\":21.914195116426935,\"east\":-102.24131043884276}";

// latitudlon example:
// {"south":21.85047776866842,"west":-102.32387956115721,"north":21.914195116426935,"east":-102.24131043884276}

$coincidencia = 0;
$coincidenciafecha = 0;

if (isset($_POST['Respuesta1'])){
    $respuesta1 = $_POST["Respuesta1"];
}else $respuesta1 = "0";
if (isset($_POST['Respuesta2'])){
    $respuesta2 = $_POST["Respuesta2"];
}else $respuesta2 = "0";
if (isset($_POST['Respuesta3'])){
    $respuesta3 = $_POST["Respuesta3"];
}else $respuesta3 = "0";
if (isset($_POST['Respuesta4'])){
    $respuesta4 = $_POST["Respuesta4"];
}else $respuesta4 = "0";
if (isset($_POST['Respuesta5'])){
    $respuesta5 = $_POST["Respuesta5"];
}else $respuesta5 = "0";
if (isset($_POST['Respuesta6'])){
    $respuesta6 = $_POST["Respuesta6"];
}else $respuesta6 = "0";

if (isset($_POST['datetimepicker1'])){
    $datetime = $_POST["datetimepicker1"];
}else $datetime = "0";

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

$jsondecoded = json_decode($json,true);


$norte = $jsondecoded["north"];
$sur = $jsondecoded["south"];
$este = $jsondecoded["east"];
$oeste = $jsondecoded["west"];


$params = [
		'index' => 'id_equipo3',
		'type' => '_doc',
		'body' => [
			'query' => [
				'geo_bounding_box' => [ 
					'location' => [
						'top_left' => [
							"lat" => $norte,
							"lon" => $oeste
							],
						"bottom_right" => [
							"lat" => $sur,
							"lon" => $este
							]
						]
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
 
$datetimestamp1= strtotime(substr($datetime,0,10));

if (is_array($result) || is_object($result))
{
foreach ($result as $key => $value){
            //echo $value['name'] . "<br>";
            //echo $value['lastName'] . "<br>";
            //echo $value['edad'] . "<br>";
            //echo $value['genero'] . "<br>";
            //echo $value['municipio'] . "<br>";			
            //echo $value['location']["lat"] . "<br>";
            //echo $value['location']["lon"] . "<br>";
            //echo $value['fecha'] . "<br>";

            $date2plus= new DateTime($value['fecha']);

            $date2plus->add(new DateInterval('P3D'));

            $resultdate = $date2plus->format('Y-m-d');
            //echo $resultdate . "<br>";
            $krr    = explode('-', $resultdate);
            $resultdate = implode("", $krr);

            $datetimestamp2= strtotime($value['fecha']);
            $datetimestamp2plus = strtotime($resultdate);

            if ($datetimestamp1 >= $datetimestamp2 && $datetimestamp1 <= $datetimestamp2plus) 
            {$coincidenciafecha++;}

			$coincidencia++;
}
}else{
$coincidencia = 0;
}

$point = 15;
$factor = 0;
if((int)$respuesta1 < 1){
$factor++;}
if((int)$respuesta2 < 1){
$factor++;}
if((int)$respuesta3 < 1){
$factor++;
$factor++;
}
if((int)$respuesta4 < 1){
$factor++;}
if((int)$respuesta5 < 1){
$factor++;}
if((int)$respuesta6 < 1){
$factor++;}
if((int)$tos>0){
$factor++;}
if((int)$fiebre>0){
$factor++;}
if((int)$check>0){
$factor++;}
if((int)$respir>0){
$factor++;}
if((int)$garga>0){
$factor++;}
if((int)$escur>0){
$factor++;}
if((int)$ojos>0){
$factor++;}
if((int)$dolor>0){
$factor++;}
if((int)$coincidencia>0){
for ($i = 1; $i <= $coincidencia; $i++) {
    $factor++;
    $factor++;
    $point++;
    $point++;
}
}else{
$point++;
$point++;
}
if((int)$coincidenciafecha>0){
for ($i = 1; $i <= $coincidenciafecha; $i++) {
    $factor++;
    $factor++;
    $factor++;
    $point++;
    $point++;
    $point++;
}
}else
{
$point++;
$point++;
$point++;
}

$factor;

//echo $respuesta1. "<br>";
//echo $respuesta2. "<br>";
//echo $respuesta3. "<br>";
//echo $respuesta4. "<br>";
//echo $respuesta5. "<br>";
//echo $respuesta6. "<br>";

//echo $datetime. "<br>";
//echo $nombre. "<br>";
//echo $apellidos. "<br>";
//echo $email. "<br>";
//echo $municipio. "<br>";
//echo $ciudad. "<br>";
//echo $gen. "<br>";
//echo $curp. "<br>";

//echo $tos. "<br>";
//echo $fiebre. "<br>";
//echo $check. "<br>";
//echo $respir. "<br>";
//echo $garga. "<br>";
//echo $escur. "<br>";
//echo $ojos. "<br>";
//echo $dolor. "<br>";

//echo $norte. "<br>";
//echo $sur. "<br>";
//echo $este. "<br>";
//echo $oeste. "<br>";
//echo $coincidencia. "<br>";
//echo $coincidenciafecha. "<br>";




?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <title>Hello, world!</title>
    <style>
        header {
    position: relative;
  background-color: black;
  height: 75vh;
  min-height: 25rem;
  width: 100%;
  overflow: hidden;
}

header video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  z-index: 0;
  -ms-transform: translateX(-50%) translateY(-50%);
  -moz-transform: translateX(-50%) translateY(-50%);
  -webkit-transform: translateX(-50%) translateY(-50%);
  transform: translateX(-50%) translateY(-50%);
}

header .container {
  position: relative;
  z-index: 2;
}

header .overlay {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-color: black;
  opacity: 0.5;
  z-index: 1;
}

@media (pointer: coarse) and (hover: none) {
  header {
    background: url('https://source.unsplash.com/XT5OInaElMw/1600x900') black no-repeat center center scroll;
  }
  header video {
    display: none;
  }
}
        input[type='radio'] {
            transform: scale(1.5);
        }

        body {
            text-align: center;
            padding-top: 25px;
        }
        /* Set the size of the div element that contains the map */
        #map {
            height: 400px; /* The height is 400 pixels */
            width: 100%; /* The width is the width of the web page */
        }

        #description {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
        }

        #infowindow-content .title {
            font-weight: bold;
        }

        #infowindow-content {
            display: none;
        }

        #map #infowindow-content {
            display: inline;
        }

        .pac-card {
            margin: 10px 10px 0 0;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            font-family: Roboto;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

            .pac-controls label {
                font-family: Roboto;
                font-size: 13px;
                font-weight: 300;
            }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
        }

            #pac-input:focus {
                border-color: #4d90fe;
            }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }

        #target {
            width: 345px;
        }
    </style>
</head>
<body class="bg-info">
    <header>
  <div class="overlay"></div>
  <video playsinline="playsinline" id="myVideo" autoplay="autoplay" loop="loop">
    <source src="videos/Mt_Baker.mp4" type="video/mp4">
  </video>
  <div class="container h-100">
    <div class="d-flex h-100 text-center align-items-center">
      <div class="w-100 text-white">
        <h1 id="videohead" class="display-3"></h1>
        <p id="videoheadsub" class="lead mb-0"></p>
      </div>
    </div>
  </div>
</header>
    <div class="jumbotron">
  <h1 class="display-4">Como se propaga la COVID-19?</h1>
        <div class="container">
  <p class="lead">Una persona puede contraer la COVID-19 por contacto con otra que este infectada por el virus. 
        La enfermedad se propaga principalmente de persona a persona a traves de goticulas que salen despedidas de la nariz o la boca de una persona infectada al toser, estornudar o hablar. 
        Estas goticulas son relativamente pesadas, no llegan muy lejos y caen rapidamente al suelo. Una persona puede contraer COVID-19 si inhala las goticulas procedentes de una persona infectada por el virus. 
        Por eso es importante mantenerse al menos a un metro de distancia de los demas. Estas goticulas pueden caer sobre objetos y superficies que rodean a la persona, como mesas, pomos y barandillas, de modo que otras personas pueden 
        infectarse si tocan esos objetos o superficies y luego se tocan los ojos, nariz o la boca. Por ello es importante lavarse las manos frecuentemente con agua y jabon o con un desinfectante a base de alcohol</p>
            </div>
  <hr class="my-4">
  <p>Para mayores dudas, puedes consultar la pagina oficial de la OMS con este boton.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="https://www.who.int/es/emergencies/diseases/novel-coronavirus-2019/advice-for-public/q-a-coronaviruses?gclid=CjwKCAjwh472BRAGEiwAvHVfGvzEUDBwnrw0kVoJgwtYdovsSVY4y6hz1tNF8VqLj-RgmiX4_Lgp0BoCeEkQAvD_BwE" role="button">Aprende mas</a>
  </p>
</div>
    <script>
        document.getElementById("myVideo").volume = 0.2;
        var factor = <?php echo $factor; ?>;
        var point = <?php echo $point; ?>;
        var factorporcentaje = Math.round((factor * 100 / point) *100)/100;

        if (factorporcentaje < 60) {
            $("#videoheadsub").text("El porcentaje de exposicion de COVID-19 fue de: " + factorporcentaje + "%");
            $("#videohead").text("No te confies, sigue las medidas sanitarias");
        }
        
        if (factorporcentaje >= 60) {
            $("#videoheadsub").text("El porcentaje de exposicion de COVID-19 fue de: " + factorporcentaje + "%");
            $("#videohead").text("Quedate en casa");
            $("#myVideo > source").attr("src", "videos/DancingFun_Trim.mp4");
        }
    </script>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
</body>
</html>