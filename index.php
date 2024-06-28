<?php

// Configurações do banco de dados (usando PDO)
$host = 'postgres_db';
$dbname = 'seminario_web';
$user = 'postgres';
$password = '123456';

// Função para conectar ao banco de dados
function connectDB() {
    global $host, $dbname, $user, $password;
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro ao conectar: " . $e->getMessage());
    }
}

// Função para obter todos os produtos
function getAllProducts() {
    $pdo = connectDB();
    $stmt = $pdo->prepare("SELECT * FROM product");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para definir os cabeçalhos CORS
function setCorsHeaders() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
}


setCorsHeaders();
http_response_code(200);
//exit();


// Verifica se a requisição é um GET para a rota /api/v1/products
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    setCorsHeaders();
    header('Content-Type: application/json');

    // Obtém todos os produtos
    $products = getAllProducts();

    // Retorna os produtos como JSON
    echo json_encode($products);
    exit();
} else {
    // Rota não encontrada
    http_response_code(404);
    echo json_encode(array("message" => "Rota não encontrada"));
    exit();
}
