@inject('str', 'Statamic\Support\Str')
@extends('statamic::layout')
@section('title', __('Create Member'))

@section('content')

    <memberbox-members-wizard
        publish-container="base"
        route="{{ cp_route('memberbox.store') }}"
        users-index-url="{{ cp_route('memberbox.index') }}"
        users-create-url="{{ cp_route('memberbox.create') }}"
        :initial-fieldset="{{ json_encode($blueprint) }}"
        :initial-fields="{{ json_encode($fields) }}"
        :initial-values="{{ json_encode($values) }}"
        :initial-meta="{{ json_encode($meta) }}"
        :activation-expiry="{{ $expiry }}"
    >
    </memberbox-member-wizard>

@stop