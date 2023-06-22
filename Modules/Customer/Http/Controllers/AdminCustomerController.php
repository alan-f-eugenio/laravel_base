<?php

namespace Modules\Customer\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Entities\CustomerAddress;
use Modules\Customer\Helpers\CustomerAddressTypes;
use Modules\Customer\Helpers\CustomerPersons;
use Modules\Customer\Http\Requests\AdminCustomerAddressRequest;
use Modules\Customer\Http\Requests\AdminCustomerRequest;

class AdminCustomerController extends Controller {
    public function index(Request $request) {
        $query = Customer::orderBy('id', 'desc');

        $request->whenFilled('status', function ($value) use ($query) {
            $query->where('status', $value);
        });
        $request->whenFilled('fullname', function ($value) use ($query) {
            $query->where('fullname', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('email', function ($value) use ($query) {
            $query->where('email', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('person', function ($value) use ($query) {
            $query->where('person', $value);
        });
        $request->whenFilled('cpf', function ($value) use ($query) {
            $query->where('cpf', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('month_birth', function ($value) use ($query) {
            $query->whereMonth('date_birth', '=', $value);
        });
        $request->whenFilled('cnpj', function ($value) use ($query) {
            $query->where('cnpj', 'LIKE', "%{$value}%");
        });
        $request->whenFilled('corporate_name', function ($value) use ($query) {
            $query->where('corporate_name', 'LIKE', "%{$value}%");
        });

        $months = [];
        for ($i = 0; $i <= 11; $i++) {
            $month = Carbon::create()
                ->startOfMonth()
                ->addMonth($i);
            $months[$i + 1] = ucfirst($month->monthName);
        }

        $customerPersons = CustomerPersons::array();

        return view('customer::admin.customer.index', ['collection' => $query->paginate(10), 'months' => $months, 'customerPersons' => $customerPersons]);
    }

    public function create() {
        $item = new Customer;
        $customerPersons = CustomerPersons::array();

        return view('customer::admin.customer.create_edit', [
            'item' => $item,
            'personFisica' => (old('person') ?: $item->person?->value) == CustomerPersons::PESSOA_FISICA->value || !$item->id,
            'address' => new CustomerAddress,
            'customerPersons' => $customerPersons,
        ]);
    }

    public function store(AdminCustomerRequest $request, AdminCustomerAddressRequest $addressRequest) {
        $attributes = $request->validated();
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['remember_token'] = Str::random(10);
        $attributes['create_user_id'] = auth('admin')->id();

        $mainAddAttributes = $addressRequest->validated();
        $mainAddAttributes['recipient'] = $attributes['fullname'];

        DB::transaction(function () use ($attributes, $mainAddAttributes) {
            Customer::create($attributes)->addresses()->create($mainAddAttributes);
        });

        return redirect()->route('admin.customers.index')->with('message', ['type' => 'success', 'text' => 'Cliente cadastrado com sucesso.']);
    }

    public function edit(Customer $customer) {
        $customerPersons = CustomerPersons::array();

        return view('customer::admin.customer.create_edit', [
            'item' => $customer,
            'personFisica' => (old('person') ?: $customer->person?->value) == CustomerPersons::PESSOA_FISICA->value || !$customer->id,
            'address' => $customer->mainAddress,
            'customerPersons' => $customerPersons,
        ]);
    }

    public function update(AdminCustomerRequest $request, AdminCustomerAddressRequest $addressRequest, Customer $customer) {
        $attributes = $request->validated();
        $attributes['update_user_id'] = auth('admin')->id();

        $mainAddAttributes = $addressRequest->validated();

        DB::transaction(function () use ($customer, $attributes, $mainAddAttributes) {
            $customer->update($attributes);
            $customer->addresses->firstWhere('type', CustomerAddressTypes::TYPE_PRINCIPAL->value)->update($mainAddAttributes);
        });

        if ($request->has('recoverPass')) {
            // dd('ENVIAR EMAIL RECUPERAÇÃO');
            return redirect()->route('admin.customers.edit', $customer)->with('message', ['type' => 'success', 'text' => 'Cliente alterado com sucesso. ENVIAR EMAIL RECUPERAÇÃO']);
        }

        return redirect()->route('admin.customers.edit', $customer)->with('message', ['type' => 'success', 'text' => 'Cliente alterado com sucesso.']);
    }

    public function destroy(Customer $customer) {
        //
        $customer->update(['update_customer_id' => auth('admin')->id()]);
        $customer->delete();
        $customer->addresses()->delete();

        return redirect()->route('admin.customers.index')->with('message', ['type' => 'success', 'text' => 'Cliente removido com sucesso.']);
    }
}
