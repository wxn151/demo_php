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

$headers = getallheaders();
$jwt = $headers["Authorization"];
if (!isset($jwt)) {
    http_response_code(401);
    echo json_encode(["message" => "Token no proporcionado."]);
    exit;
}

$token = str_replace("Bearer ", "", $jwt);
$data = verifyJWT($token); # cache token
if (!$data || !isset($data->email)) {
    http_response_code(401);
    echo json_encode(["message" => "Token invalido."]);
    exit;
}

$stmt = $pdo->prepare("SELECT username, email, photo, status FROM users WHERE email = ?");
$stmt->execute([$data->email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode($user);
} else {
    http_response_code(500);
    echo json_encode([
        "message" => "Dato no encontrado."
    ]);
}
?>
