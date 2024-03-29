<?php

namespace Modules\Payment\Http\Controllers;

use App\Helpers\DefaultStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Vite;
use Modules\Cart\Http\Controllers\CartController;
use Modules\Coupon\Entities\Coupon;
use Modules\Order\Entities\Order;
use Modules\Order\Helpers\OrderStatus;
use Modules\Pagseguro\Helpers\PagSeguroStatus;
use Modules\Pagseguro\Http\Controllers\PagseguroController;
use Modules\Shipping\Http\Controllers\ShippingController;
use Nwidart\Modules\Facades\Module;

class PaymentController extends Controller {
    public function index() {

        $customer = auth()->user();
        $mainAddress = $customer->mainAddress;
        $secondaryAddress = $customer->secondaryAddress ?: null;

        $cart = CartController::storeOrUpdate();

        $paymentMethodList = [];
        foreach (config('integrations.pagamento') as $keyPM => $paymentMethod) {
            if ($paymentMethod['status'] == DefaultStatus::STATUS_ATIVO) {
                $paymentMethodList[$keyPM]
                    = Vite::asset("resources/img/payment/{$keyPM}/logo.svg");
            }
        }

        return view('public.payment.index', [
            'customer' => $customer,
            'mainAddress' => $mainAddress,
            'secondaryAddress' => $secondaryAddress,
            'cartProducts' => $cart->cartProducts,
            'paymentMethodList' => $paymentMethodList,
        ]);
    }

    public function store(Request $request) {

        $customer = auth()->user();
        $cart = CartController::storeOrUpdate();
        $coupon = $cart->coupon;
        $shippingData = explode('__', $request->shipping);
        $address = $customer->addresses->where('id', $request->address)->first();
        $cep = preg_replace('/[^0-9]/', '', $address->cep);

        $totalProducts = 0;
        $listShippProducts = [];
        foreach ($cart->cartProducts as $cartProduct) {
            $product = $cartProduct->product;
            $listShippProducts[] = ['product' => $product, 'qtd' => $cartProduct->qtd];
            $totalProducts += $product->getRawOriginal('price');
        }

        $paymentMethod = null;
        foreach (config('integrations.pagamento') as $keyPM => $dataPM) {
            if ($dataPM['status'] == DefaultStatus::STATUS_ATIVO && $keyPM == $request->payment) {
                $paymentMethod = $keyPM;
            }
        }

        $shippingMethod = null;
        $shippingCalcData = null;
        foreach (config('integrations.frete') as $keySM => $dataSM) {
            if ($keySM == $shippingData[0] && $dataSM['status'] == DefaultStatus::STATUS_ATIVO) {
                $shippingMethod = $shippingData[0];
                $shippingCalcData = ShippingController::getShippingValue($cep, $listShippProducts, $totalProducts, $shippingMethod, $shippingData[1]);
                break;
            }
        }

        $discount = 0;
        if ($coupon = Coupon::firstWhere('token', $coupon)) {
            if ($coupon->discount_type->amount()) {
                $discount = $coupon->getRawOriginal('discount');
            } else {
                $discount = $totalProducts * ($coupon->getRawOriginal('discount') / 100);
            }
        }

        $total = $totalProducts - $discount + $shippingCalcData['value'];

        // dd($paymentMethod, $shippingMethod, $shippingCalcData['name'],  $totalProducts, $discount, $shippingCalcData['value'], $total);
        // if($paymentMethod && $shippingMethod && $shippingCalcData){
        $order = Order::create([
            'customer_id' => $customer->id,
            'cart_id' => $cart->id,
            'coupon_id' => $coupon && isset($coupon->id) ? $coupon->id : null,
            'status' => OrderStatus::STATUS_INICIAL,
            'recipient' => $address->recipient,
            'cep' => $address->cep,
            'street' => $address->street,
            'number' => $address->number,
            'complement' => $address->complement,
            'neighborhood' => $address->neighborhood,
            'city' => $address->city,
            'state' => $address->state,
            'shipping_service' => $shippingMethod,
            'shipping_code' => $shippingCalcData['name'],
            'shipping_value' => $shippingCalcData['value'],
            'payment_service' => $paymentMethod,
            'coupon' => $coupon && isset($coupon->id) ? $coupon->token : null,
            'discount' => $discount,
            'value' => $total,
            'installments' => 1,
            'customer_obs' => '',
        ]);
        // dd($order);

        if (Module::has('Pagseguro') && Module::isEnabled('Pagseguro') && $paymentMethod == 'pagseguro') {
            PagseguroController::pagseguroPay($order, $cart, $customer);
        }
    }

    public function update(Request $request, $information) {
        // Log::build([
        //     'driver' => 'single',
        //     'path' => storage_path('logs/pagseguro.log'),
        // ])->info(print_r([$request->all(), $request->path(), $request->method()], true));

        Log::debug(print_r($information->getStatus()->getCode(), 1));

        // if (Module::has('Pagseguro') && Module::isEnabled('Pagseguro') && $request->has('notificationType') && $request->has('notificationCode') && $request->notificationType == 'transaction') {
        //     \PagSeguro\Library::initialize();
        //     \PagSeguro\Library::cmsVersion()->setName('Nome')->setRelease('1.0.0');
        //     \PagSeguro\Library::moduleVersion()->setName('Nome')->setRelease('1.0.0');
        //     \PagSeguro\Configuration\Configure::setEnvironment('sandbox');
        //     \PagSeguro\Configuration\Configure::setLog(true, storage_path('logs/pagseguro.log'));

        //     $credentials = new \PagSeguro\Domains\AccountCredentials(
        //         config('integrations.pagamento.pagseguro.defines.email'),
        //         config('integrations.pagamento.pagseguro.defines.token')
        //     );

        //     try {
        //         if (\PagSeguro\Helpers\Xhr::hasPost()) {
        //             $response = \PagSeguro\Services\Transactions\Notification::check(
        //                 $credentials
        //             );

        //             // Log::build([
        //             //     'driver' => 'single',
        //             //     'path' => storage_path('logs/pagseguro.log'),
        //             // ])->info(print_r($response, true));

        //             $order = Order::where('id', $response->getReference())->firstOrFail();

        //             if ($response->getStatus() == PagSeguroStatus::STATUS_WAITING_PAYMENT->value) {
        //                 $order->update([
        //                     'tid' => $response->getCode(),
        //                 ]);
        //             } elseif ($response->getStatus() == PagSeguroStatus::STATUS_PAID->value) {
        //                 $order->update([
        //                     'status' => OrderStatus::STATUS_PAGAMENTO_REALIZADO,
        //                 ]);
        //             } elseif (
        //                 $response->getStatus() == PagSeguroStatus::STATUS_REFUNDED->value ||
        //                 $response->getStatus() == PagSeguroStatus::STATUS_CANCELLED->value
        //             ) {
        //                 $order->update([
        //                     'status' => OrderStatus::STATUS_CANCELADO,
        //                 ]);
        //             }
        //         }
        //     } catch (Exception $e) {
        //         exit($e->getMessage());
        //     }
        // }
    }
}
