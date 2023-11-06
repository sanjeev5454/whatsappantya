

<?php /*?>
<footer class="site-footer" style="display:none">
  <div class="site-footer-legal">© {{date('Y')}}</div>
  <div class="site-footer-right"> Crafted with <i class="red-600 icon md-favorite"></i> by <a href="http://techvoi.com/" target="_blank">TechVoi</a> </div>
</footer>
<?php */?>
<!-- Core  --> 

<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/babel-external-helpers/babel-external-helpers.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery/jquery.js"></script> 
<span id="ajax">
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

</span>
<script>
$(function(){
     $(document).on('change','.profit-dropdown',function(){
	     $('#loader').show();
	     var profit_id = $(this).val();
		 if(profit_id=='all')
		 {
		 setTimeout(function() {
		$('#loader').hide();
		}, 1000);
		 $('.data-t').show();
		 $('.first-center').html($('.first-center-name').val());
		 $('.graph-div').hide();
		 }else{
		 var c_name = $('#c-'+profit_id).val();
		 $('.first-center').html(c_name);
		 $('.data-t').hide();
		 $('.'+profit_id).show();
		 $('.graph-div').hide();
		 $('.graph-'+profit_id).show();
		 ajaxDataRender(profit_id);
		setTimeout(function() {
		$('#loader').hide();
		}, 1000);
		 }
	 });
});
</script>
<script>
function ajaxDataRender(profit_id)
{

		$.ajax({
		type: "GET",
		url: "{{ url('financialsummary/ajaxCenterGraph')}}/"+profit_id,
		data: {profit_id:profit_id},
		success: function(msg){
		//alert(msg); return false;
		if(msg!='')
		{
		/*var options_{!! getProfitDropdownPageajax()['_id'] !!} = {
	animationEnabled: true,  
	title:{
		text: "Monthly Net Revenue - 2019"
	},
	axisX: {
		valueFormatString: "MMMM-YYYY",
		interval: 1,
        intervalType: "month",
	},
	axisY: {
		title: "Turnover",
		prefix: "Rs ",
		valueFormatString: "#,##,###.00#",
		includeZero: false
	},
	data: [{
		yValueFormatString: "Rs #,##,###.00#",
		xValueFormatString: "MMMM-YYYY",
		type: "spline",
		dataPoints: [
			{ x: new Date(2019, 3), y: 0 },
			{ x: new Date(2019, 4), y: 0 },
			{ x: new Date(2019, 5), y: 0 },
			{ x: new Date(2019, 6), y: 0 },
			{ x: new Date(2019, 7), y: 0 },
			{ x: new Date(2019, 8), y: 0 },
			{ x: new Date(2019, 9), y: 0 },
			{ x: new Date(2019, 10), y: 0 },
			{ x: new Date(2019, 11), y: 0 },
			{ x: new Date(2020, 0), y: 0 },
			{ x: new Date(2020, 1), y:  0 },
			{ x: new Date(2020, 2), y:  0 },
		]
	}]
};

$("#chartContainer-{!! getProfitDropdownPageajax()['_id'] !!}").CanvasJSChart(options_{!! getProfitDropdownPageajax()['_id'] !!});*/
		$('#ajax').html(msg);
		
		}
		}
		});
	 
}
</script>

<script>
$(function(){
   $(document).on('change','.company-dropdown',function(){
       var company_id = $(this).val();
	    if(company_id!=''){
		$.ajax({
		type: "GET",
		url: "{{ url('financialsummary/ajaxDropdownUpdate')}}/"+company_id,
		data: {company_id:company_id},
		success: function(msg){
		//alert(msg); return false;
		if(msg==1)
		{
		window.location.reload(true);
		}
		}
		});
	 }
    });
});
</script>

<!-- custom js  --> 
@yield('mycustom_js') 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/popper-js/umd/popper.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/bootstrap/bootstrap.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/animsition/animsition.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/mousewheel/jquery.mousewheel.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/asscrollbar/jquery-asScrollbar.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/asscrollable/jquery-asScrollable.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/waves/waves.js"></script> 

<!-- Plugins --> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery-mmenu/jquery.mmenu.min.all.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/switchery/switchery.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/intro-js/intro.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/screenfull/screenfull.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/slidepanel/jquery-slidePanel.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/timepicker/jquery.timepicker.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datepair/datepair.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datepair/jquery.datepair.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/select2/select2.full.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/bootstrap-tokenfield/bootstrap-tokenfield.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/bootstrap-select/bootstrap-select.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/icheck/icheck.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/asrange/jquery-asRange.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/ionrangeslider/ion.rangeSlider.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/asspinner/jquery-asSpinner.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/clockpicker/bootstrap-clockpicker.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/ascolor/jquery-asColor.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/asgradient/jquery-asGradient.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/ascolorpicker/jquery-asColorPicker.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery-knob/jquery.knob.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/bootstrap-touchspin/bootstrap-touchspin.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery-labelauty/jquery-labelauty.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery-strength/password_strength.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery-strength/jquery-strength.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/multi-select/jquery.multi-select.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/typeahead-js/bloodhound.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/typeahead-js/typeahead.jquery.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery-placeholder/jquery.placeholder.js"></script> 
<!-- ////////////////////////////////////////    --> 

<!-- for table pages --> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net/jquery.dataTables.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-scroller/dataTables.scroller.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-responsive/dataTables.responsive.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-buttons/dataTables.buttons.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-buttons/buttons.html5.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-buttons/buttons.flash.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-buttons/buttons.print.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-buttons/buttons.colVis.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/asrange/jquery-asRange.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/bootbox/bootbox.js"></script> 
<!--End for table pages --> 
<!--End Plugins --> 

<!-- Scripts --> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Component.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Base.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Config.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Section/Menubar.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Section/Sidebar.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Section/PageAside.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Section/GridMenu.js"></script> 

<!-- Config --> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/config/colors.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/config/tour.js"></script> 
<script>Config.set('assets', "{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets");</script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/clockpicker/bootstrap-clockpicker.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/clockpicker.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/jt-timepicker.js"></script> 
<!-- Page --> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Site.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/asscrollable.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/slidepanel.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/switchery.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/datatables.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/ascolorpicker.js"></script>
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/examples/js/tables/datatable.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/examples/js/uikit/icon.js"></script> 
<script>
      (function(document, window, $){
        'use strict';    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script> 
@yield('custom_script') 

<!--- Form Validation--> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/formvalidation/formValidation.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/formvalidation/framework/bootstrap4.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/examples/js/forms/validation.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/formatter.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/formatter/jquery.formatter.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/select2.js"></script>
	<script src="{{asset(PUBLIC_FOLDER.'theme')}}/assets/examples/js/forms/advanced.js"></script>

<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/bootstrap-select.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/multi-select.js"></script> 

<!--- customJS antya --> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/custom/js/custom.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script> 
<script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/custom/js/summernote.min.js"></script><!-- For Editor --> 
<!--- customJS antya --> 


<script>
$(document).ready(function() {
	$('table.table').wrap("<div class='responsive-table'></div>")
  $(".fixed_table").parent().addClass("fixed-table-wrap");
});
</script> 
<script>
$(document).ready(function() {
   $(".burger a, .menu-overlay").click(function() {
       $("button.hamburger").trigger("click");
   });
});
</script>
<script src="{{ url('public/gdrive/lightbox.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/gdrive/google-drive.js') }}"></script>
<script async defer src="https://apis.google.com/js/api.js" 
      onload="this.onload=function(){};handleClientLoad()" 
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>
<script src="{{ url('public/gdrive/upload.js') }}"></script>

@yield('custom_validation_script')
