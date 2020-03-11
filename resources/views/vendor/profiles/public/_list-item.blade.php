<li class="profile-list-item">
    <a class="profile-list-item-link" href="{{ $profile->uri() }}" title="{{ $profile->title }}">
        <span class="profile-list-item-title">{!! $profile->title !!}</span>
        <span class="profile-list-item-image-wrapper">
            <img class="profile-list-item-image" src="{!! $profile->present()->image(null, 200) !!}" alt="">
        </span>
    </a>
</li>
