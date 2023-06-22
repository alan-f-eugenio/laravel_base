<?php

namespace Modules\Contact\Helpers;

enum ContactStatus: int {
    case STATUS_NOVO = 0;
    case STATUS_VISTO = 1;

    public static function array() {
        return [
            static::STATUS_NOVO->value => 'Novo',
            static::STATUS_VISTO->value => 'Visto',
        ];
    }

    public function novo() {
        return $this === self::STATUS_NOVO;
    }

    public function visto() {
        return $this === self::STATUS_VISTO;
    }

    public function texto() {
        return match ($this) {
            self::STATUS_NOVO => 'Novo',
            self::STATUS_VISTO => 'Visto'
        };
    }
}
