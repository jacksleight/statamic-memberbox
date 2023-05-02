@extends('statamic::layout')
@section('title', Statamic::crumb('Members'))
@section('wrapper_class', 'max-w-full')

@section('content')

    <header class="flex items-center mb-6">
        
        <h1 class="flex-1">
            {{ __('Members') }}
        </h1>

        <dropdown-list>
            <button class="btn" slot="trigger">{{ __('Export Members') }}</button>
            <dropdown-item :text="__('Export as CSV')" redirect="{{ cp_route('memberbox.export', ['type' => 'csv']) }}?download=true"></dropdown-item>
            <dropdown-item :text="__('Export as JSON')" redirect="{{ cp_route('memberbox.export', ['type' => 'json']) }}?download=true"></dropdown-item>
        </dropdown-list>
        
        @if (Statamic::pro() && auth()->user()->can('mb create members'))
            <a href="{{ cp_route('memberbox.create') }}" class="btn-primary ml-4">{{ __('Create Member') }}</a>
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