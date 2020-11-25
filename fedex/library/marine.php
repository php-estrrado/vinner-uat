<?php
class Marine {
	private $config;
	private $db;
	private $data = array();
	private $data_recurring = array();

	public function Connect(){ $db = new mysqli("localhost","marineca_admin","admin@123#","marineca_marinecartlive"); return $db; }
	public function Config() { $con = mysqli_connect("localhost","marineca_admin","admin@123#","marineca_marinecartlive"); return $con; }

	public function getVendor($id) {
            $con = $this->Config();
            $set_sql="select * from vendor where vendor_id='$id'";
            $set_ex=mysqli_query($con,$set_sql);
            $set_res=mysqli_fetch_object($set_ex);
            return  $set_res;
	}

	public function getProductDetails($id)
        {
            $con = $this->Config();
            $set_sql="select * from sale where sale_code='$id'";
            $set_ex=mysqli_query($con,$set_sql);
            $set_res=mysqli_fetch_object($set_ex);
            return  $set_res;
        }
        
        public function getTotals($ids)
        {
            $con = $this->Config();
            $set_sql="select SUM(`weight`) AS weight, SUM(`sale_price`) AS price from `product` where `product_id` IN (".implode(',', $ids).")";
            $set_ex=mysqli_query($con,$set_sql);
            $set_res=mysqli_fetch_object($set_ex);
            return  $set_res;
        }
        
        public function getProduct($id)
        {
            $con = $this->Config();
            $set_sql="select * from `product` where product_id='$id'";
            $set_ex=mysqli_query($con,$set_sql);
            $set_res=mysqli_fetch_object($set_ex);
            return  $set_res;
        }
        
        public function addLabelDatail($data)
        {
            $con = $this->Config();
            mysqli_query($con," INSERT INTO fed_labels (order_id,tracking_no,pdf_label,net_charge,tracking_type) 
                                VALUES ('".$data['order_id']."','".$data['tracking_no']."','".$data['pdf_label']."','".$data['net_charge']."','".$data['tracking_type']."')");
            $set_ex=mysqli_query($con," SELECT COUNT(*) AS count, created FROM `fed_labels` WHERE `order_id` = '".$data['order_id']."' ");
            $set_res=mysqli_fetch_object($set_ex);
            return  $set_res;
        }
        
        public function getWeightUnit($id)
        {
            $con = $this->Config();
            $set_sql="select `unit` from `fed_weight_class_description` where `weight_class_id` ='$id'";
            $set_ex=mysqli_query($con,$set_sql);
            $set_res=mysqli_fetch_object($set_ex); 
            return  $set_res->unit;
        }
        public function getDimUnit($id)
        {
            $con = $this->Config();
            $set_sql="select `unit` from `fed_length_class_description` where `length_class_id` ='$id'";
            $set_ex=mysqli_query($con,$set_sql);
            $set_res=mysqli_fetch_object($set_ex);
            return  $set_res->unit;
        }
        function isGroupedPrd($id,$qty){ 
            $db             =   $this->Connect();
            $query          =   $db->query(" SELECT * FROM `product` WHERE `product_id` = $id ");
            if($query->fetch_object()->type == 'grouped'){
                $query      =   $db->query(" SELECT * FROM `grouped_product` WHERE `grouped_id` = $id ");
                if($query->num_rows > 0){ 
                    while($result =   $query->fetch_object()){
                        $data[]     =   $result;
                    }
                    return $data;
                }else{ return false; }
            }else{ return false; }
        }
}
?>

