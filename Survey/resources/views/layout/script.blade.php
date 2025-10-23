
<!-- BEGIN: Vendor JS-->
<script src={{URL::asset("assets/vendors/js/vendors.min.js")}}></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src={{URL::asset("assets/vendors/js/charts/chart.min.js")}}></script>
<script src={{URL::asset("assets/vendors/js/charts/raphael-min.js")}}></script>
<script src={{URL::asset("assets/vendors/js/charts/morris.min.js")}}></script>
<script src={{URL::asset("assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js")}}></script>
<script src={{URL::asset("assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js")}}></script>
<script src={{URL::asset("assets/data/jvector/visitor-data.js")}}></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src={{URL::asset("assets/js/core/app-menu.js")}}></script>
<script src={{URL::asset("assets/js/core/app.js")}}></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src={{URL::asset("assets/js/scripts/pages/dashboard-sales.js")}}></script>
@yield('scripts')
<!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
