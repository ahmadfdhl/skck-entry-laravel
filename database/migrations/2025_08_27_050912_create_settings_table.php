<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, number, boolean, json
            $table->string('group')->default('general');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'skck_expiry_months',
                'value' => '6',
                'type' => 'number',
                'group' => 'skck',
                'description' => 'Masa berlaku SKCK dalam bulan'
            ],
            [
                'key' => 'start_number_skck',
                'value' => '1',
                'type' => 'number',
                'group' => 'skck',
                'description' => 'Nomor Urut Awal SKCK'
            ],
            [
                'key' => 'skck_issue_fee',
                'value' => '30000',
                'type' => 'number',
                'group' => 'skck',
                'description' => 'Harga penerbitan SKCK'
            ],
            [
                'key' => 'skck_legalize_fee',
                'value' => '5000',
                'type' => 'number',
                'group' => 'skck',
                'description' => 'Harga legalisir SKCK'
            ],
            [
                'key' => 'daily_limit',
                'value' => '100',
                'type' => 'number',
                'group' => 'skck',
                'description' => 'Kuota Harian SKCK'
            ],
            [
                'key' => 'company_name',
                'value' => 'POLSEK GUNUNG PUTRI',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Nama instansi'
            ],
            [
                'key' => 'company_address',
                'value' => 'Jl. Mercedes Benz, RT.01/RW.10, Cicadas, Kec. Gn. Putri, Kabupaten Bogor, Jawa Barat 16830',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Alamat instansi'
            ],
            [
                'key' => 'company_phone',
                'value' => '(021) 8671405',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Telepon instansi'
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
