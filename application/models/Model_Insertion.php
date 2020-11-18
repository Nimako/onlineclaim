<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Insertion extends CI_Model 
{ 

  /************Insertion*************************/

  public function FullInsert($tablename, $data) 
  {
    $query = $this->db->insert($tablename,$data);
    
    $result = $this->db->affected_rows(); 
    
    return(($result > 0) ? true : false);
  }


  
  /************Update*************************/

  public function Update($tablename,$whereClause,$data){
    
    $this->db->where($whereClause);
    $query = $this->db->Update($tablename,$data);
        
    return(($query) ? true : false);
  }


   /************Delete*************************/

  public function Delete($tablename,$whereClause){
    
    $this->db->where($whereClause);
    $query = $this->db->delete($tablename);
    
    return(($query) ? true : false);
  }



    
}//End of class
