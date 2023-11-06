    {!!Html::script('global/vendor/babel-external-helpers/babel-external-helpers.js')!!}
	{!!Html::script('global/vendor/jquery/jquery.js')!!}
	{!!Html::script('global/vendor/popper-js/umd/popper.min.js')!!}
    {!!Html::script('global/vendor/bootstrap/bootstrap.js')!!}
    {!!Html::script('global/vendor/animsition/animsition.js')!!}
    {!!Html::script('global/vendor/mousewheel/jquery.mousewheel.js')!!}
    {!!Html::script('global/vendor/asscrollbar/jquery-asScrollbar.js')!!}
	{!!Html::script('global/vendor/asscrollable/jquery-asScrollable.js')!!}
    {!!Html::script('global/vendor/waves/waves.js')!!}
    
    <!-- Plugins -->
	{!!Html::script('global/vendor/jquery-mmenu/jquery.mmenu.min.all.js')!!}
    {!!Html::script('global/vendor/switchery/switchery.js')!!}
    {!!Html::script('global/vendor/intro-js/intro.js')!!}
    {!!Html::script('global/vendor/screenfull/screenfull.js')!!}
    {!!Html::script('global/vendor/slidepanel/jquery-slidePanel.js')!!}
    {!!Html::script('global/vendor/jquery-placeholder/jquery.placeholder.js')!!}
    {!!Html::script('global/vendor/chartist/chartist.min.js')!!}
	{!!Html::script('global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.js')!!}
	{!!Html::script('global/vendor/jvectormap/jquery-jvectormap.min.js')!!}
	{!!Html::script('global/vendor/jvectormap/maps/jquery-jvectormap-world-mill-en.js')!!}
	{!!Html::script('global/vendor/matchheight/jquery.matchHeight-min.js')!!}
	{!!Html::script('global/vendor/peity/jquery.peity.min.js')!!}

    
    <!-- Scripts -->
	{!!Html::script('global/js/Component.js')!!}
    {!!Html::script('global/js/Plugin.js')!!}
    {!!Html::script('global/js/Base.js')!!}
    {!!Html::script('global/js/Config.js')!!}
    {!!Html::script('assets/js/Section/Menubar.js')!!}
    {!!Html::script('assets/js/Section/Sidebar.js')!!}
	{!!Html::script('assets/js/Section/PageAside.js')!!}
    {!!Html::script('assets/js/Section/GridMenu.js')!!}
    <!-- Config -->
	{!!Html::script('global/js/config/colors.js')!!}
    {!!Html::script('assets/js/config/tour.js')!!}
    
    <!-- Page -->
	{!!Html::script('assets/js/Site.js')!!}
    {!!Html::script('global/js/Plugin/asscrollable.js')!!}
    {!!Html::script('global/js/Plugin/slidepanel.js')!!}
    {!!Html::script('global/js/Plugin/switchery.js')!!}
    {!!Html::script('global/js/Plugin/matchheight.js')!!}
    {!!Html::script('global/js/Plugin/jvectormap.js')!!}
    {!!Html::script('global/js/Plugin/peity.js')!!}
    {!!Html::script('assets/examples/js/dashboard/v1.js')!!}
	
	{!!Html::script('global/vendor/datatables.net/jquery.dataTables.js')!!}
	{!!Html::script('global/vendor/datatables.net-bs4/dataTables.bootstrap4.js')!!}
	{!!Html::script('global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js')!!}
	{!!Html::script('global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js')!!}
	{!!Html::script('global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js')!!}
	{!!Html::script('global/vendor/datatables.net-scroller/dataTables.scroller.js')!!}
	{!!Html::script('global/vendor/datatables.net-responsive/dataTables.responsive.js')!!}
	{!!Html::script('global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js')!!}
	{!!Html::script('global/vendor/datatables.net-buttons/dataTables.buttons.js')!!}
	{!!Html::script('global/vendor/datatables.net-buttons/buttons.html5.js')!!}
	{!!Html::script('global/vendor/datatables.net-buttons/buttons.flash.js')!!}
	{!!Html::script('global/vendor/datatables.net-buttons/buttons.print.js')!!}
	{!!Html::script('global/vendor/datatables.net-buttons/buttons.colVis.js')!!}
	{!!Html::script('global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js')!!}
	{!!Html::script('global/js/Plugin/datatables.js')!!}
	{!!Html::script('assets/examples/js/tables/datatable.js')!!}
	{!!Html::script('global/js/tagsinput.js')!!}
    <script>
      (function(document, window, $){
        'use strict';
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>
	<!---Google Drive ----->
<!--<script src="{{ url('public/gdrive/date.js') }}" type="text/javascript"></script>-->
<script src="{{ url('public/gdrive/lightbox.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/gdrive/google-drive.js') }}"></script>
<script async defer src="https://apis.google.com/js/api.js" 
      onload="this.onload=function(){};handleClientLoad()" 
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>
<script src="{{ url('public/gdrive/upload.js') }}"></script>
<!---Google Drive ----->