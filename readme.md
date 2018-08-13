### Laravel User Activation Boilerplate

#### For developers who want to learn how to activate users table without using package vendors.

##### Steps

- Add `$table->boolean('active')->default(false)` on `create_users_table` migration.

- Create Model ActivationToken with Migration

```bash
php artisan make:model ActivationToken -m
```
- Create columns on `create_activation_tokens_table` and reference `user_id` to `users` table.

- Add relations on `User.php` and `ActivationToken.php`. Make sure to have `static function` to lookup `email` for `User` and `token` for `ActivationToken`.

- Bind RouteKey to look up `token` for `ActivationToken` Model and not `id`

```php
    public function getRouteKeyName()
    {
        return 'token';
    }
```

- Create Events that handle Sending ActivationToken to Mail in `Providers\EventServiceProvider.php`.

```php
    protected $listen = [
        'App\Events\Activation\RequestActivationToken' => [
            'App\Listeners\Activation\SendActivationToken',
        ],
    ];
```
- then

```bash
php artisan event:generate
```

- Add the code on `Events\Activation\RequestActivationToken` and `Listeners\Activation\SendActivationToken` respectively.

- Create Mail markdown to send `'token'` to user's email.

```bash
php artisan make:mail User\Activate\SendActivationMail --markdown="mail.user.activate.mail"
```
- Add the following components on `resources\views\mail\user\activate\mail.blade.php` template.

###### Registration, Login and ResetPassword

- Create ActivationTokenController under Auth (folder structure of your own choice)

```php
php artisan make:controller Auth\Activation\ActivationTokenController
```
- Add methods on `Auth\Activation\ActivationTokenController` to handle sending and receiving token to and from user's email.

- Add these routes on `routes\web.php` to handle sending and receiving request from `ActivationTokenController` and mail template.

```php
Route::group(['namespace' => 'Auth'], function () {
    Route::get('activate/email/{token}', 'Activation\ActivationTokenController@activate')->name('activate.email');
    Route::get('activate/resend', 'Activation\ActivationTokenController@resend')->name('resend.email');
});
```
- These routes to be handled on `RegisterController.php`, `LoginController.php` and `ResetPasswordController.php` through the events and listeners.

- Add code on `RegisterController.php`, `LoginController.php` and `ResetPasswordController.php` that checks if user is active and sends activationToken if `active => false`.

- If Successfully sending and receiving `token` to activate user then you are done.

- Advised to work with `mailtrap.io` while under `APP_ENV=local` then send to Gmail or your personal mail when testing after code completion.

#### Contributing

Feel free to Contribute more If you working on such environments.

#### Security Vulnerabilities

If you discover a security vulnerability within Laravel and such conditions, please send an e-mail to Laravel team [taylor@laravel.com](mailto:taylor@laravel.com).

#### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).