<?php

namespace App\Controllers;

use Core\ControllerBase;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\ModelUsuario;

class ControllerAuth extends ControllerBase {
    private $chaveSecreta;
    private $algoritmo = 'HS256';

    public function __construct() {
        $this->chaveSecreta = $_ENV['SECRET_KEY'];
    }

    /**
     * Método para login e geração do token JWT.
     * Retorna um JSON com sucesso ou erro.
     */
    public function login() {
        // Permitir requisições apenas de URLs específicas
        $origensPermitidas = explode(',', $_ENV['ALLOWED_ORIGINS']);
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            $this->tratarRequisicaoOptions($origensPermitidas);
        }
        $this->permitirOrigem($origensPermitidas);

        // Receber os dados enviados
        $input = json_decode(file_get_contents('php://input'), true);
        $email = $input['email'] ?? '';
        $senha = $input['senha'] ?? '';

        // Buscar o usuário no banco de dados
        $modeloUsuario = $this->modelo('ModelUsuario');
        $usuario = $modeloUsuario->buscarPorEmail($email);

        // Verificar se o usuário existe e se a senha é válida
        if ($usuario && $modeloUsuario->verificarSenha($senha, $usuario['senha'])) {
            // Criar o token JWT
            $payload = [
                'iss' => 'http://localhost',
                'aud' => 'http://localhost',
                'iat' => time(),
                'exp' => time() + 3600,
                'email' => $usuario['email']
            ];

            // Gerar o token usando a chave secreta
            $token = JWT::encode($payload, $this->chaveSecreta, $this->algoritmo);

            // Retornar o token no formato JSON
            $this->json([
                'sucesso' => true,
                'mensagem' => 'Login bem-sucedido!',
                'token' => $token
            ]);
        } else {
            // Retornar erro caso as credenciais sejam inválidas
            $this->json([
                'sucesso' => false,
                'mensagem' => 'Credenciais inválidas!'
            ], 401);
        }
    }

    /**
     * Método para verificar a autenticidade do token JWT.
     * Retorna um JSON com sucesso ou erro.
     */
    public function autenticar() {
        // Permitir requisições apenas de URLs específicas
        $origensPermitidas = explode(',', $_ENV['ALLOWED_ORIGINS']);
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            $this->tratarRequisicaoOptions($origensPermitidas);
        }
        $this->permitirOrigem($origensPermitidas);

        // Obter o cabeçalho de autorização
        $headers = getallheaders();
        $cabecalhoAutorizacao = $headers['Authorization'] ?? '';

        if (strpos($cabecalhoAutorizacao, 'Bearer ') !== false) {
            $token = str_replace('Bearer ', '', $cabecalhoAutorizacao);
            try {
                // Decodificar o token usando a classe `Key`
                $decodificado = JWT::decode($token, new Key($this->chaveSecreta, $this->algoritmo));
                $this->json([
                    'sucesso' => true,
                    'mensagem' => 'Acesso permitido',
                    'usuario' => $decodificado
                ]);
            } catch (\Exception $e) {
                // Retornar erro caso o token seja inválido
                $this->json([
                    'sucesso' => false,
                    'mensagem' => 'Token inválido!'
                ], 401);
            }
        } else {
            // Retornar erro caso o token esteja ausente
            $this->json([
                'sucesso' => false,
                'mensagem' => 'Token ausente!'
            ], 401);
        }
    }

     /**
     * Método para validar o token JWT.
     * Retorna um array com 'sucesso' e 'usuario' ou 'mensagem'.
     */
    public function validarToken() {
        $origensPermitidas = explode(',', $_ENV['ALLOWED_ORIGINS']);
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            $this->tratarRequisicaoOptions($origensPermitidas);
        }
        $this->permitirOrigem($origensPermitidas);

        $headers = getallheaders();
        $cabecalhoAutorizacao = $headers['Authorization'] ?? '';

        if (strpos($cabecalhoAutorizacao, 'Bearer ') !== false) {
            $token = str_replace('Bearer ', '', $cabecalhoAutorizacao);
            try {
                $decodificado = JWT::decode($token, new Key($this->chaveSecreta, $this->algoritmo));
                return ['sucesso' => true, 'usuario' => $decodificado];
            } catch (\Exception $e) {
                return ['sucesso' => false, 'mensagem' => 'Token inválido!'];
            }
        } else {
            return ['sucesso' => false, 'mensagem' => 'Token ausente!'];
        }
    }
}
