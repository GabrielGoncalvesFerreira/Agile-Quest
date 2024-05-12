<?php

namespace App\Models;

use Core\ModelBase;

class ModelUsuario extends ModelBase {
    /**
     * Busca um usuário por e-mail no banco de dados.
     * @param string $email - E-mail do usuário.
     * @return array|false - Dados do usuário ou falso caso não encontrado.
     */
    public function buscarPorEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Verifica se a senha fornecida é válida comparando com a senha armazenada.
     * @param string $senha - Senha fornecida.
     * @param string $senhaHash - Senha criptografada armazenada.
     * @return bool - Verdadeiro se a senha é válida, falso caso contrário.
     */
    public function verificarSenha($senha, $senhaHash) {
        return password_verify($senha, $senhaHash);
    }
}
