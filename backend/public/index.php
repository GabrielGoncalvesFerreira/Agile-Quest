<?php


require '../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Controllers\ControllerAuth;
use App\Controllers\ControllerQuestionario;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$controladorAuth = new ControllerAuth();
$controladorQuestionario = new ControllerQuestionario();

$controlador = new ControllerAuth();
$caminho = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($caminho) {
    case '/login':
        $controladorAuth->login();
        break;
    case '/autenticar':
        $controladorAuth->autenticar();
        break;
    case '/categorias':
        $controladorQuestionario->listarCategorias();
        break;
    default:
        http_response_code(404);
        echo json_encode(['mensagem' => 'Rota não encontrada!']);
        break;
}