<?php

namespace Modules\Correio\Http\Controllers;

use App\Helpers\DefaultStatus;
use Illuminate\Routing\Controller;

class CorreioController extends Controller {
    public static function calcShipping($cep, $listShippProducts, $inputs = false, $shippingCode = false) {

        if (config('integrations.frete.correios')['status'] != DefaultStatus::STATUS_ATIVO) {
            return false;
        }

        $arrayCdServicos = config('integrations.frete.correios')['defines']['cdServicos'];

        $data = [];
        $data['sCepOrigem'] = preg_replace('/[^0-9]/', '', config('defines')->company_cep);
        $data['sCepDestino'] = $cep;
        $data['StrRetorno'] = 'xml';

        $volume = 0;
        $prazoAdicional = 0;
        foreach ($listShippProducts as $shippProduct) {
            $product = $shippProduct['product'];

            $cubagem = ($product->height * $product->depth * $product->width) / 6000;
            $peso = $product->getRawOriginal('weight');

            $volume += ($cubagem > $peso ? $cubagem : $peso) * $shippProduct['qtd'];

            $prazoAdicional = ($product->deadline > $prazoAdicional) ? $product->deadline : $prazoAdicional;
        }

        $data['nVlPeso'] = $volume;

        $lowestValue = null;
        $shippingListHTML = '';
        $shippingName = '';

        if ($shippingCode) {
            foreach ($arrayCdServicos as $cdsCod => $cdsNome) {
                if ($cdsCod != $shippingCode) {
                    unset($arrayCdServicos[$cdsCod]);
                }
            }
        }

        foreach ($arrayCdServicos as $cdsCod => $cdsNome) {

            $data['nCdServico'] = $cdsCod;
            $url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?' . http_build_query($data, '', '&');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $xmlStr = curl_exec($ch);
            curl_close($ch);

            $xml = @simplexml_load_string($xmlStr);
            if (isset($xml->cServico->Erro) && $xml->cServico->Erro == 0) {
                $valor = str_replace(',', '.', str_replace('.', '', $xml->cServico->Valor));
                if ($valor > 0) {
                    $prazoTotal = $xml->cServico->PrazoEntrega + $prazoAdicional;
                    if (is_null($lowestValue) || $valor < $lowestValue) {
                        $lowestValue = $valor;
                        if ($shippingCode && $shippingCode == $cdsCod) {
                            $shippingName = $cdsNome;
                            break;
                        }
                    }
                    if (!$inputs) {
                        $shippingListHTML .= "<li>
                                <p><b>Correios - {$cdsNome}:</b> R$ {$xml->cServico->Valor}<br><small>{$prazoTotal} dia(s)</small></p>
                                </li>";
                    } else {
                        $shippingListHTML .= "<li>
                                <input type='radio' id='correios__{$cdsCod}' value='correios__{$cdsCod}' name='shipping' class='peer' required />
                                <label for='correios__{$cdsCod}' class='peer-checked:border-blue-600 peer-checked:text-blue-600' >
                                <b>Correios - {$cdsNome}:</b> R$ {$xml->cServico->Valor}<br><small>{$prazoTotal} dia(s)</small>
                                </label>
                                </li>";
                    }
                }
            }
        }

        if ($shippingCode) {
            return ['name' => $shippingName, 'value' => $lowestValue];
        } else {
            return !is_null($lowestValue)
                ? ['html' => $shippingListHTML, 'lowestValue' => $lowestValue]
                : false;
        }
    }
}
