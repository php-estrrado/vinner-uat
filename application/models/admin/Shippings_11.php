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
                ->get_where('shipping_operators as O',['O.status'=>1])->result();
   }
   
   function getOperatorDetails($id=0){
       return   $this->db->select('O.*,C.name as country,S.name as state,L.name as city')
                ->join('countries as C','O.country_id = C.id')->join('states as S','O.state_id = S.id')->join('cities as L','O.city_id = L.id')
                ->get_where('shipping_operators as O',['O.id'=>$id])->row();
   }

   function getZones(){
        return   $this->db->select('Z.*,C.name as country,O.operator')
                ->join('countries as C','Z.country_id = C.id')->join('shipping_operators as O','Z.operator_id = O.id')
                ->get_where('shipping_zones as Z',['Z.status'=>1])->result();
    }
}
