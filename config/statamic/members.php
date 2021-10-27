<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | The route paths used for all form pages. To disable a route/form set the
    | path to false. If you disable the activate route the welcome emails will
    | not work unless you manaully define your own `statamic.members.activate`
    | route. Same applies to the login route and the redirect tag.
    |
    */

    'routes' => [
        'login'    => '/account/login',
        'forgot'   => '/account/forgot',
        'reset'    => '/account/reset',
        'activate' => '/account/activate',
        'register' => '/account/register',
        'edit'     => '/account/edit',
        'password' => '/account/password',
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