<body>
    <h2>Registro de los Pacientes</h2>
    <?php
//Enviar los datos
    $nombre = $_POST['Nombre'];
    $apellidos = $_POST['Apellidos'];
    $edad = $_POST['Edad'];
    $curp = $_POST['CURP'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $profesion = $_POST['profesion'];
//Validamos datos
if(empty($nombre)){
    die('ERROR, Por favor prorcione nombre(s)');
}
if(empty($apellidos)){
    die('ERROR, Por favor prorcione sus apellidos');
}
if(empty($edad)){
    die('Coloque su edad');
}else if($edad<18||$edad>60){
    die('La persona menor de edad o adulto mayor, por favor consulte a un meédico a la brevedad')
}
if(empty($curp)){
    die('ERROR, ingrese una CURP validad');
}
if(empty($direccion)){
    die('ERROR, Falta ingresar dirección validad');
}
if(empty($email)){
    die('Coloque una dirección de correo valida');
}
if(empty($profesion)){
    die('Se necesita conocer su profesión para asi saber si expuso a mas gente');
}

//Se enviara un correo a la persona para saber si existe una posibilidad de riesgo de contagio del virus
$to = ''//Agregar una dirección
$from = $email;
$subject = 'Posible riego de contagio';
$body = "Nombre: $nombre\r\nDirección: $direccion\r\n
Edad: $edad\r\nProfesión: $profesion\r\n";

if (mail($to,$subject,$body, "From: $from")){
    echo 'Gracias, cuidate y cuida a los demas'
}else{
die('Error');
}
?>
</body>
