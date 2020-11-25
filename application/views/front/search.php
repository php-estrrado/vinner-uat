    <?php
        echo form_open(base_url() . 'index.php/home/main_search', array('method' => 'post','role' => 'search','id'=>'search-form')); ?>   
            <div class="input-group input-group-lg full-width">
                 <div class="col-md-2 col-sm-8 col-xs-12 white-border" hidden>
                  <div class="nav_cat row">
                        <select name='category' id='category' class="" >
                            <option value="0"   class=""><?php echo translate('all_products');?></option><?php
                                $categories = $this->db->order_by('sort_order','asc')->get('category')->result_array();
                                foreach($categories as $row){ ?>
                                    <option value="<?php echo $row['category_id']; ?>"  class=""><?php echo ucfirst($row['category_name']); ?></option><?php
                                } ?>
                            <option value="brand"   class=""><?php echo 'BRANDS';?></option>
                        </select>
                        <i></i>
                    </div>
                </div>
                <div class="col-md-11 col-sm-10 col-xs-12 search_top">
                    <div class="row">
                        <a href="<?php echo base_url(); ?>" class="home_search fa fa-home">&nbsp;</a> 
                        <input type="text" name="query" id="txtinput" class="form-control tryu search-input" placeholder="<?php echo translate('What are you looking for ?') ?>" value="<?php echo urldecode($this->uri->segment('7')); ?>" />
                        <span class="input-group-btn">
                            <button id="id_search" class="btn btn-input_type custom" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>  
                </div>
            <!--       <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class=" nopadding-left adv-search ser-adv"><a href="<?php echo base_url(); ?>index.php/home/advance_search"> 
                        <div class="adv_srch ">ADVANCE SEARCH</div></a>
                    </div>
                </div>
             <div class="col-sm-3">
                        
                </div>-->
            </div>
            
        <?php echo form_close() ?>
        <div class="clr"></div>
<style type="text/css">
.search_top{
    position: relative;
}
.home_search {
    position: absolute;
    left: 0;
    top: 0;
    font-size: 22px;
    padding: 7px 8px;
    z-index: 99;
}
#txtinput{
    padding-left: 35px;
}
</style>