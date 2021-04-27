@push('head')
    <meta name="description" content="We open doors for open-source contributors and make open-source visible and understandable for everyone and show recruiters the open-source work of a potential candidate."/>

    <x-open-graph.website :image="asset('images/og-home.png')"/>
@endpush

<x-layout.web page-title="Sponsors">

    <x-web.github-sponsors/>

    <x-web.sponsors/>

</x-layout.web>
