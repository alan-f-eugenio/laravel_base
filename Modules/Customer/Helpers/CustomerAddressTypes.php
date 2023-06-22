<?php

namespace Modules\Customer\Helpers;

enum CustomerAddressTypes: int {
    case TYPE_PRINCIPAL = 1;
    case TYPE_ENTREGA = 2;

    public static function array() {
        return [
            static::TYPE_PRINCIPAL->value => 'Endereço de Cobrança',
            static::TYPE_ENTREGA->value => 'Endereço de Entrega',
        ];
    }

    public function principal() {
        return $this === self::TYPE_PRINCIPAL;
    }

    public function entrega() {
        return $this === self::TYPE_ENTREGA;
    }

    public function texto() {
        return match ($this) {
            self::TYPE_PRINCIPAL => 'Endereço de Cobrança',
            self::TYPE_ENTREGA => 'Endereço de Entrega'
        };
    }
}
