<?php

namespace Core;

abstract class ControllerBase {
    /**
     * Carrega um modelo específico.
     * @param string $modelo - Nome do modelo.
     * @return object - Instância do modelo.
     */
    protected function modelo($modelo) {
        require_once "../app/Models/{$modelo}.php";
        $nomeCompleto = "App\\Models\\{$modelo}";
        return new $nomeCompleto();
    }

    /**
     * Retorna um JSON para o cliente.
     * @param array $dados - Dados a serem enviados.
     * @param int $status - Código de status HTTP.
     */
    protected function json($dados, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($dados);
        exit();
    }

   /**
     * Permite requisições apenas de origens específicas.
     * @param array $origensPermitidas - Lista de origens permitidas.
     */
    protected function permitirOrigem($origensPermitidas) {
        $origem = $_SERVER['HTTP_ORIGIN'] ?? '';
        if (in_array($origem, $origensPermitidas)) {
            header("Access-Control-Allow-Origin: $origem");
            header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
        } else {
            http_response_code(403);
            $this->json(['sucesso' => false, 'mensagem' => 'Acesso negado!'], 403);
        }
    }

     /**
     * Lida com requisições OPTIONS para CORS.
     * @param array $origensPermitidas - Lista de origens permitidas.
     */
    protected function tratarRequisicaoOptions($origensPermitidas) {
        $origem = $_SERVER['HTTP_ORIGIN'] ?? '';
        if (in_array($origem, $origensPermitidas)) {
            header("Access-Control-Allow-Origin: $origem");
            header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            http_response_code(200);
            exit();
        } else {
            http_response_code(403);
            $this->json(['sucesso' => false, 'mensagem' => 'Acesso negado!'], 403);
        }
    }
}
