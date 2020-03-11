@extends('core::admin.master')

@section('title', __('Contactuses'))

@section('content')

<item-list
    url-base="/api/contactuses"
    locale="{{ config('typicms.content_locale') }}"
    fields="id,image_id,status,title"
    table="contactuses"
    title="contactuses"
    include="image"
    appends="thumb"
    :searchable="['title']"
    :sorting="['title_translated','']">

    <template slot="add-button">
        @include('core::admin._button-create', ['module' => 'contactuses'])
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="checkbox"></item-list-column-header>
        <item-list-column-header name="edit"></item-list-column-header>
        <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
        <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
        <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
        <item-list-column-header name="phone_translated" sortable :sort-array="sortArray" :label="$t('Phone')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td class="checkbox"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
        <td>@include('core::admin._button-edit', ['module' => 'contactuses'])</td>
        <td><item-list-status-button :model="model"></item-list-status-button></td>
        <td><img :src="model.thumb" alt="" height="27"></td>
        <td>@{{ model.title_translated }}</td>
        <td>@{{ model.title }}</td>
    </template>

</item-list>

@endsection
