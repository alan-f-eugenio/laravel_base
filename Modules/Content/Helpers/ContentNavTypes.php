<?php

namespace Modules\Content\Helpers;

enum ContentNavTypes: int {
    case TYPE_SINGLE = 1;
    case TYPE_MULTIPLE = 2;

    public static function array() {
        return [
            static::TYPE_SINGLE->value => 'Simples',
            static::TYPE_MULTIPLE->value => 'Múltiplo',
        ];
    }

    public function single() {
        return $this === self::TYPE_SINGLE;
    }

    public function multiple() {
        return $this === self::TYPE_MULTIPLE;
    }

    public function texto() {
        return match ($this) {
            self::TYPE_SINGLE => 'Simples',
            self::TYPE_MULTIPLE => 'Múltiplo'
        };
    }
}
