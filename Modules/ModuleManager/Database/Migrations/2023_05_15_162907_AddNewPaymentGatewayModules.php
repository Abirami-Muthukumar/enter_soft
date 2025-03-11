<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddNewPaymentGatewayModules extends Migration
{
    public function up()
    {
        $totalCount = DB::table('modules')->count();
        $modules = [
            ['name' => 'AuthorizeNet', 'details' => 'AuthorizeNet payment gateway for acslms'],
            ['name' => 'Braintree', 'details' => 'Braintree payment gateway for acslms'],
            ['name' => 'Flutterwave', 'details' => 'Flutterwave payment gateway for acslms'],
            ['name' => 'Mollie', 'details' => 'Mollie payment gateway for acslms'],
            ['name' => 'JazzCash', 'details' => 'JazzCash payment gateway for acslms'],
            ['name' => 'Coinbase', 'details' => 'Coinbase payment gateway for acslms'],
            ['name' => 'CCAvenue', 'details' => 'CCAvenue payment gateway for acslms'],
        ];
        foreach ($modules as $key => $module) {
            Module::updateOrCreate([
                'name' => $module['name'],
            ], [
                    'name' => $module['name'],
                    'details' => $module['details'],
                    'status' => 1,
                    'order' => $totalCount + $key
                ]
            );
        }
    }

    public function down()
    {
        //
    }
}
