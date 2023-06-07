<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomerAddressTypes;
use App\Helpers\CustomerPersons;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerAddressAdminRequest;
use App\Http\Requests\Admin\CustomerAdminRequest;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerController extends Controller {
    // public function __construct() {
    //     $this->middleware('stripEmptyParams')->only('index');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
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

        return view('admin.customers.index', ['collection' => $query->paginate(10), 'months' => $months]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
        $item = new Customer;

        return view('admin.customers.create_edit', [
            'item' => $item,
            'personFisica' => (old('person') ?: $item->person?->value) == CustomerPersons::PESSOA_FISICA->value || !$item->id,
            'address' => new CustomerAddress,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerAdminRequest $request, CustomerAddressAdminRequest $addressRequest) {
        //
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer) {
        //
        return view('admin.customers.create_edit', [
            'item' => $customer,
            'personFisica' => (old('person') ?: $customer->person?->value) == CustomerPersons::PESSOA_FISICA->value || !$customer->id,
            'address' => $customer->mainAddress,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerAdminRequest $request, CustomerAddressAdminRequest $addressRequest, Customer $customer) {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer) {
        //
        $customer->update(['update_customer_id' => auth('admin')->id()]);
        $customer->delete();
        $customer->addresses()->delete();

        return redirect()->route('admin.customers.index')->with('message', ['type' => 'success', 'text' => 'Cliente removido com sucesso.']);
    }
}
