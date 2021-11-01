@inject('str', 'Statamic\Support\Str')
@extends('statamic::layout')
@section('title', __('Create Member'))

@section('content')

    <members-user-wizard
        route="{{ cp_route('statamic-members.store') }}"
        users-index-url="{{ cp_route('statamic-members.index') }}"
        users-create-url="{{ cp_route('statamic-members.create') }}"
        :activation-expiry="{{ $expiry }}"
        :separate-name-fields="{{ $str::bool($separateNameFields) }}"
    >
    </members-user-wizard>

@stop