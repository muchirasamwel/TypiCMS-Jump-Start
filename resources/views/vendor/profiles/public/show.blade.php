@extends('core::public.master')

@section('title', $model->title.' – '.__('Profiles').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-profiles body-profile-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Profiles', 'model' => $model])

    @include('profiles::public._json-ld', ['profile' => $model])

    <article class="profile">
        <h1 class="profile-title">{{ $model->title }}</h1>
        @empty(!$model->image)
        <img class="profile-image" src="{!! $model->present()->image(null, 1000) !!}" alt="">
        @endempty
        @empty(!$model->summary)
        <p class="profile-summary">{!! nl2br($model->summary) !!}</p>
        @endempty
        @empty(!$model->body)
        <div class="profile-body">{!! $model->present()->body !!}</div>
        @endempty
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
