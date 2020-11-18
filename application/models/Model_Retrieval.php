<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Retrieval extends CI_Model 
{

  public function All_transaction($tablename) 
  {
    
    $this->db->limit(100);
    $this->db->order_by('date_created','DESC');
    $query = $this->db->get($tablename);

    return ( ($query->num_rows() > 0) ? $query->result() : false );
  }

  public function Search_transaction($tablename,$to=true,$from,$status=true) 
  {  
    

    if($status !='all')
    $this->db->where('status',$status);

    $this->db->limit(100);
    $this->db->order_by('date_created','DESC');
    $query = $this->db->get($tablename);

    return ( ($query->num_rows() > 0) ? $query->result() : false );
  }

  /*************************************************************************
  **************************Retrieve Rows***********************************
  **************************************************************************/

/************Retrieve row data*********************/
  public function Get_data($tablename){

    $query = $this->db->get($tablename);
        
    return ( ($query->num_rows() == 1) ? $query->row() : false );
  }
  

  /************Retrieve row data*********************/
  public function Get_data_withCondition($tablename,$WhereClause){

    $this->db->where($WhereClause);
    $query = $this->db->get($tablename);
        
    return ( ($query->num_rows() == 1) ? $query->row() : false );
  }


  /*****************************************************************************
  ******************************Retrieve Results********************************
  ******************************************************************************/
  
  /*****************Retrieving All rows***************/
  public function All_data($tablename) 
  {
    $query = $this->db->get($tablename);
        
    return ( ($query->num_rows() > 0) ? $query->result() : false );
  }


  /**************Retrieving Condition*****************/
  public function All_data_withCondition($tablename,$WhereClause){ 
    
    $this->db->where($WhereClause);
    $query = $this->db->get($tablename); 
    
    return ( ($query->num_rows() > 0) ? $query->result() : false );
  }


  public function All_data_Condition_limit($tablename,$WhereClause,$limit){ 
    
    $this->db->where($WhereClause);
    $this->db->limit($limit); 
    $query = $this->db->get($tablename); 
    
    return ( ($query->num_rows() > 0) ? $query->result() : false );
  }

  
    /******************Number of row *************************/
  public function Count_rows($tablename,$WhereClause){ 
    
    $this->db->select('id');
    $this->db->where($WhereClause);
    $this->db->from($tablename);
   
    return  $this->db->count_all_results();
  }


  public function GetUUID(){

    $SQL = "Select UUID() as uuid";    
    $query = $this->db->query($SQL);
    return $query->result_array();
   
  }



    

















}//End of class
