{{-- <script src="{{ asset('admin/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap/bootstrap.bundle.min.js') }}"></script> --}}
{{ module_vite('build-sysadmin', 'resources/assets/js/script.js') }}
<script type="module" src="{{ asset('admin/js/icons/feather-icon/feather.min.js') }}"></script>
<script type="module" src="{{ asset('admin/js/icons/feather-icon/feather-icon.js') }}"></script>
<script type="module" src="{{ asset('admin/js/scrollbar/simplebar.js') }}"></script>
<script type="module" src="{{ asset('admin/js/scrollbar/custom.js') }}"></script>
<script type="module" src="{{ asset('admin/js/config.js') }}"></script>
<script type="module" src="{{ asset('admin/js/sidebar-menu.js') }}"></script>
<script type="module" src="{{ asset('admin/js/slick/slick.min.js') }}"></script>
<script type="module" src="{{ asset('admin/js/slick/slick.js') }}"></script>
<script type="module" src="{{ asset('admin/js/header-slick.js') }}"></script>
<script type="module" src="{{ asset('admin/js/script.js') }}"></script>
<script type="module" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
@yield('script')
@if (Route::currentRouteName() == 'index')
    <script>
        new WOW().init();
    </script>
@endif
