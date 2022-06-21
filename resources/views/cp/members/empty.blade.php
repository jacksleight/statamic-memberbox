@extends('statamic::layout')
@section('title', Statamic::crumb('Members'))

@section('content')

    @include('statamic::partials.empty-state', [
        'title' => __('Members'),
        'description' => __('statamic-memberbox::messages.member_intro'),
        'svg' => 'empty/users',
        'button_text' => __('Create Member'),
        'button_url' => cp_route('memberbox.create'),
    ])

@endsection