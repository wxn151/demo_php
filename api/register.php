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

if ($data !== null) {
   // Auth (fetch user and pass)
   $email = $data["email"];
   $hashedPassword = password_hash($data["password"], PASSWORD_BCRYPT);
   $photo = $data["photo"] ?? null;
   $username = $data["username"];

   // Load values for... 
   $stmt = $pdo->prepare("INSERT INTO users (username, email, password, photo) VALUES (?, ?, ?, ?)");
   
   try {
        $stmt->execute([$username, $email, $hashedPassword, $photo]);
        http_response_code(201);
        echo json_encode(["message" => "Cuenta creada."]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "message" => "Error al registrar: ", "error" => $e->getMessage() 
        ]);
    }

} else {
   // JSON decoding failed
   http_response_code(400); // Bad Request
   echo "Datos invalidos";
}