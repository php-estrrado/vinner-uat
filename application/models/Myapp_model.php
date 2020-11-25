<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myapp_model extends CI_Model {

    

    public function __construct()

    {

         parent::__construct();

         // Your own constructor code			

    }

    

function getUser($term,$cat)

{ 

   /* $sql = $this->db->query('select * from user_information where name like "'. mysql_real_escape_string($term) .'%" order by name asc limit 0,10');  */
    if($cat=='brand'){
        $sql_qry='select name as title from brand where name like "'.$term .'%" order by name asc limit 0,10';
    }
    else{
        if($cat>0)

        {

            $sql_qry='select * from product where category='.$cat.' and title like "'.$term .'%" and status="ok" order by title asc limit 0,10';

            $sql1_qry="SELECT title, LEVENSHTEIN(title, '".$term."') AS distance FROM product where category=".$cat." and status='ok' ORDER BY distance asc limit 0,10";

        }

        else
        {

            /*$sql_qry='select * from product where title like "'.$term .'%" and status="ok" group BY(title) order by title asc limit 0,10';*/
            //codded by ads
            $sql_qry='select * from product where title like "'.$term .'%" and status="ok" group BY(title) order by title asc limit 0,10';
             $sql1 = $this->db->query($sql_qry);
             $res1=$sql1->num_rows();
             if($res1<=0)
            {
                $sql_qry='select name as title from brand where name like "'.$term .'%" group BY(name) order by name asc limit 0,10';
             $sqlb = $this->db->query($sql_qry);
             $resb=$sqlb->num_rows();
             if($resb<=0)
             {
               $sql_qry='select product_code as title from product where product_code like "'.$term .'%" and status="ok" group BY(product_code) order by title asc limit 0,10';
               $sql2 = $this->db->query($sql_qry);
               $res2=$sql2->num_rows();
               if($res2<=0)
                {
                 $sql_qry='select item_type as title from product where item_type like "'.$term .'%" and status="ok" group BY(item_type) order by title asc limit 0,10';
                }
              }
            } 

            //end code by ads



            $sql1_qry="SELECT title, LEVENSHTEIN(title, '".$term."') AS distance FROM product where status='ok' ORDER BY distance asc limit 0,10";

        }
    }

    $sql = $this->db->query($sql_qry);

    $res=$sql->num_rows();

    //return $sql ->result();

    if($res>0)

    {

        return $sql ->result();

    }

    else

    {

        /* $sql1 = $this->db->query("SELECT title, MATCH (title,description)  AGAINST ('+".$term."*' IN BOOLEAN MODE) AS score FROM product ORDER BY score DESC limit 0,10");*/

        $sql1 = $this->db->query($sql1_qry);

        $res1=$sql1->num_rows();

        if($res1>0)

        {

           return $sql1 ->result(); 

        }

       /* else{        

        $sql2 = $this->db->query("SELECT title, LEVENSHTEIN(title, '".$term."') AS distance FROM product ORDER BY distance asc limit 0,10");

        return $sql2 ->result();

        }*/

    }

/*SELECT title, MATCH (title,description)  AGAINST ('+".$term."*' IN BOOLEAN MODE) AS score FROM product ORDER BY score DESC;

SELECT title, LEVENSHTEIN(title, 'How to') AS distance FROM product ORDER BY distance asc

SELECT title, MATCH (title,description)  AGAINST ('+".$term."*' IN BOOLEAN MODE) AS score FROM product ORDER BY score DESC limit 0,10;

*/

    



}
    function getList($text, $type){
        $query      =   $this->db->where('status', 'ok')->like($type, $text, 'both')->order_by($type, 'asc')->group_by($type)->get('product');
        if($query->num_rows() > 0){ return $query->result(); }else{ return false; }
    }
    function getBrands($text){
        $query      =   $this->db->like('name', $text, 'both')->get('brand');
        if($query->num_rows() > 0){ return $query->result(); }else{ return false; }
    }
    function getLevenshtein($prds, $text){  $ss = '';
        // no shortest distance found, yet
        $shortest = -1;
        // loop through words to find the closest
        foreach ($prds as $prd) {
            $lev = levenshtein($text, $prd->title);
            if ($lev == 0) {
                $closest = $prd->title;
                $shortest = 0;
                break;
            }
            if ($lev <= $shortest || $shortest < 0) {
                $closest  = $prd->title;
                $shortest = $lev;
            }
            
            $lev = levenshtein($text, $prd->product_code);
            if ($lev == 0) {
                $closest = $prd->product_code;
                $shortest = 0;
                break;
            }
            if ($lev <= $shortest || $shortest < 0) {
                $closest  = $prd->product_code;
                $shortest = $lev;
            }
            
            $lev = levenshtein($text, $prd->item_type);
            if ($lev == 0) {
                $closest = $prd->item_type;
                $shortest = 0;
                break;
            }
            if ($lev <= $shortest || $shortest < 0) {
                $closest  = $prd->item_type;
                $shortest = $lev;
            }
            
            if($prd->tag != ''){
                $prdTags    =   explode(',',$prd->tag);
                foreach($prdTags as $prdTag){
                    $lev = levenshtein($text, $prdTag);
                    if ($lev == 0) {
                        $closest = $prdTag;
                        $shortest = 0;
                        break;
                    }
                    if ($lev <= $shortest || $shortest < 0) {
                        $closest  = $prdTag;
                        $shortest = $lev;
                    }
                }
            }
        }

    //    echo "Input word: $text\n";
        if ($shortest == 0) {
            return 0;
        } else if($shortest < strlen($text)) {
            return  array('input'=>$text,'result'=>$closest);
        }else{ return  0; }
    }

}