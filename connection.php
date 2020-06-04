<?php
require 'vendor/autoload.php';

$hosts = ['localhost:9200'];
//$hosts = ['https://elastic:ZH8bWoMLTUobqR4lLM60hVl4@1624ac56bdb14b76a4a42fb9b47cfe77.us-east-1.aws.found.io:9243'];

$client = Elasticsearch\ClientBuilder::create()
					->setHosts($hosts)
					->build();


//if (isset($_POST['latitudlon'])){
//   $json = $_POST["latitudlon"];
//}else{
//	$json = "{\"south\":21.85047776866842,\"west\":-102.32387956115721,\"north\":21.914195116426935,\"east\":-102.24131043884276}";}
//$json = "{\"south\":21.85047776866842,\"west\":-102.32387956115721,\"north\":21.914195116426935,\"east\":-102.24131043884276}";
// Aqui arriba se utiliza un json de ejemplo de recepcion de datos para armar mapa


// latitudlon example:
// {"south":21.85047776866842,"west":-102.32387956115721,"north":21.914195116426935,"east":-102.24131043884276}

if (isset($_POST['marcas'])){
    $marcas = $_POST["marcas"];
}else {$marcas = "nyet";}



if ((int)$marcas > (-1))
{
for($i = 0; $i <= $marcas; $i++)
{
if (isset($_POST['lati'.$i])){
    $lati[$i] = $_POST['lati'.$i];
}else {$lati[$i] = "nyet";}
if (isset($_POST['longi'.$i])){
    $longi[$i] = $_POST['longi'.$i];
}else {$longi[$i] = "nyet";}
if (isset($_POST['time'.$i])){
    $time[$i] = $_POST['time'.$i];
}else {$time[$i] = "nyet";}
$timereplaced[$i] = str_replace("T", " ",$time[$i]);
}
}


//echo ((int)$marcas+1). "<br>";

//echo $lati[0]. "<br>";
//echo $longi[0]. "<br>";
//echo $timereplaced[0]. "<br>";
//echo $lati[1]. "<br>";
//echo $longi[1]. "<br>";
//echo $timereplaced[1]. "<br>";
//echo $lati[2]. "<br>";
//echo $longi[2]. "<br>";
//echo $timereplaced[2]. "<br>";

$coincidencia = 0;
$coincidenciafecha = 0;

if (isset($_POST['Respuesta1'])){
    $respuesta1 = $_POST["Respuesta1"];
}else {$respuesta1 = "0";}
if (isset($_POST['Respuesta2'])){
    $respuesta2 = $_POST["Respuesta2"];
}else{ $respuesta2 = "0";}
if (isset($_POST['Respuesta3'])){
    $respuesta3 = $_POST["Respuesta3"];
}else {$respuesta3 = "0";}
if (isset($_POST['Respuesta4'])){
    $respuesta4 = $_POST["Respuesta4"];
}else{ $respuesta4 = "0";}
if (isset($_POST['Respuesta5'])){
    $respuesta5 = $_POST["Respuesta5"];
}else {$respuesta5 = "0";}
if (isset($_POST['Respuesta6'])){
    $respuesta6 = $_POST["Respuesta6"];
}else {$respuesta6 = "0";}

if (isset($_POST['datetimepicker1'])){
    $datetime = $_POST["datetimepicker1"];
}else {$datetime = "0";}

if (isset($_POST["inputnombre"])){
$nombre = $_POST["inputnombre"];
}else {$nombre = "Anonimo";}
if (isset($_POST["inputapellidos"])){
$apellidos = $_POST["inputapellidos"];
}else {$apellidos = "Anonimo";}
if (isset($_POST["inputemail"])){
$email = $_POST["inputemail"];
}else {$email = " ";}
if (isset($_POST["inputgen"])){
$gen = $_POST["inputgen"];
}else {$gen = "datoprueba";}
if (isset($_POST["inputmunicipio"])){
$municipio = $_POST["inputmunicipio"];
}else {$municipio = "datoprueba";}
if (isset($_POST["inputciudad"])){
$ciudad = $_POST["inputciudad"];
}else {$ciudad = "datoprueba";}
if (isset($_POST["inputmunicipio"])){
$municipio = $_POST["inputmunicipio"];
}else {$municipio = "datoprueba";}
if (isset($_POST["inputcurp"])){
$curp = $_POST["inputcurp"];
}else {$curp = "datoprueba";}

if (isset($_POST["symptoms"])){
$sym = $_POST["symptoms"];
}else {$sym = "datoprueba";}

//$email = $_POST["inputemail"];
//$ciudad = $_POST["inputciudad"];
//$curp = $_POST["inputcurp"];

$tos = $_POST["tosCheck"];
$fiebre = $_POST["fiebreCheck"];
$check = $_POST["cabezaCheck"];
$respir = $_POST["respirCheck"];
$garga = $_POST["gargaCheck"];
$escur = $_POST["escurCheck"];
$ojos = $_POST["ojosCheck"];
$dolor = $_POST["dolorCheck"];


$fac = 0;
if((int)$tos>0){
    $fac++;}
    if((int)$fiebre>0){
    $fac++;}
    if((int)$check>0){
    $fac++;}
    if((int)$respir>0){
    $fac++;}
    if((int)$garga>0){
    $fac++;}
    if((int)$escur>0){
    $fac++;}
    if((int)$ojos>0){
    $fac++;}
    if((int)$dolor>0){
    $fac++;}



