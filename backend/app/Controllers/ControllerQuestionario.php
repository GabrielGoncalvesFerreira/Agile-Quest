<?php

namespace app\Controllers;

use App\Controllers\ControllerAuth;
use Core\ControllerBase;
use App\Models\ModelQuestionario;

class ControllerQuestionario extends ControllerBase {

    private $controladorAuth;

    public function __construct()
    {
        $this->controladorAuth = new ControllerAuth();
    }

     /**
     * Método para listar as categorias.
     * Retorna um JSON com sucesso ou erro.
     */
    public function listarCategorias() {
        $validacao = $this->controladorAuth->validarToken();
        if ($validacao['sucesso']) {
            $modeloCategoria = $this->modelo('ModelQuestionario');
            $categorias = $modeloCategoria->buscarCategorias();
            $this->json([
                'sucesso' => true,
                'categorias' => $categorias
            ]);
        } else {
            $this->json([
                'sucesso' => false,
                'mensagem' => $validacao['mensagem']
            ], 401);
        }
    }

}