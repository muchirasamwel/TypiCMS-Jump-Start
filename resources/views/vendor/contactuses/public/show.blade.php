@extends('core::public.master')

@section('title', $model->title.' – '.__('Contactuses').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-contactuses body-contactus-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Contactuses', 'model' => $model])

    @include('contactuses::public._json-ld', ['contactus' => $model])

    <article class="contactus">
        <h1 class="contactus-title">{{ $model->title }}</h1>
        @empty(!$model->image)
        <img class="contactus-image" src="{!! $model->present()->image(null, 1000) !!}" alt="">
        @endempty
        @empty(!$model->summary)
        <p class="contactus-summary">{!! nl2br($model->summary) !!}</p>
        @endempty
        @empty(!$model->body)
        <div class="contactus-body">{!! $model->present()->body !!}</div>
        @endempty
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
