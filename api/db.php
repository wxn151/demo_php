<?php
$dsn = 'mysql:host=localhost;dbname=your_db'; // DSN de la base de datos
$usuario = 'your_user';
$contrasena = 'your_pass';

try {
    // Establecer la conexión
    $pdo = new PDO($dsn, $usuario, $contrasena);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilitar el manejo de excepciones

} catch (PDOException $e) {
    // Manejar errores
    echo "Error: " . $e->getMessage();
}
?>
