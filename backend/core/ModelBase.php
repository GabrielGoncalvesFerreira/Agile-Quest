<?php

namespace Core;

use PDO;

abstract class ModelBase {
    protected $db;

    public function __construct() {
        $this->db = $this->conectar();
    }

    /**
     * Conecta ao banco de dados usando PDO.
     * @return PDO - Conexão ao banco de dados.
     */
    private function conectar() {
        $config = require '../config/database.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
        return new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
}
