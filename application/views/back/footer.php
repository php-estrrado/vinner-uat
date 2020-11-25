
<footer id="footer">
	<!--
    <div class="show-fixed pull-right">
        <ul class="footer-list list-inline">
            <li>
                <p class="text-sm"><?php echo translate('SEO_proggres');?></p>
                <div class="progress progress-sm progress-light-base">
                    <div style="width: 80%" class="progress-bar progress-bar-danger"></div>
                </div>
            </li>
    
            <li>
                <p class="text-sm"><?php echo translate('online_tutorial');?></p>
                <div class="progress progress-sm progress-light-base">
                    <div style="width: 80%" class="progress-bar progress-bar-primary"></div>
                </div>
            </li>
            <li>
                <button class="btn btn-sm btn-dark btn-active-success"><?php echo translate('checkout');?></button>
            </li>
        </ul>
    </div> -->

	<div class="hide-fixed pull-right pad-rgt">Powered by Estrrado Technologies</div>
	<p class="pad-lft">&#0169; <?php echo date('Y'); ?> <?php echo $system_title;?></p>
</footer>

<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('change','input.number',function(){ 
            var id  = this.id;
            var val = this.value.replace(/[^0-9\.]/g,''); if($('#'+id).attr('data') == 'qty' && val == 0){ val = 1; } $('#'+id).val(val); 
            if($('#'+id).val() == ''){ $('#'+id).val(0); }
        });
        $('body').on('change','input.numberonly',function(){ 
            var id  = this.id;
            var val = this.value.replace(/[^0-9]/g,''); if($('#'+id).attr('data') == 'qty' && val == 0){ val = 1; } $('#'+id).val(val); 
            if($('#'+id).val() == ''){ $('#'+id).val(0); }
        });
    });
</script>

				
						