<?php
require 'db.php';
require 'jwt.php';

// Habilitar CORS para solicitudes desde cualquier origen (ajusta si es necesario)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Si es una solicitud OPTIONS (preflight), respondemos y salimos
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Retrieve the raw POST data
$jsonData = file_get_contents('php://input');
// Decode the JSON data into a PHP
$data = json_decode($jsonData, true);

// Logic for AUTH
if ($data !== null) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 1");
    $stmt->execute([$data["email"]]);
    $user = $stmt->fetch();
    if ($user && password_verify($data["password"], $user["password"])){
        //jwt
        $mail = $data["email"];
        echo json_encode(["token" => generateJWT($mail)]);
    } else {
        echo json_encode(["message" => "No es posible acceder (credenciales incorrectas o cuenta inactiva)"]);
    }

} else {
   // JSON decoding failed
   http_response_code(400); // Bad Request
   echo "Datos invalidos";
}
