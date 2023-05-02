<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Account
    |--------------------------------------------------------------------------
    |
    | Enable the automatic user account pages.
    |
    */

    'enable_account' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable Directory
    |--------------------------------------------------------------------------
    |
    | Enable the automatic user directory pages. You'll also need to uncomment
    | the routes.
    |
    | WARNING:
    | Enabling the user directory will expose user data publicly. Make sure your
    | templates only output the data you want to be public!
    |
    */

    'enable_directory' => false,

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | The route paths used for account and directory pages. Commented out
    | routes will not be enabled.
    |
    */

    'routes' => [
        'activate' => '/account/activate',
        'login' => '/account/login',
        // 'register'        => '/account/register',
        // 'profile'         => '/account/profile',
        'forgot_password' => '/account/forgot-password',
        'reset_password' => '/account/reset-password',
        'change_password' => '/account/change-password',
        // 'index'           => '/directory',
        // 'show'            => '/directory/{user}',
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile Fields
    |--------------------------------------------------------------------------
    |
    | Which user fields are fillable through the profile form
    |
    */

    'profile_fields' => [
        'name',
        'email',
        'avatar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable Control Panel Section
    |--------------------------------------------------------------------------
    |
    | Enable the control panel Members section.
    |
    */

    'enable_cp' => true,

    /*
    |--------------------------------------------------------------------------
    | Control Panel Create Fields
    |--------------------------------------------------------------------------
    |
    | Which user fields are appear in the create form
    |
    */

    'cp_create_fields' => [
        'name',
        'email',
    ],

    /*
    |--------------------------------------------------------------------------
    | Invitation From Address
    |--------------------------------------------------------------------------
    |
    | The address and name invitation emails come from.
    |
    */

    'invitation_from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

];
