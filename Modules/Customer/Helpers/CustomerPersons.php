<?php

namespace Modules\Customer\Helpers;

enum CustomerPersons: int {
    case PESSOA_FISICA = 1;
    case PESSOA_JURIDICA = 2;

    public static function array() {
        return [
            static::PESSOA_FISICA->value => 'Pessoa Física',
            static::PESSOA_JURIDICA->value => 'Pessoa Jurídica',
        ];
    }

    public function fisica() {
        return $this === self::PESSOA_FISICA;
    }

    public function juridica() {
        return $this === self::PESSOA_JURIDICA;
    }

    public function texto() {
        return match ($this) {
            self::PESSOA_FISICA => 'Pessoa Física',
            self::PESSOA_JURIDICA => 'Pessoa Jurídica'
        };
    }
}
