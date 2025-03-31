# Passport



Install Twilio Package

composer require twilio/sdk
Install passport API

php artisan install:api --passport
Create a Porvider AuthServiceProvider

Add the following commands in new Provider public function boot() { $this->registerPolicies();

  // Ensure Passport routes are loaded
  // Passport::routes();

  // Load Passport keys (optional, if needed)
  Passport::loadKeysFrom(storage_path());
}

Link Storage so that it access the secret_key & private_key

php artisan storage:link

php artisan db:seed --class=AdminSeeder

If there is error of Client Token

php artisan tinker 

use Laravel\Passport\Client;

Client::create([
    'name' => 'Personal Access Client',
    'secret' => \Illuminate\Support\Str::random(40),
    'redirect' => '',
    'personal_access_client' => true,
    'password_client' => false,
    'revoked' => false,
]);


use Laravel\Passport\Client; Client::where('personal_access_client', true)->first();


php artisan passport:client --personal
npm install
npm run build

