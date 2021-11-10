@extends('statamic::layout')
@section('title', Statamic::crumb('Members'))
@section('wrapper_class', 'max-w-full')

@section('content')

    <header class="flex items-center mb-3">
        
        <h1 class="flex-1">
            {{ __('Members') }}
        </h1>
        
        @if (Statamic::pro() && auth()->user()->can('mb create members'))
            <a href="{{ cp_route('memberbox.create') }}" class="btn-primary ml-2">{{ __('Create Member') }}</a>
        @endif

    </header>

    <memberbox-members-listing
        listing-key="memberbox-members"
        initial-sort-column="email"
        initial-sort-direction="asc"
        :filters="{{ $filters->toJson() }}"
        action-url="{{ cp_route('users.actions.run') }}"
    ></memberbox-members-listing>

@endsection