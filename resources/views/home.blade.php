<x-layout title="Home">
    <div
        id="home-app"
        data-cartografie-url="{{ route('cartografie.index') }}"
        data-applicativi-url="{{ route('applicativi.index') }}"
        data-regione-img="{{ asset('images/regione.png') }}"
        data-header-img="{{ asset('images/header.png') }}"
        data-cartografie-img="{{ asset('images/cartografie.png') }}"
        data-applicativi-img="{{ asset('images/applicativi.png') }}"
    ></div>
</x-layout>
