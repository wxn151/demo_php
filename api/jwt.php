<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../vendor/autoload.php';

$secret = "alan_turing";

function generateJWT($email) {
    global $secret;
    $payload = [
        "email" => $email,
        "exp" => time() + 3600
    ];
    return JWT::encode($payload, $secret, 'HS256');
}

function verifyJWT($jwt) {
    global $secret;
    return JWT::decode($jwt, new Key($secret, 'HS256'));
}