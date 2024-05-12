<?php

namespace App\Models;

use Core\ModelBase;

class ModelQuestionario extends ModelBase {

    public function buscarCategorias()
    {
        $script = 'SELECT * FROM categorias WHERE status = "A"' ;

        $stmt = $this->db->prepare($script);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}