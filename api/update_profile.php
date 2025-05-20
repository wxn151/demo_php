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
$data = verifyJWT($token);
# hash value
$email = $data->email;
if (!$data || !isset($email)) {
    http_response_code(401);
    echo json_encode(["message" => "Token invalido."]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
if (!$input) {
  http_response_code(400);
  echo json_encode(["message" => "Datos inválidos"]);
  exit;
}

$username = trim($input["username"]);
$status = ($input["status"] === "active") ? 1 : 0;

$photo = $input["photo"] ?? null; 

try {
    $sql = "UPDATE users SET username = :username, status = :status";
    $params = [
        ":username" => $username,
        ":status" => $status
    ];

    if ($photo) {
        $sql .= ", photo = :photo";
        $params[":photo"] = $photo;
    }

    $sql .= " WHERE email = :email";
    $params[":email"] = $email;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    echo json_encode(["message" => "Datos actualizados correctamente"]);
} catch  (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "message" => "No se pudo editar el perfil.", "error" => $e->getMessage() 
    ]);
}