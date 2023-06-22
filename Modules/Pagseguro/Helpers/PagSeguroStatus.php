<?php

namespace Modules\Pagseguro\Helpers;

enum PagSeguroStatus: int {
    case STATUS_WAITING_PAYMENT = 1;
    case STATUS_PAID = 3;
    case STATUS_REFUNDED = 6;
    case STATUS_CANCELLED = 7;

    public static function array() {
        return [
            static::STATUS_WAITING_PAYMENT->value => 'Aguardando Pagamento',
            static::STATUS_PAID->value => 'Pagamento Realizado',
            static::STATUS_REFUNDED->value => 'Pagamento Estornado',
            static::STATUS_CANCELLED->value => 'Cancelado',
        ];
    }
}
