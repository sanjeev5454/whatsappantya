    {!!Html::script('global/vendor/babel-external-helpers/babel-external-helpers.js')!!}
	{!!Html::script('global/vendor/jquery/jquery.js')!!}
	{!!Html::script('global/vendor/popper-js/umd/popper.min.js')!!}
    {!!Html::script('global/vendor/bootstrap/bootstrap.js')!!}
    {!!Html::script('global/vendor/animsition/animsition1.js')!!}
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
	

	{!!Html::script('global/js/tagsinput.js')!!}
	
	{!!Html::script('global/js/datatables.js')!!}
	
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

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd',changeMonth:true,
           changeYear:true });
  } );
  </script>
<script>
$(document).ready(function () {
  //called when key is pressed in textbox
  $("#receiver_mobile_no").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        //$("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});
</script>
