@extends('statamic::layout')
@section('title', Statamic::crumb('Members'))

@section('content')

    <div class="min-h-screen flex justify-center pt-30">
        <div class="text-center">
            <h1 class="text-3xl tracking-tight mb-4 opacity-50 text-center">{{ __('Roles/Groups Not Configured') }}</h1>
            <p>
                Statamic's new user roles/groups confguration options must be set before using Memberbox.<br>
                Please refer to the <a href="https://jacksleight.github.io/statamic-memberbox/configuration.html#1-configure-statamics-new-user-settings" target="_blank" class="underline text-blue hover:text-blue-dark">documentation</a> for more information.
            </p>
        </div>
    </div>

@endsection