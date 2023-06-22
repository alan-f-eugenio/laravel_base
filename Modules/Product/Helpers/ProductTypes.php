<?php

namespace Modules\Product\Helpers;

enum ProductTypes: int {
    case TYPE_SALE = 1;
    case TYPE_QUOTE = 2;

    public static function array() {
        return [
            static::TYPE_SALE->value => 'Venda',
            static::TYPE_QUOTE->value => 'Orçamento',
        ];
    }

    public function venda() {
        return $this === self::TYPE_SALE;
    }

    public function orcamento() {
        return $this === self::TYPE_QUOTE;
    }

    public function texto() {
        return match ($this) {
            self::TYPE_SALE => 'Venda',
            self::TYPE_QUOTE => 'Orçamento'
        };
    }
}
