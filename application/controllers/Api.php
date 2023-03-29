<?php
class Api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public $access_token;
    public function __construct() {
        parent::__construct();
        $this->load->model('main_model');
        $this->access_token = 'c20ad4d76fe97759aa27a0c99bff6710';
    }
    public function users(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('users');
            echo json_encode(array('state'=>'Connected','users'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
    public function items(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('items');
            echo json_encode(array('state'=>'Connected','items'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
    public function tickets(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('tickets');
            echo json_encode(array('state'=>'Connected','tickets'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
    public function followers(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('followers');
            echo json_encode(array('state'=>'Connected','followers'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
    public function pages(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('pages');
            echo json_encode(array('state'=>'Connected','pages'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
    public function p_tickets(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('p_tickets');
            echo json_encode(array('state'=>'Connected','p_tickets'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
    public function tags(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('tags');
            echo json_encode(array('state'=>'Connected','tags'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
    public function visits(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('visits');
            echo json_encode(array('state'=>'Connected','visits'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
    public function alerts(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('alerts');
            echo json_encode(array('state'=>'Connected','alerts'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
    public function used(){
        if(strip_tags($this->input->post('access_token')) == $this->access_token){
            $users = $this->main_model->getAllData('used');
            echo json_encode(array('state'=>'Connected','used'=>$users));
        }else{
            echo json_encode(array('state'=>'Refused To Connect'));
        }
    }
}