//$jsondecoded = json_decode($json,true);


//$norte = $jsondecoded["north"];
//$sur = $jsondecoded["south"];
//$este = $jsondecoded["east"];
//$oeste = $jsondecoded["west"];

for($x = 0; $x <= $marcas; $x++)
{
//echo $lati[$x]."<br>";
//echo $longi[$x]."<br>";
//echo $time[$x]."<br>";

$params = [
		'index' => 'id_equipo3',
		'type' => '_doc',
		'body' => [
			'query' => [
				'geo_distance' => [
                    'distance' => '10m', 
					'location' => [
							"lat" => $lati[$x],
							"lon" => $longi[$x]
						]
					]
				]
	]
];

//GET id_equipo3/_search
//{
//    "query": {
//        "bool" : {
//            "must" : {
//                "match_all" : {}
//            },
//            "filter" : {
//                "geo_distance" : {
//                    "distance" : "200km",
//                    "location" : {
//                        "lat" : 41.008233547347,
//                        "lon" : -72.000022379514
//                    }
//                }
//            }
//        }
//    }
//}


$response = $client->search($params);

$hits = count($response['hits']['hits']);
$result = null;
$i = 0;

while ($i < $hits){
			$result[$i] = $response['hits']['hits'][$i]['_source'];
			$i++;
}
 
$datetimestamp1= strtotime(substr($time[$x],0,10));

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

            //echo $resultdate . "<br>";
           // echo $datetimestamp1 . "<br>";
            //echo $datetimestamp2 . "<br>";
            //echo $datetimestamp2plus . "<br>";

            if ($datetimestamp1 >= $datetimestamp2 && $datetimestamp1 <= $datetimestamp2plus) 
            {$coincidenciafecha++;}

			$coincidencia++;
}
}else{
}

}

for($y = 0; $y <= $marcas; $y++)
{

$params = [
        'index' => 'id_equipo3',
        'type' => '_doc',
        'body' => [
            'name' => $nombre,
            'lastName' => $apellidos,
            'email' => $email,
            'curp' => $curp,
            'genero' => $gen,
            'municipio' => $municipio,
            'ciudad' => $ciudad,
            'symptoms' => $fac,
            'location' => [
                'lat' => $lati[$y],
                "lon" => $longi[$y]
        ],
            'fecha' => $timereplaced[$y].":00"
    ]
];

////POST _bulk
////{"name": "Monica",
//// "lastName": "Lopez",
////"edad":"14",
////"genero":"mujer",
////"municipio":"San francisco",
////"location":{"lat":"21.880575627074684", "lon":"-102.2972846031189"},
//// "fecha": "2020-05-26 05:56:00"}

$response = $client->index($params);

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
//echo  "<br>". $coincidencia. "<br>";
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
		var tos = <?php echo $tos; ?>;
		if(tos>0){
		tos="tos"}
		else{
		tos=""}
		var fiebre = <?php echo $fiebre; ?>;
		if(fiebre>0){
		fiebre="fiebre"}
		else{
		fiebre=""}
		var check = <?php echo $check; ?>;
		if(check>0){
		check="dolor de cabeza"}
		else{
		check=""}
		var respir = <?php echo $respir; ?>;
		if(respir>0){
		respir="dificultad de respirar"}
		else{
		respir=""}
		var garga = <?php echo $garga; ?>;
		if(garga>0){
		garga="dolor de garganta"}
		else{
		garga=""}
		var escur = <?php echo $escur; ?>;
		if(escur>0){
		escur="escurrimiento nasal"}
		else{
		escur=""}
		var ojos = <?php echo $ojos; ?>;
		if(ojos>0){
		ojos="ojos llorosos"}
		else{
		ojos=""}
		var dolor = <?php echo $dolor; ?>;
		if(dolor>0){
		dolor="dolor muscular"}
		else{
		dolor=""}
        var factorporcentaje = Math.round((factor * 100 / point) *100)/100;

//$tos = $_POST["tosCheck"];
//$fiebre = $_POST["fiebreCheck"];
//$check = $_POST["cabezaCheck"];
//$respir = $_POST["respirCheck"];
//$garga = $_POST["gargaCheck"];
//$escur = $_POST["escurCheck"];
//$ojos = $_POST["ojosCheck"];
//$dolor = $_POST["dolorCheck"];

        if (factorporcentaje < 99) {
            $("#videoheadsub").text("El porcentaje de exposicion de COVID-19 fue de: " + factorporcentaje + "%\n"+ "los sintomas fueron: "+ tos +" "+ fiebre+" "+ check+" "+ respir+" "+ garga+" "+ escur+" "+ ojos+" "+ dolor);
            $("#videohead").text("No te confies, sigue las medidas sanitarias");
        }
        
        if (factorporcentaje >= 99) {
            $("#videoheadsub").text("El porcentaje de exposicion de COVID-19 fue de: " + factorporcentaje + "%\n" + "los sintomas fueron: "+ tos +" "+ fiebre+" "+ check+" "+ respir+" "+ garga+" "+ escur+" "+ ojos+" "+ dolor);
            $("#videohead").text("Quedate en casa");
            $("#myVideo > source").attr("src", "videos/DancingFun_Trim.mp4");
        }
    </script>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
</body>
</html>