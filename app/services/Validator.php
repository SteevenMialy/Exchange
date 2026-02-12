<?php

namespace app\services;

use app\models\User;

class Validator
{

    public static function normalizeTelephone($tel)
    {
        return preg_replace('/\s+/', '', trim((string)$tel));
    }

    public static function validateRegister(array $input, User $repo = null)
    {
        $errors = [
            'username' => '',
            'password' => '',
        ];

        $values = [
            'username' => trim((string)($input['username'] ?? '')),
        ];

        if (mb_strlen($values['username']) < 2) $errors['username'] = "Le nom d'utilisateur doit contenir au moins 2 caractères.";

        $ok = true;
        foreach ($errors as $m) {
            if ($m !== '') {
                $ok = false;
                break;
            }
        }

        return ['ok' => $ok, 'errors' => $errors, 'values' => $values];
    }
}
