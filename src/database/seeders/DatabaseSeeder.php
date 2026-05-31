<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'company']);
        Role::create(['name' => 'customer']);
        $admin = User::create([
            'name' => 'مهدی',
            'family' => 'کاظمی',
            'email' => 'mrmdcode@gmail.com',
            'password' => Hash::make('123456'),
            'national_id' => '12345678',
        ]);
        $admin->assignRole('admin');
        $comp1 = Company::create([
            'name' => "دن کلاب",
            'username' => "dob_sabz",
            'address' => "sabzevar ",
            'state' => "Khorasan razavi",
            'city' => "sabzevar",
            'phone' => "09389512885",
            'name_boss' => "mahdi",
            'phone_boss' => "09389512885",
            'phone_representative' => "09389512885",
            'capacity' => 55,
            'sm_tel' => "",
            'sm_instagram' => "",
            'sm_telegram' => "",
            'sm_whatsapp' => "",
            'sm_twitter' => "",
            'sm_threads' => "",
            'sm_website' => "",
            'zip' => 1234567890,
            'lat' => '57.69940853348751',
            'long' => '36.220397277579195',
            'plan_menu' => true,
            'plan_order_taker' => false,
            'plan_time_report' => false,
            'plan_online_order' => false,
            'plan_printer_control' => false,
            'plan_preparation_notification' => false,
            'active' => true,
            'fee_received' => 550000,
            'image' => "/logo",
        ]);
        User::create([
            'name' => 'mahdi sab',
            'email' => "mahdi@gmail.com",
            'family' =>'kazem',
            'age' => 52,
            'state' => "Khorasan razavi",
            'address' => "sabzevar ",
            'city' => "sabzevar",
            'company_id' => $comp1->id,
            'phone_number' => "09389512885",
            'national_id' => '1234567882',
            'telegram_phone' => '',
            'telegram_id' => '',
            'static_ip' => '',
            'work_status' => "permanent_employment",
            'position' => "manager",
            'password' => Hash::make('123456'),
        ]);
    }
}
