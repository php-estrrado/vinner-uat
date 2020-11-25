<?php

class Products extends CI_Model 
{

    function __construct() 
    {
        parent::__construct();
    }

   function getPriceChangeRequests(){
                    $this->db->select('R.*,P.title,P.product_code,V.name')
                    ->join('product as P','R.prd_id = P.product_id')->join('vendor as V','R.vendor_id = V.vendor_id')
                    ->where('R.vendor_id',$this->session->userdata('vendor_id')); 
            return        $this->db->order_by('R.id','desc')->get('product_price_request as R')->result();
   }
   
   function updatePrieRequest($id, $status){
       $req             =   $this->db->get_where('product_price_request',['id'=>$id,'status'=>0])->row();
       if($req){
           $this->db->where('id',$id)->update('product_price_request',['status'=>$status]);
           if($status   ==  1){ $this->db->where('vendor_id',$req->vendor_id)->where('prd_id',$req->prd_id)->where('status',1)->update('vendor_prices',['price'=>$req->req_price]); }
       }
   }
}
