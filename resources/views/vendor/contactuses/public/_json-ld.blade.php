{{--
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "",
    "name": "{{ $contactus->title }}",
    "description": "{{ $contactus->summary !== '' ? $contactus->summary : strip_tags($contactus->body) }}",
    "image": [
        "{{ $contactus->present()->image() }}"
    ],
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $contactus->uri() }}"
    }
}
</script>
--}}
