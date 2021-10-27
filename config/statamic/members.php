<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | The route paths used for all form pages. To disable a route/form set the
    | path to false.
    |
    */

    'routes' => [
        'login'    => 'account/login',
        'forgot'   => 'account/forgot',
        'reset'    => 'account/reset',
        'activate' => 'account/activate',
        'register' => 'account/register',
        'edit'     => 'account/edit',
        'password' => 'account/password',
    ],

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    |
    | Which user fields are fillable through the edit form
    |
    */

    'fillable' => [
        'name',
        'email',
    ],

];