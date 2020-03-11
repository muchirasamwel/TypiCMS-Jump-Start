@extends('core::admin.master')

@section('title', __('New contactus'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'contactuses'])
        <h1 class="header-title">@lang('New contactus')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-contactuses'))->multipart()->role('form') !!}
        @include('contactuses::admin._form')
    {!! BootForm::close() !!}

@endsection
