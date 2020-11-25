<div class="content container">
    <div class="row">
    	<div class="col-sm-12 legal">
            <h2 class="title"><?php echo $page_title;?></h2>
        
            <?php
                echo $this->db->get_where('general_settings',array('type'=>$type))->row()->value;
            ?>
        </div>
    </div>
</div>