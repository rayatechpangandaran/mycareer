{{-- HERO SECTION --}}
@if (View::hasSection('hero'))
    <section class="contact-hero">
        <div class="container">
            <h1>@yield('hero_title')</h1>
            <p>@yield('hero_subtitle')</p>
        </div>
    </section>
@endif
