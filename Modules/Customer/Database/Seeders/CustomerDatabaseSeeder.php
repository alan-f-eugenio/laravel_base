<?php

namespace Modules\Customer\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Entities\CustomerAddress;

class CustomerDatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        foreach (Customer::factory(10)->create() as $customer) {
            CustomerAddress::factory()->create([
                'customer_id' => $customer->id,
            ]);
        }

        CustomerAddress::factory()->create([
            'customer_id' => Customer::factory()->create([
                'email' => 'alan@cgdw.com.br',
            ]),
        ]);
    }
}
