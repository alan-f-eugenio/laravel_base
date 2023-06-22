<?php

namespace Modules\Product\Helpers;

enum ProductHasChildTypes: int {
    case TYPE_NONE = 0;
    case TYPE_SINGLE = 1;
    case TYPE_DUO = 2;

    public static function array() {
        return [
            static::TYPE_NONE->value => 'Sem Variação',
            static::TYPE_SINGLE->value => 'Variação Simples',
            static::TYPE_DUO->value => 'Variação Dupla',
        ];
    }

    public function nenhuma() {
        return $this === self::TYPE_NONE;
    }

    public function simples() {
        return $this === self::TYPE_SINGLE;
    }

    public function dupla() {
        return $this === self::TYPE_DUO;
    }

    public function texto() {
        return match ($this) {
            self::TYPE_NONE => 'Sem Variação',
            self::TYPE_SINGLE => 'Variação Simples',
            self::TYPE_DUO => 'Variação Dupla'
        };
    }
}
