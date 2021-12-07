<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | The route paths used for all form pages. To disable a route/form set the
    | value to false. If you disable the activate route the welcome emails will
    | not work unless you manaully define your own `statamic.memberbox.activate`
    | route. Same applies to the login route and the redirect tag.
    |
    */

    'routes' => [
        'activate'        => '/account/activate',
        'register'        => '/account/register',
        'login'           => '/account/login',
        'profile'         => '/account/profile',
        'forgot_password' => '/account/forgot-password',
        'reset_password'  => '/account/reset-password',
        'change_password' => '/account/change-password',
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
    ],

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
