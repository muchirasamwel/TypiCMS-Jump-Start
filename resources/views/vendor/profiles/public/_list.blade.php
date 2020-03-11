<ul class="profile-list-list">
    @foreach ($items as $profile)
    @include('profiles::public._list-item')
    @endforeach
</ul>
