{{-- App is Arabic/RTL by default; always load theme CSS so login (outside localization middleware) stays styled. --}}
<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors-rtl.min.css') }}">
<!-- END: Vendor CSS-->

<!-- BEGIN: Theme CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css-rtl/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css-rtl/bootstrap-extended.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css-rtl/colors.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css-rtl/components.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css-rtl/custom-rtl.css') }}">
<!-- END: Theme CSS-->

<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css-rtl/core/menu/menu-types/vertical-menu-modern.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css-rtl/core/colors/palette-gradient.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/charts/jquery-jvectormap-2.0.3.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/charts/morris.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/simple-line-icons/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css-rtl/main.css') }}">
<!-- END: Page CSS-->

<!-- BEGIN: Custom CSS-->
@yield('style')
<!-- END: Custom CSS-->
