@extends('core::admin.master')

@section('title', __('New profile'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'profiles'])
        <h1 class="header-title">@lang('New profile')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-profiles'))->multipart()->role('form') !!}
        @include('profiles::admin._form')
    {!! BootForm::close() !!}

@endsection
