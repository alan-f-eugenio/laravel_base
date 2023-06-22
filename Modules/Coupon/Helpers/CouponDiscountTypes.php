<?php

namespace Modules\Coupon\Helpers;

enum CouponDiscountTypes: int {
    case TYPE_PERCENT = 1;
    case TYPE_AMOUNT = 2;

    public static function array() {
        return [
            static::TYPE_PERCENT->value => 'Porcentagem',
            static::TYPE_AMOUNT->value => 'Valor',
        ];
    }

    public function percent() {
        return $this === self::TYPE_PERCENT;
    }

    public function amount() {
        return $this === self::TYPE_AMOUNT;
    }

    public function texto() {
        return match ($this) {
            self::TYPE_PERCENT => 'Porcentagem',
            self::TYPE_AMOUNT => 'Valor'
        };
    }
}
