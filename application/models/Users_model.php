<?php
class Users_model extends CI_Model{
    
    function getAllData(){
        
        $q=$this->db->get('users');
        
        if($q->num_rows() > 0){
            
            return $q->result();
            
        }else{return false;}
    }
    function count_users($vvv='users',$arrr=''){
        if(!empty($arrr)){
        $this->db->where($arrr);
        }
        $q=$this->db->get($vvv);
        
        if($q->num_rows() > 0){
            
            return $q->num_rows();
            
        }else{return 0;}
    }
    function insertData($data){
        $this->db->insert('users',$data);
    }
    function insertVisit($data){
        $this->db->insert('visitors',$data);
    }
    function deleteData($id){
        $this->db->where('id',$id);
        $this->db->delete('users');
    }
    function getByData($con_col,$con){
        $q=$this->db->get_where('users',array($con_col=>$con));
        if($q->num_rows() > 0){
            
            return $q->result();
            
        }else{return false;}
    }
    function update($con,$id,$data){
    $this->db->where($con,$id);
    $this->db->update('users',$data);
    return TRUE;
    }
    public function is_logged_in()
              {
                $user = $this->session->userdata('username');
                return isset($user);
              }

}
?>