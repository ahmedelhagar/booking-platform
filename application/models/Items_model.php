<?php
class Items_model extends CI_Model{
    
    function getAllData($col='',$order='',$xyz='',$iaa='',$limit='', $start='',$arrr=array()){
        
        $this->db->from('items');
        $this->db->limit($limit, $start);
        if($xyz !== '' OR $iaa !== ''){
        $this->db->where($xyz,$iaa);
        }
        if(!empty($arrr)){
        $this->db->where($arrr);
        }
        $this->db->order_by($col,$order);
        $q = $this->db->get(); 
        
        if($q->num_rows() > 0){
            
            return $q->result();
            
        }else{return false;}
    }
    function getAllData2(){
        
        $q=$this->db->get('items');
        
        if($q->num_rows() > 0){
            
            return $q->result();
            
        }else{return false;}
    }
    public function record_count($keyword='') {
        if($keyword !==''){
 $this->db->like('title',$keyword);
 $query  =   $this->db->get('items');
 return $query->num_rows();
        }else{
       return $this->db->count_all("items");
        }
 
   }
   function search($keyword)
    {
        $this->db->like('title',$keyword);
        $query  =   $this->db->get('items');
if($query->num_rows() > 0){
            
            return $query->result();
            
        }else{return false;}    }
 function search_link($keyword)
    {
        $this->db->where(array('url' => $keyword));
        $query  =   $this->db->get('url');
if($query->num_rows() > 0){
            
            return $query->result();
            
        }else{return false;}    }
    function insertData($data){
        $this->db->insert('items',$data);
    }
    function deleteData($id){
        $this->db->where('id',$id);
        $this->db->delete('items');
    }
    function getByData($con_col,$con){
        $q=$this->db->get_where('items',array($con_col=>$con));
        if($q->num_rows() > 0){
            
            return $q->result();
            
        }else{return false;}
    }
    function getUrlData($con_col,$con){
        $q=$this->db->get_where('url',array($con_col=>$con));
        if($q->num_rows() > 0){
            
            return $q->result();
            
        }else{return false;}
    }
    function update($con,$id,$data){
    $this->db->where($con,$id);
    $this->db->update('items',$data);
    return TRUE;
    }
    function shrink_url($stri='') {
                  $this->load->library('simple_html_dom');
                  $html = str_get_html($stri);
                  $ret = $html->find('a');
                  foreach($ret as $div) {
                      $arr[] = $div->href;
                        }
                        $x=0;
                        foreach($arr as $key => $value) {
                       if(strpos($arr[$key],base_url()) !== FALSE) {
                        unset($arr[$key]);
                        }
                        }
                        $arr2 = array_values($arr);
                        $num = count($arr2)-1;
                        if(!empty($arr2)){
                        while ($x<=$num){
                            $reco_q22[$x]=$this->db->get_where('url',array('url'=>$arr2[$x]));
                            $reco22[$x]=$reco_q22[$x]->result();
                            if($reco22[$x] == FALSE){ 
                                $this->db->insert('url',array('url' => $arr2[$x]));
                            }
                            $reco_q[$x]=$this->db->get_where('url',array('url'=>$arr2[$x]));
                            $reco[$x]=$reco_q[$x]->result();
                            $row[] = $reco[$x][0];
                            $record[] = base_url().'pages/go/'.$row[$x]->id;
                            $x++;
                        }
                        return str_replace($arr2, $record, $stri);
                        }  else {
                            return $stri;
                        }
    }
    function insert_url($arr2){
        $this->db->insert('url',array('url' => $arr2));
    }
            function increment(){
        $this->db->set('total', 'total+1', FALSE);
        $this->db->update('count');
    }

    function get_total(){
        $query = $this->db->get('count');
        if($query->num_rows()>0){
            $row = $query->row();
            return str_pad($row->total, 6 , "0", STR_PAD_LEFT);
        } else {
            return FALSE;
        }
    }
}
?>