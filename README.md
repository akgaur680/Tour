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
If there is error of Client Token

php artisan tinker 
use Laravel\Passport\Client; Client::where(personal_access_client', true)->first();
Client::where('personal_access_client', true)->first();

php artisan passport:client --personal
npm install
npm run build

