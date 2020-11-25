<?php

class Shippings extends CI_Model 
{

    function __construct() 
    {
        parent::__construct();
    }

   function getOperators(){
       return   $this->db->select('O.*,C.name as country,S.name as state,L.name as city')
                ->join('countries as C','O.country_id = C.id')->join('states as S','O.state_id = S.id')->join('cities as L','O.city_id = L.id')
                ->get('shipping_operators as O')->result();
   }
   
   function getOperatorDetails($id=0){
       return   $this->db->select('O.*,C.name as country,S.name as state,L.name as city')
                ->join('countries as C','O.country_id = C.id')->join('states as S','O.state_id = S.id')->join('cities as L','O.city_id = L.id')
                ->get_where('shipping_operators as O',['O.id'=>$id])->row();
   }

   function getZones(){
        return   $this->db->select('Z.*,C.name as country,O.operator')
                ->join('countries as C','Z.country_id = C.id')->join('shipping_operators as O','Z.operator_id = O.id')
                ->get('shipping_zones as Z')->result();
    }
    
    function getZoneDetails($id=0){
        return   $this->db->select('Z.*,C.name as country,O.operator')
                ->join('countries as C','Z.country_id = C.id')->join('shipping_operators as O','Z.operator_id = O.id')
                ->get_where('shipping_zones as Z',['Z.id'=>$id])->row();
    }
    
    function getOperatorData($cId,$exceptId=''){
        $query              =   $this->db->select('operator_id')->get_where('shipping_zones',['country_id'=>$cId,'status'=>1])->result();
        if($query){ foreach($query as $row){ $optIds[] = $row->operator_id; } }else{ $optIds = []; }
        if($exceptId != ''){  unset($optIds[array_search($exceptId,$optIds)]); } 
        if(count($optIds) > 0){ $qry = $this->db->where_not_in('id',$optIds)->where('status',1)->get('shipping_operators')->result(); }
        else{ $qry = $this->db->where('status',1)->get('shipping_operators')->result(); }
        $res                =   [''=>'Select Operator'];
        if($qry){ foreach($qry as $row){ $res[$row->id] = $row->operator; } }  return $res;
    }
}
