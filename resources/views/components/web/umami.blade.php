@once
@push('javascript')
<script
    async
    defer
    data-website-id="{{ config('services.umami.website_id') }}"
    data-domains="{{ config('services.umami.domain') }}"
    src="https://{{ config('services.umami.api_url') }}/umami.js"
></script>
@endpush
@endonce
