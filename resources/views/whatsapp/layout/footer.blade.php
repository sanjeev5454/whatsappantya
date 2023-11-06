 <footer class="site-footer">
      <div class="site-footer-legal">&copy; {{ date('Y') }} All Right Reserved.</div>
      <div class="site-footer-right">
        
      </div>
    </footer>
<script>
$(function(){
$(document).on('change','#unit',function(){
var unit_val = $(this).val();
if(unit_val=='Other'){
$('.other-unit').show();
}else{
$('.other-unit').hide();
}
});
});
</script>