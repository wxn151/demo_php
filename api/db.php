<?php
$dsn = 'mysql:host=localhost;dbname=dummy_php'; // DSN de la base de datos
$usuario = 'root';
$contrasena = 'Donut.238';

try {
    // Establecer la conexión
    $pdo = new PDO($dsn, $usuario, $contrasena);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilitar el manejo de excepciones

} catch (PDOException $e) {
    // Manejar errores
    echo "Error: " . $e->getMessage();
}
?>