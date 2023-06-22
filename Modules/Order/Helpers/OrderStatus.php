<?php

namespace Modules\Order\Helpers;

enum OrderStatus: int {
    case STATUS_INICIAL = 1;
    case STATUS_AGUARDANDO_PAGAMENTO = 2;
    case STATUS_PAGAMENTO_REALIZADO = 3;
    case STATUS_EM_SEPARACAO = 4;
    case STATUS_EM_TRANSPORTE = 5;
    case STATUS_ENTREGUE = 6;
    case STATUS_NAO_AUTORIZADO = 98;
    case STATUS_CANCELADO = 99;

    public static function array() {
        return [
            static::STATUS_INICIAL->value => 'Inicial',
            static::STATUS_AGUARDANDO_PAGAMENTO->value => 'Aguardando Pagamento',
            static::STATUS_PAGAMENTO_REALIZADO->value => 'Pagamento Realizado',
            static::STATUS_EM_SEPARACAO->value => 'Em Separação',
            static::STATUS_EM_TRANSPORTE->value => 'Em Transporte',
            static::STATUS_ENTREGUE->value => 'Entregue',
            static::STATUS_NAO_AUTORIZADO->value => 'Pagamento Não Autorizado',
            static::STATUS_CANCELADO->value => 'Cancelado',
        ];
    }

    public function inicial() {
        return $this === self::STATUS_INICIAL;
    }

    public function aguardando() {
        return $this === self::STATUS_AGUARDANDO_PAGAMENTO;
    }

    public function pago() {
        return $this === self::STATUS_PAGAMENTO_REALIZADO;
    }

    public function separacao() {
        return $this === self::STATUS_EM_SEPARACAO;
    }

    public function transporte() {
        return $this === self::STATUS_EM_TRANSPORTE;
    }

    public function entregue() {
        return $this === self::STATUS_ENTREGUE;
    }

    public function nao_autorizado() {
        return $this === self::STATUS_NAO_AUTORIZADO;
    }

    public function cancelado() {
        return $this === self::STATUS_CANCELADO;
    }

    public function texto() {
        return match ($this) {
            self::STATUS_INICIAL => 'Inicial',
            self::STATUS_AGUARDANDO_PAGAMENTO => 'Aguardando Pagamento',
            self::STATUS_PAGAMENTO_REALIZADO => 'Pagamento Realizado',
            self::STATUS_EM_SEPARACAO => 'Em Separação',
            self::STATUS_EM_TRANSPORTE => 'Em Transporte',
            self::STATUS_ENTREGUE => 'Entregue',
            self::STATUS_NAO_AUTORIZADO => 'Pagamento Não Autorizado',
            self::STATUS_CANCELADO => 'Cancelado',
        };
    }
}
