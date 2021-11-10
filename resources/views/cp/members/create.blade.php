@inject('str', 'Statamic\Support\Str')
@extends('statamic::layout')
@section('title', __('Create Member'))

@section('content')

    <memberbox-members-wizard
        route="{{ cp_route('memberbox.store') }}"
        users-index-url="{{ cp_route('memberbox.index') }}"
        users-create-url="{{ cp_route('memberbox.create') }}"
        :activation-expiry="{{ $expiry }}"
        :separate-name-fields="{{ $str::bool($separateNameFields) }}"
    >
    </memberbox-member-wizard>

@stop