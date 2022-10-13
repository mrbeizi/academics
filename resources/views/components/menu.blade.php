<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('includes.navbar')
        <div class="layout-page">
            @include('includes.sidebar')

            <div class="content-wrapper">
                @yield('content')
                @include('includes.footer')
            </div>

        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
</div>