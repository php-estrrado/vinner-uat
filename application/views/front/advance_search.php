<?php 
$css_development = TRUE;
$rebuild         =  FALSE;
    
    $vendor_system   =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
    $description     =  $this->db->get_where('general_settings',array('type' => 'meta_description'))->row()->value;
    $keywords        =  $this->db->get_where('general_settings',array('type' => 'meta_keywords'))->row()->value;
    $author          =  $this->db->get_where('general_settings',array('type' => 'meta_author'))->row()->value;
    $system_name     =  $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
    $system_title    =  $this->db->get_where('general_settings',array('type' => 'system_title'))->row()->value;
    $revisit_after   =  $this->db->get_where('general_settings',array('type' => 'revisit_after'))->row()->value;
    $slider  =  $this->db->get_where('general_settings',array('type' => 'slider'))->row()->value;
    $slides  =  $this->db->get_where('general_settings',array('type' => 'slides'))->row()->value;
    $page_title      =  ucfirst(str_replace('_',' ',$page_title));
    $this->crud_model->check_vendor_mambership();



if($css_development == TRUE){
		include 'includes_top.php';
	} else {
		include 'includes_top_n.php';
	}

	include 'preloader.php';
	include 'header.php';

//var_dump($page_data);
?>
<style>
#accordion-vy
    {
        display:none; 
    }

.input-group.input-group-lg {
    padding: 15px 6px 15px 10px;
   background: rgb(233, 238, 241);
    margin: 35px 20px 0px 0px;
}
button.btn.btn-input_type.custom {
    margin-left: 5px;
    padding: 9px;
    border: 1px solid #a7a5a5;
}

input#txtinput {
    width: 85%;
}
select#category:focus {
    border-color: #e54f50 !important;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);
    box-shadow: 0 0 8px #e54f50 !important;
}
@media only screen and ( max-width: 720px ) 
{
.nav_catgy-drop {
    display: block;
    width: 48%;
    position: relative;
    font-size: 16px;
    white-space: nowrap;
    vertical-align: middle;
    float: left;
}
.nav_catgy-drop select#category {
    color: rgb(51, 51, 51);
    font-size: 14px;
    padding: 10px 0px 9px 2px;
    margin: 0px 16px 0px 0px;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(216, 216, 216);
    border-image: initial;
}
input#txtinput {
    width: 100%;
    margin-top: 6px;
}

button.btn.btn-input_type.custom {
   /* margin-left: 5px;*/
    padding: 9px;
    border: 1px solid #a7a5a5;
}

}
</style>
<div class="container">
<div class="row">
            <div class="col-lg-12 col-sm-12 nopadding-right" style="margin-top:10px;">
                <?php
                    echo form_open(base_url() . 'index.php/home/adv_search', array(
                        'method' => 'post',
                        'role' => 'search'
                    ));
                ?>   
                
                  
 
                    <div class="input-group input-group-lg">

                    		 <!--<input type="text" id="txtinput" size="20" />-->
                   <label class="category_drop nav_catgy-drop">
                        <select name='category' id='category' ><!--class="drops cd-select"-->
                            <option value="0"   class=""><?php echo translate('all_products');?></option>
                            <?php
                            	$categories = $this->db->get('category')->result_array();
								foreach($categories as $row){
							?>
                            	<option value="<?php echo $row['category_id']; ?>"  class=""><?php echo ucfirst($row['category_name']); ?></option>
                            <?php
								}
							?>
                            <option value="brand"   class=""><?php echo 'BRANDS';?></option>
                        </select>
                        <i></i>
                        </label>


                        <input type="text" name="query" id="txtinput" class="form-control tryu" placeholder="<?php echo translate('What are you looking for ?') ?>">
                        
                            <button class="btn btn-input_type custom" type="submit">Advanced Search</button>
                       
                    </div>
                </form>
            </div>
        </div>
</div>



<?php



include $page_name.'.php';
	include 'footer.php';
	include 'script_texts.php';
	
	if($css_development == TRUE){
		include 'includes_bottom.php';
	} else {
		include 'includes_bottom_n.php';
	}

?>
