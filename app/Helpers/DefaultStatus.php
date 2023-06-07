<?php

namespace App\Helpers;

enum DefaultStatus: int {
    case STATUS_ATIVO = 1;
    case STATUS_INATIVO = 2;

    public static function array() {
        return [
            static::STATUS_ATIVO->value => 'Ativo',
            static::STATUS_INATIVO->value => 'Inativo',
        ];
    }

    public function ativo() {
        return $this === self::STATUS_ATIVO;
    }

    public function inativo() {
        return $this === self::STATUS_INATIVO;
    }

    public function texto() {
        return match ($this) {
            self::STATUS_ATIVO => 'Ativo',
            self::STATUS_INATIVO => 'Inativo'
        };
    }
}
