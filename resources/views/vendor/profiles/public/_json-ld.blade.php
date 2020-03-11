{{--
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "",
    "name": "{{ $profile->title }}",
    "description": "{{ $profile->summary !== '' ? $profile->summary : strip_tags($profile->body) }}",
    "image": [
        "{{ $profile->present()->image() }}"
    ],
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $profile->uri() }}"
    }
}
</script>
--}}
