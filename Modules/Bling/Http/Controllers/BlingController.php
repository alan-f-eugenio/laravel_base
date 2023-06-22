<?php

namespace Modules\Bling\Http\Controllers;

use App\Helpers\DefaultStatus;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Helpers\ProductHasChildTypes;
use Modules\Product\Helpers\ProductTypes;

class BlingController extends Controller {
    public static function getAllProducts() {
        if (config('integrations.erp.bling')['status'] != DefaultStatus::STATUS_ATIVO) {
            return false;
        }

        if ($products = self::getPages()) {
            $products = json_decode(json_encode($products), true);

            usort($products, function ($a, $b) {
                return count($a['produto']) > count($b['produto']);
            });

            foreach ($products as $prod) {
                if ($prod['produto']['descricao'] == 'test') {
                    dump($prod['produto']);
                }
            }
            // dump($products);
            // foreach ($products as $prodBling) {
            //     $product = $prodBling->product;
            //     self::getProduct($product);
            // }
        } else {
            dump('no product');
        }

        dd(Carbon::now());
    }

    protected static function getPages() {
        $page = 1;
        $products = [];
        dump(Carbon::now());
        for ($x = 1; $x <= $page; $x++) {
            $url = 'https://bling.com.br/Api/v2/produtos/page=' . $page . '/json/';
            $client = new Client;
            try {
                $guzzle_request = new Request('GET', $url . '&apikey=' .
                    config('integrations.erp.bling')['defines']['token'] .
                    '&estoque=S&imagem=S&filters=tipo[P];situacao[A]');
                $res = $client->sendAsync($guzzle_request)->wait();
            } catch (Exception $e) {
                // dd($e);
                return false;
            }

            $response = json_decode($res->getBody());

            if (isset($response->retorno->produtos)) {
                $products = array_merge($products, $response->retorno->produtos);
                $page++;
            } else {
                return $products;
            }
        }
    }

    protected static function consultProductBySku($sku) {
        $url = 'https://bling.com.br/Api/v2/produto/' . $sku . '/json/';
        $client = new Client;
        try {
            $guzzle_request = new Request('GET', $url . '&apikey=' .
                config('integrations.erp.bling')['defines']['token'] .
                '&estoque=S&imagem=S&filters=tipo[P];situacao[A]');
            $res = $client->sendAsync($guzzle_request)->wait();
        } catch (Exception $e) {
            // dd($e);
            return false;
        }

        $response = json_decode($res->getBody());

        if (isset($response->retorno->produtos)) {
            return $response->retorno->produtos[0];
        } else {
            return false;
        }
    }

    protected static function getProduct($prodBling) {
        $parent = null;
        $prodBling = json_decode(json_encode($prodBling));

        if (isset($prodBling->codigoPai)) {
            if (!str_contains($prodBling->descricao, ':')) {
                return false;
            }
            if (!$parent = Product::firstWhere('sku', $prodBling->codigoPai)) {
                return false;
            }
        }

        $prodPeso = $prodBling->pesoBruto ?: $prodBling->pesoLiq;

        $product = Product::firstOrNew(
            ['sku' => $prodBling->codigo],
            [
                'id_parent' => isset($prodBling->codigoPai) ? $parent->id : null,
                'has_child' => isset($prodBling->variacoes)
                    ? (substr_count($prodBling->variacoes[0]['variacao']['nome'], ':') == 1
                        ? ProductHasChildTypes::TYPE_SINGLE->value : ProductHasChildTypes::TYPE_DUO->value)
                    : ProductHasChildTypes::TYPE_NONE->value,
                'status' => DefaultStatus::STATUS_ATIVO->value,
                'type' => ProductTypes::TYPE_SALE->value,
                'sku' => $prodBling->sku,
                'name' => $prodBling->descricao,
                'slug' => str($prodBling->descricao)->slug(),
                'ean' => $prodBling->gtin,
                'stock' => !isset($prodBling->variacoes) ? $prodBling->estoqueAtual : null,
                'weight' => $prodPeso > 0 ? $prodPeso : 0.001,
                'width' => $prodBling->larguraProduto > 0
                    ? ($prodBling->unidadeMedida != 'Metros'
                        ? $prodBling->larguraProduto / 100 : $prodBling->larguraProduto)
                    : 0.01,
                'height' => $prodBling->alturaProduto > 0
                    ? ($prodBling->unidadeMedida != 'Metros'
                        ? $prodBling->alturaProduto / 100 : $prodBling->alturaProduto)
                    : 0.01,
                'depth' => $prodBling->profundidadeProduto > 0
                    ? ($prodBling->unidadeMedida != 'Metros'
                        ? $prodBling->profundidadeProduto / 100 : $prodBling->profundidadeProduto)
                    : 0.01,
                'price' => round($prodBling->preco, 2) ?: 0.01,
                'price_cost' => round($prodBling->precoCusto, 2) ?: 0.01,
                'brand' => $prodBling->marca,
                'text' => $prodBling->descricaoCurta,
            ]
        );

        // $attributes = [
        //     'sku' => $prodBling->codigo,

        // ]
    }
}
