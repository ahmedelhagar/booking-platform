<?php

class Wjhatnacadmin extends CI_Controller {

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
    
        public function __construct() {
            parent::__construct();
                // Load facebook library
            $this->load->library('facebook');
            $this->load->model('main_model');
            $this->load->library("pagination");
        }
         function notfound()
        {
           $this->load->view('notfound'); 
        }
	public function index()
	{
        if(!$this->main_model->is_admin_logged_in()){
            // Redirect to profile
            redirect(base_url().'wjhatnacadmin/login');
        }
        // URL :- http://localhost/ci_main/
            $data['title'] = 'وجهتنا | الصفحة الرئيسية';
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/home_view',$data);
            $this->load->view('admin/include/footer',$data);
	}
    public function tickets(){
        if($this->main_model->is_admin_logged_in()){
            $uId = $this->session->userdata('id');
            $config = array();
            $config["base_url"] = base_url() . "wjhatnacadmin/tickets/";

            $config["total_rows"] = $this->main_model->getAllData('p_tickets','count');

            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            if($page){
                $limitval = $page.','.$config["per_page"];
            }else{
                $limitval = $config["per_page"];
            }
            
            $data['orders'] = $this->main_model->getFullRequest('p_tickets','(state = 0 OR state = 1) ORDER BY `id` DESC LIMIT '.$limitval);
            
            $data["total_rows"] = $config["total_rows"];
            
            $data['title'] = 'تذاكري | موقع وجهتنا';
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/cpay_view',$data);
            $this->load->view('admin/include/footer',$data);
    }else{
            redirect(base_url().'404/');
        }
    }
    public function checkTicket(){
        if($this->main_model->is_admin_logged_in()){
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
            $this->form_validation->set_rules('p_id','رقم الطلبية','required',$rul);
            $this->form_validation->set_rules('t_id','رقم التذكرة','required',$rul);
            if($this->form_validation->run() == true){
    $ticketOrder = $this->main_model->getFullRequest('p_tickets','(id = '.strip_tags($this->input->post('p_id')).' AND num >= '.strip_tags($this->input->post('t_id')).')');
            $uId = $this->session->userdata('id');
            $config = array();
            $config["base_url"] = base_url() . "wjhatnacadmin/tickets/";

            $config["total_rows"] = $this->main_model->getAllData('p_tickets','count');

            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            if($page){
                $limitval = $page.','.$config["per_page"];
            }else{
                $limitval = $config["per_page"];
            }
            
            $data['orders'] = $this->main_model->getFullRequest('p_tickets','(state = 0 OR state = 1) ORDER BY `id` DESC LIMIT '.$limitval);
            
            $data["total_rows"] = $config["total_rows"];
            
            $data['title'] = 'تذاكري | موقع وجهتنا';
            
            if($ticketOrder){
                $used = $this->main_model->getFullRequest('used','(p_id = '.strip_tags($this->input->post('p_id')).' AND num = '.strip_tags($this->input->post('t_id')).')');
                if($used){
                    $data['state11'] = 'التذكرة مُستخدمة';
                }else{
                    $data['state11'] = 'التذكرة مُحصلة وصالحة';
                }
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/cpay_view',$data);
            $this->load->view('admin/include/footer',$data);
            }else{
            $data['error'] = 'لايوجد لديك تذكرة مُحصلة بهذه البيانات';
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/cpay_view',$data);
            $this->load->view('admin/include/footer',$data);
            }
        }else{
                $this->tickets();
            }
        }
    }
    public function used(){
        if($this->main_model->is_admin_logged_in()){
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
            $this->form_validation->set_rules('p_id','رقم الطلبية','required',$rul);
            $this->form_validation->set_rules('t_id','رقم التذكرة','required',$rul);
            if($this->form_validation->run() == true){
    $ticketOrder = $this->main_model->getFullRequest('p_tickets','(id = '.strip_tags($this->input->post('p_id')).' AND num >= '.strip_tags($this->input->post('t_id')).')');
            $uId = $this->session->userdata('id');
            $config = array();
            $config["base_url"] = base_url() . "wjhatnacadmin/tickets/";

            $config["total_rows"] = $this->main_model->getAllData('p_tickets','count');

            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            if($page){
                $limitval = $page.','.$config["per_page"];
            }else{
                $limitval = $config["per_page"];
            }
            
            $data['orders'] = $this->main_model->getFullRequest('p_tickets','(state = 0 OR state = 1) ORDER BY `id` DESC LIMIT '.$limitval);
            
            $data["total_rows"] = $config["total_rows"];
            
            $data['title'] = 'تذاكري | موقع وجهتنا';
            
            if($ticketOrder){
                $used = $this->main_model->getFullRequest('used','(p_id = '.strip_tags($this->input->post('p_id')).' AND num = '.strip_tags($this->input->post('t_id')).')');
                if($used){
                    $data['state2'] = 'التذكرة مُستخدمة';
                }else{
                    $this->main_model->insertData('used',array(
                        'p_id' => strip_tags($this->input->post('p_id')),
                        'num' => strip_tags($this->input->post('t_id'))
                    ));
                    $this->main_model->alert('تم استخدام التذكرة رقم '.strip_tags($this->input->post('t_id')),'في الطلبية '.strip_tags($this->input->post('p_id')),$ticketOrder[0]->u_id);
                    $data['state2'] = 'تم استخدام التذكرة';
                }
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/cpay_view',$data);
            $this->load->view('admin/include/footer',$data);
            }else{
            $data['error'] = 'لايوجد لديك تذكرة مُحصلة بهذه البيانات';
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/cpay_view',$data);
            $this->load->view('admin/include/footer',$data);
            }
                }else{
                $this->tickets();
            }
        }
    }
    public function bankUp(){
        if($this->main_model->is_admin_logged_in()){
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
            $this->form_validation->set_rules('p_id','كود الطلبية','required|is_natural_no_zero');
            if($this->form_validation->run()){
            $checkTicket = $this->main_model->getFullRequest('p_tickets','id = '.$this->input->post('p_id'));
            if(!$checkTicket){
                redirect(base_url().'wjhatnacadmin/tickets');
            }else{
                $this->main_model->update('p_tickets','id',strip_tags($this->input->post('p_id')),array(
                    'state' => 1,
                    'admin' => 1
                ));
                $this->main_model->alert('تم تحصيل الطلبية رقم '.strip_tags($this->input->post('p_id')),'ويمكنك تحميل التذاكر من لوحة التحكم الخاصة بك',$checkTicket[0]->s_id);
                $this->main_model->alert('تم تحصيل الطلبية رقم '.strip_tags($this->input->post('p_id')),'ويمكنك تحميل التذاكر من لوحة التحكم الخاصة بك',$checkTicket[0]->u_id);
                $uId = $this->session->userdata('id');
            $config = array();
            $config["base_url"] = base_url() . "users/tickets/";

            $config["total_rows"] = $this->main_model->getAllData('p_tickets','count');

            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            if($page){
                $limitval = $page.','.$config["per_page"];
            }else{
                $limitval = $config["per_page"];
            }
            
            $data['orders'] = $this->main_model->getFullRequest('p_tickets','(state = 0 OR state = 1) ORDER BY `id` DESC LIMIT '.$limitval);
            
            $data["total_rows"] = $config["total_rows"];
            
            $data['state'] = 1;
            $data['title'] = 'تذاكري | موقع وجهتنا';
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/cpay_view',$data);
            $this->load->view('admin/include/footer',$data);
            }
            }else{
                $this->tickets();
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    public function userSearch()
	{
        if(!$this->main_model->is_admin_logged_in()){
            // Redirect to profile
            redirect(base_url().'wjhatnacadmin/login');
        }
        $data['title'] = 'البحث عن الأعضاء';
        $data['links'] = '';
        $data['records'] = $this->main_model->search('users',array(),'username',$this->input->get('search_user'));
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/users_view',$data);
            $this->load->view('admin/include/footer',$data);
    }
    public function allUsers()
	{
        if(!$this->main_model->is_admin_logged_in()){
            // Redirect to profile
            redirect(base_url().'wjhatnacadmin/login');
        }
        // URL :- http://localhost/ci_main/
            $data['title'] = 'وجهتنا | الصفحة الرئيسية';
            $config = array();

            $config["base_url"] = base_url() . "wjhatnacadmin/allUsers/";

            $config["total_rows"] = $this->main_model->record_count('','users');

            $config["per_page"] = 20;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            $data['records'] = $this->main_model->getAllDataAdv('users','type','DESC','','',$config["per_page"],$page,'','');
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/users_view',$data);
            $this->load->view('admin/include/footer',$data);
	}
    public function login(){
        if($this->main_model->is_admin_logged_in()){
            // Redirect to profile
            redirect(base_url().'wjhatnacadmin/');
        }else{
        $data['title'] = 'دخول في لوحة تحكم موقع وجهتنا - موقع وجهتنا';
        //echo urldecode($this->uri->segment(2)); Arabic letters Function in url
        $this->load->view('admin/login_view',$data);
        }
    }
            public function loginCheck()
	{
            if($this->main_model->is_admin_logged_in()){
                // Redirect to profile
            redirect(base_url().'wjhatnacadmin/');
            }else{
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'is_unique'     => '%s مسجل لدينا بالفعل',
                'matches'     => 'يجب عليك إدخال %s .',
                'integer'     => 'يجب عليك إدخال %s .',
                'valid_email'     => 'يجب عليك إدخال %s صحيح.'
            );
        $this->form_validation->set_rules('email','البريد الالكتروني','required|valid_email',$rul);
        $this->form_validation->set_rules('password','كلمة السر','required',$rul);
        // Check if val. true
        if($this->form_validation->run() == true){
            $email=strip_tags($this->input->post('email'));
            $password=strip_tags($this->input->post('password'));
                $records = $this->main_model->getByData('admins','email',$email);
                if($records == TRUE){
                foreach ($records as $row){
                    $password_f = $row->password;
                    $email_f = $row->email;
                    if($password == $this->encryption->decrypt($password_f) and $email == $email_f){
                        $row_arr = (array) $row;
                        $this->session->set_userdata($row_arr);
                        redirect(base_url().'wjhatnacadmin/');
                    }  else {
                        redirect(base_url().'wjhatnacadmin/login/wrong');
                    }
                }
        }else {
                redirect(base_url().'wjhatnacadmin/login/wrong');
            }
            }  else {
                $this->login();
            }
            }
        }
    public function logout(){
        if($this->main_model->is_admin_logged_in()){
            $l_logout = (array) $this->main_model->is_admin_logged_in(1)[0];
            $this->main_model->update('users','id',$l_logout['id'],array(
                'l_logout'=>$this->main_model->dateTime('date').' '.$this->main_model->dateTime('time')
                 ));
            $this->session->sess_destroy();
            // Remove local Facebook session
            $this->facebook->destroy_session();
            // Remove user data from session
            $this->session->unset_userdata('userData');
            redirect(base_url());
            }else{
            $this->session->sess_destroy();
            // Remove local Facebook session
            $this->facebook->destroy_session();
            // Remove user data from session
            $this->session->unset_userdata('userData');
            redirect(base_url());
            }
        }
    public function addTag(){
        if($this->main_model->is_admin_logged_in()){
            $data['title'] = 'لوحة التحكم | موقع وجهتنا';
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $data['ftags'] = $this->main_model->getAllDataCond('tags','state',2,'c_tag',NULL);
            $data['pages'] = $this->main_model->getAllDataCond('tags','state',3,'c_tag',NULL);
            $data['blog'] = $this->main_model->getAllDataCond('tags','state',5,'c_tag',NULL);
            $this->load->view('admin/addTag_view',$data);
        }else{
            redirect(base_url());
            }
    }
    public function addTagCheck(){
        if($this->main_model->is_admin_logged_in()){
            $data['title'] = 'لوحة التحكم | موقع وجهتنا';
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'is_unique'     => '%s مسجل لدينا بالفعل',
                'matches'     => 'يجب عليك إدخال %s .',
                'integer'     => 'يجب عليك إدخال %s .',
                'valid_email'     => 'يجب عليك إدخال %s صحيح.'
            );
        $this->form_validation->set_rules('tag','اسم التصنيف','required',$rul);
        if($this->input->post('type') == 1){
            if($this->input->post('cat') == 0){
                $this->form_validation->set_rules('events','التصنيف الأساسي','required',$rul);
                $c_tag = $this->input->post('events');
            }elseif($this->input->post('cat') == 2){
                $this->form_validation->set_rules('fest','التصنيف الأساسي','required',$rul);
                $c_tag = $this->input->post('fest');
            }elseif($this->input->post('cat') == 3){
                $this->form_validation->set_rules('pages','التصنيف الأساسي','required',$rul);
                $c_tag = $this->input->post('pages');
            }elseif($this->input->post('cat') == 5){
                $this->form_validation->set_rules('blog','التصنيف الأساسي','required',$rul);
                $c_tag = $this->input->post('blog');
            }else{
                $c_tag = NULL;
            }
        }else{
                $c_tag = NULL;
            }
        // Check if val. true
        if($this->form_validation->run() == true){
            $this->main_model->insertData('tags',array(
                'tag'=>$this->input->post('tag'),
                'state'=>$this->input->post('cat'),
                'c_tag'=>$c_tag
            ));
            // Success
            $data['state'] = 1;
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $data['ftags'] = $this->main_model->getAllDataCond('tags','state',2,'c_tag',NULL);
            $data['pages'] = $this->main_model->getAllDataCond('tags','state',3,'c_tag',NULL);
            $data['blog'] = $this->main_model->getAllDataCond('tags','state',5,'c_tag',NULL);
            $this->load->view('admin/addTag_view',$data);
        }else{
            $this->addTag();
        }
            
        }else{
            redirect(base_url().'wjhatnacadmin/login');
        }
    }
    function publish(){
        if($this->main_model->is_admin_logged_in()){
            $item = $this->main_model->getByData('items','id',$this->uri->segment(3));
            if($item){
                $this->main_model->update('items','id',$item[0]->id,array(
                            'state' => 1
                        ));
                $itemLink = base_url().'i/'.str_replace(' ','-',$item[0]->title).'/'.$item[0]->id.'/';
                $this->main_model->alert('تم نشر موضوعك : <a target="_blank" href="'.$itemLink.'">'.$item[0]->title.'</a>','تم نشر موضوعك ويمكنك معاينته',$item[0]->u_id);
                        redirect(base_url().'wjhatnacadmin/'.$this->uri->segment(4));
            }else{
                redirect(base_url().'404/');
            }
        }
    }
    function creds(){
        if($this->main_model->is_admin_logged_in()){
            $user = $this->main_model->getByData('users','id',$this->uri->segment(3));
            if($user){
                if($this->uri->segment(4) == 0){
                    $this->main_model->update('users','id',$user[0]->id,array(
                        'cred' => NULL,
                        'type' => 0
                    ));
                    redirect(base_url().'wjhatnacadmin/allUsers');
                }elseif($this->uri->segment(4) == 1){
                    $creds = explode(',',$user[0]->cred);
                    if(in_array('events',$creds) && $user[0]->type == 1){
                        redirect(base_url().'wjhatnacadmin/allUsers');
                    }else{
                        if(in_array('bank',$creds)){
                            $bank = ',bank';
                        }else{
                            $bank = '';
                        }
                        $this->main_model->update('users','id',$user[0]->id,array(
                            'cred' => 'events,tickets,pages'.$bank,
                            'type' => 1
                        ));
                        $this->main_model->alert('تمت ترقية حسابك إلى منظم فعاليات','يُمكنك الان إضافة صفحات وفعاليات وتذاكر بها',$user[0]->id);
                        redirect(base_url().'wjhatnacadmin/allUsers');
                    }
                }elseif($this->uri->segment(4) == 2){
                    $creds = explode(',',$user[0]->cred);
                    if(in_array('pages',$creds) && $user[0]->type == 2){
                        redirect(base_url().'wjhatnacadmin/allUsers');
                    }else{
                        if(in_array('bank',$creds)){
                            $bank = ',bank';
                        }else{
                            $bank = '';
                        }
                        $this->main_model->update('users','id',$user[0]->id,array(
                            'cred' => 'events,tickets,pages,promos'.$bank,
                            'type' => 2
                        ));
                        $this->main_model->alert('تمت ترقية حسابك إلى صاحب عروض ترويجية','يُمكنك الان إضافة صفحات وفعاليات وعروض ترويجية وتذاكر بها',$user[0]->id);
                        redirect(base_url().'wjhatnacadmin/allUsers');
                    }
                }elseif($this->uri->segment(4) == 3){
                    $creds = explode(',',$user[0]->cred);
                    if(in_array('bank',$creds) && $user[0]->type == 2){
                        redirect(base_url().'wjhatnacadmin/allUsers');
                    }else{
                        $this->main_model->update('users','id',$user[0]->id,array(
                            'cred' => $user[0]->cred.',bank',
                            'rcred' => null,
                        ));
                        $this->main_model->alert('تم السماح لك بتحصيل التذاكر بنفسك','يُمكنك الان طلبياتك دون الحاجة لإدارة الموقع',$user[0]->id);
                        redirect(base_url().'wjhatnacadmin/allUsers');
                    }
                }else{
                    redirect(base_url().'404/');
                    }
            }else{
            redirect(base_url().'404/');
            }
        }else{
            redirect(base_url().'wjhatnacadmin/login');
        }
    }
    public function events(){
            $data['title'] = 'وجهتنا | الفعاليات والعروض';
            $config = array();
            $config["base_url"] = base_url() . "wjhatnacadmin/events/";

            $config["total_rows"] = $this->main_model->getFullRequest('items','type = 0','count');

            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            $data['events'] = $this->main_model->getAllDataAdv('items','state','ASC','type',0,$config["per_page"],$page,'','');
            $data["total_rows"] = $config["total_rows"];
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $this->load->view('admin/include/header',$data);
            $this->load->view('discover_view',$data);
            $this->load->view('admin/include/footer',$data);
    }
    public function promos(){
            $data['title'] = 'وجهتنا | الفعاليات والعروض';
            $config = array();
            $config["base_url"] = base_url() . "wjhatnacadmin/promos/";

            $config["total_rows"] = $this->main_model->getFullRequest('items','type = 1','count');

            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            $data['events'] = $this->main_model->getAllDataAdv('items','state','ASC','type',1,$config["per_page"],$page,'','');
            $data["total_rows"] = $config["total_rows"];
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',2,'c_tag',NULL);
            $this->load->view('admin/include/header',$data);
            $this->load->view('discover_view',$data);
            $this->load->view('admin/include/footer',$data);
    }
    public function delete(){
        if($this->main_model->is_admin_logged_in()){
            $tables = array('tickets','items','pages','tags','users');
            if(in_array($this->uri->segment(3),$tables)){
                $table = $this->uri->segment(3);
            }else{
                redirect(base_url().'404/');
            }
            $data['item'] = $this->main_model->getByData($table,'id',$this->uri->segment(4));
            $reUrl = explode('/',$this->input->get('m'));
                if($reUrl[1] == 'promos' OR $reUrl[1] == 'events'){
                    $this->main_model->update($this->uri->segment(3),'id',$data['item'][0]->id,array('state'=>7));
                }else{
                    $this->main_model->deleteData($this->uri->segment(3),'id',$data['item'][0]->id);
                }
                redirect(base_url().$this->input->get('m'));
        }else{
            redirect(base_url().'404/');
        }
    }
    public function apps(){
        if($this->main_model->is_admin_logged_in()){
            $data['title'] = 'وجهتنا | روابط التطبيقات';
            $data['settings']= (array) $this->main_model->getByData('settings','id',1)[0];
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/apps_view',$data);
            $this->load->view('admin/include/footer',$data);
        }else{
            redirect(base_url().'404/');
        }
    }
    public function appsCheck(){
        if($this->main_model->is_admin_logged_in()){
            $data['title'] = 'لوحة التحكم | موقع وجهتنا';
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'is_unique'     => '%s مسجل لدينا بالفعل',
                'matches'     => 'يجب عليك إدخال %s .',
                'integer'     => 'يجب عليك إدخال %s .',
                'valid_email'     => 'يجب عليك إدخال %s صحيح.'
            );
            $this->form_validation->set_rules('appstore','تطبيق Apple','required',$rul);
            $this->form_validation->set_rules('playstore','تطبيق Google','required',$rul);
            $this->form_validation->set_rules('facebook','حساب الـ facebook','required',$rul);
            $this->form_validation->set_rules('twitter','حساب الـ twitter','required',$rul);
            $this->form_validation->set_rules('instagram','حساب الـ instagram','required',$rul);
        // Check if val. true
        if($this->form_validation->run() == true){
            $this->main_model->update('settings','id','1',array(
                'appstore'=>$this->input->post('appstore'),
                'playstore'=>$this->input->post('playstore'),
                'facebook'=>$this->input->post('facebook'),
                'twitter'=>$this->input->post('twitter'),
                'mobile'=>$this->input->post('mobile'),
                'email'=>$this->input->post('email'),
                'instagram'=>$this->input->post('instagram')
            ));
            // Success
            $data['state'] = 1;
            $data['settings']= (array) $this->main_model->getByData('settings','id',1)[0];
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/apps_view',$data);
            $this->load->view('admin/include/footer',$data);
        }else{
            $this->apps();
        }
            
        }else{
            redirect(base_url().'wjhatnacadmin/login');
        }
    }
    public function editPage(){
        if(is_numeric($this->uri->segment(3)) && $this->main_model->is_admin_logged_in()){
            $data['page'] = $this->main_model->getByData('site_pages','id',$this->uri->segment(3));
            if(!$data['page']){
                redirect(base_url().'wjhatnacadmin/login');
            }
            $data['title'] = 'تعديل صفحة';
            $this->load->view('admin/include/header',$data);
            $this->load->view('admin/editpage_view',$data);
            $this->load->view('admin/include/footer',$data);
        }else{
            redirect(base_url().'wjhatnacadmin/login');
        }
    }
    public function editPageCheck(){
        if(is_numeric($this->uri->segment(3)) && $this->main_model->is_admin_logged_in()){
            $data['page'] = $this->main_model->getByData('site_pages','id',$this->uri->segment(3));
            if(!$data['page']){
                redirect(base_url().'wjhatnacadmin/login');
            }
            $data['title'] = 'تعديل صفحة';
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'is_unique'     => '%s مسجل لدينا بالفعل',
                'matches'     => 'يجب عليك إدخال %s .',
                'integer'     => 'يجب عليك إدخال %s .',
                'valid_email'     => 'يجب عليك إدخال %s صحيح.'
            );
            $this->form_validation->set_rules('title','عنوان الصفحة','required',$rul);
            $this->form_validation->set_rules('content','محتوى الصفحة','required',$rul);
            if($this->form_validation->run()){
                $this->main_model->update('site_pages','id',$this->uri->segment(3),array(
                    'title' => strip_tags($this->input->post('title')),
                    'content' => $this->input->post('content')
                ));
                redirect(base_url().'wjhatnacadmin/editPage/'.$this->uri->segment(3).'/done');
            }else{
                $this->editPage();
            }
            }else{
            redirect(base_url().'wjhatnacadmin/login');
        }
    }
    public function edit(){
        if($this->main_model->is_admin_logged_in()){
            $tables = array('tickets','items','pages');
            if(in_array($this->uri->segment(3),$tables)){
                $table = $this->uri->segment(3);
            }else{
                redirect(base_url().'404/');
            }
            $data['item'] = $this->main_model->getAllDataCond($table,'id',$this->uri->segment(4),'u_id',0);
            if($data['item'][0]->u_id == 0){
                $data['title'] = 'تعديل | موقع وجهتنا';
                if($this->uri->segment(5) == 'blog'){
                    $data['mtags'] = $this->main_model->getAllDataCond('tags','state',5,'c_tag',NULL);
                    foreach($data['mtags'] as $mtag){
                        $data['subtags'] = $this->main_model->getFullRequest('tags','state = 5 AND c_tag = '.$mtag->id);
                        $msubtag[$mtag->id] = $data['subtags'];
                    }
                    $data['msubtag'] = $msubtag;
                    $this->load->view('blog/blogForm_view',$data);
                }else{
                        redirect(base_url().'404/');
                    }
                }
            }else{
                redirect(base_url().'404/');
            }
    }
    function addBlog(){
        if($this->main_model->is_admin_logged_in()){
                $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة تدوينة | موقع وجهتنا';
                $data['mtags'] = $this->main_model->getAllDataCond('tags','state',5,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','state = 5 AND c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
                $data['msubtag'] = $msubtag;
                $this->load->view('blog/blogForm_view',$data);
        }else{
            redirect(base_url().'wjhatnacadmin/login');
        }
    }
    function addBlogCheck(){
        if($this->main_model->is_admin_logged_in()){
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',5,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','state = 5 AND c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
            $data['msubtag'] = $msubtag;
            $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة فعالية | موقع وجهتنا';
            // Access User Data Securly
                $userId = 0;
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
                $data['mtags2'] = (array) $this->main_model->getAllDataCond('tags','state',5,'c_tag',NULL);
                $data['subtags2'] = (array) $this->main_model->getByData('tags','c_tag',$this->input->post('mtag'));
                if($this->input->post('mtag')){
                foreach($data['subtags2'] as $tag){
                    $stags[] = $tag->id;
                }}
                foreach($data['mtags2'] as $mtag){
                    $mtags[] = $mtag->id;
                }
            $this->form_validation->set_rules('title','عنوان التدوينة','required|alpha_numeric_spaces',$rul);
            $this->form_validation->set_rules('content','التدوينة','required|min_length[30]',$rul);
            $this->form_validation->set_rules('tags','الكلمات المفتاحية','required',$rul);
            $this->form_validation->set_rules('mtag','تصنيف رئيسي','required|in_list['.$this->main_model->list_rule($mtags).']',$rul);
            if($this->input->post('mtag')){
                $this->form_validation->set_rules('subtag','تصنيف فرعي','required|in_list['.$this->main_model->list_rule($stags).']',$rul);
                }
            // Check if validation true
        if($this->form_validation->run() == true){
            $data['p_title'] = $this->input->post('title');
            $data['p_content'] = $this->input->post('content');
            $data['p_tags'] = $this->input->post('tags');
            $data['p_mtag'] = $this->input->post('mtag');
            $data['p_subtag'] = $this->input->post('subtag');
            // Accepted Validation
                //Upload Images Settings
            
            // load library only once
                $this->load->library('upload');
            
                $config['upload_path']          = './vendor/uploads/images/';
                $config['allowed_types']        = 'jpeg|jpg|png';
                $config['max_size']             = 5000;
                $config['max_width']            = 5000;
                $config['max_height']           = 5000;
                $config['encrypt_name']           = TRUE;

                $this->upload->initialize($config);
// Loop For 4 Images
            $imgnum=1;
            define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
            define('PUBPATH',str_replace(SELF,'',FCPATH)); // added
                if ( ! $this->upload->do_upload('img'.$imgnum))
                {
                        $data['error'] = $this->upload->display_errors();
                    //If Statement For Changing Lang
                        if($data['error'] == '<p>The filetype you are attempting to upload is not allowed.</p>'){
                            $data['error']='امتداد الملف غير مسموح.';
                        }
                    // Upload Errors
                        $this->load->view('userarea/eventForm_view', $data);
                }
                else
                {
                    // Image
                        $data['img'.$imgnum] = array('upload_data' => $this->upload->data());
                    /// resize Image
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $data['img'.$imgnum]['upload_data']['full_path'];
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['width']         = 2400;
                        $config['height']       = 1200;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                             $this->image_lib->clear();
                        /// resize Image for thumb
                            $config_thumb['image_library'] = 'gd2';
                            $config_thumb['source_image'] = $data['img'.$imgnum]['upload_data']['full_path'];
                            $config_thumb['create_thumb'] = TRUE;
                            $config_thumb['maintain_ratio'] = TRUE;
                            $config_thumb['width']         = 810;
                            $config_thumb['height']       = 480;
                            $config_thumb['new_image'] = $data['img'.$imgnum]['upload_data']['file_path'] . "vthumb_" . $data['img'.$imgnum]['upload_data']['file_name'];
                            $this->image_lib->initialize($config_thumb);
                            $this->image_lib->resize();
                            $this->image_lib->clear();
                        $myFile = PUBPATH.'vendor/uploads/images/'.$data['img'.$imgnum]['upload_data']['file_name'];
                        unlink($myFile) or die("يوجد خطأ ما");
                        $userNewFile1 = explode('.',$data['img'.$imgnum]['upload_data']['file_name']);
                        $images[$imgnum] = $userNewFile1[0].'_thumb.'.$userNewFile1[1];                        
                $data['thumbnails'] = $images;
                ///*Insert Event
                $insertProduct = $this->main_model->insertData('items',array(
                    'title' => $data['p_title'],
                    'content' => $data['p_content'],
                    'tags' => $data['p_tags'],
                    'image' => $data['thumbnails'][1],
                    'mtag' => $data['p_mtag'],
                    'subtag' => $data['p_subtag'],
                    'tags' => $data['p_tags'],
                    'date' => $this->main_model->dateTime('current'),
                    'u_id'=>0,
                    'state' => 1,
                    'type' => 5
                ));
                $data['state'] = 1;
                $itemId = (array) $this->main_model->getAllDataCond('items','u_id',0,'image',$data['thumbnails'][1])[0];
                $this->load->view('blog/blogForm_view',$data);
                }
        }else{
            $this->load->view('blog/blogForm_view',$data);
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    public function editCheck(){
        if($this->main_model->is_admin_logged_in()){
            $tables = array('tickets','items','pages');
            if(in_array($this->uri->segment(3),$tables)){
                $table = $this->uri->segment(3);
            }else{
                echo 'here0';//redirect(base_url().'404/');
            }
            $data['item'] = $this->main_model->getAllDataCond($table,'id',$this->uri->segment(4),'u_id',0);
            if($data['item'][0]->u_id == 0){
                $data['title'] = 'تعديل | موقع وجهتنا';
                if($this->uri->segment(5) == 'blog'){
                    $data['mtags'] = $this->main_model->getAllDataCond('tags','state',5,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','state = 5 AND c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
                $data['msubtag'] = $msubtag;
                $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - تعديل تدوينة | موقع وجهتنا';
                    $userId = 0;
                ///*Form Validation
                $rul=array(
                    'required'      => 'يجب عليك إدخال %s .',
                    'min_length' => '%s قصير جداُ.',
                    'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                    'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                    'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                    'in_list' => 'برجاء اختيار %s موجود.'
                    );
                    $data['mtags2'] = (array) $this->main_model->getAllDataCond('tags','state',5,'c_tag',NULL);
                    $data['subtags2'] = (array) $this->main_model->getByData('tags','c_tag',$this->input->post('mtag'));
                    if($this->input->post('mtag')){
                    foreach($data['subtags2'] as $tag){
                        $stags[] = $tag->id;
                    }}
                    foreach($data['mtags2'] as $mtag){
                        $mtags[] = $mtag->id;
                    }
                $this->form_validation->set_rules('title','عنوان التدوينة','required|alpha_numeric_spaces',$rul);
                $this->form_validation->set_rules('content','وصف التدوينة','required|min_length[100]',$rul);
                $this->form_validation->set_rules('tags','الكلمات المفتاحية','required',$rul);
                $this->form_validation->set_rules('mtag','تصنيف رئيسي','required|in_list['.$this->main_model->list_rule($mtags).']',$rul);
                if($this->input->post('mtag')){
                    $this->form_validation->set_rules('subtag','تصنيف فرعي','required|in_list['.$this->main_model->list_rule($stags).']',$rul);
                }
                // Check if validation true
                    if($this->form_validation->run() == true){
                        $data['p_title'] = $this->input->post('title');
                        $data['p_content'] = $this->input->post('content');
                        $data['p_tags'] = $this->input->post('tags');
                        $data['p_mtag'] = $this->input->post('mtag');
                        $data['p_subtag'] = $this->input->post('subtag');
                        if($this->input->post('p_id')){
                            $data['p_id'] = $this->input->post('p_id');
                        }else{
                            $data['p_id'] = '';
                        }
                        // Accepted Validation
                            //Upload Images Settings
                        
                        // load library only once
                            $this->load->library('upload');
                        
                            $config['upload_path']          = './vendor/uploads/images/';
                            $config['allowed_types']        = 'jpeg|jpg|png';
                            $config['max_size']             = 5000;
                            $config['max_width']            = 5000;
                            $config['max_height']           = 5000;
                            $config['encrypt_name']           = TRUE;

                            $this->upload->initialize($config);
                        // Loop For 4 Images
                        $imgnum=1;
                        define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
                        define('PUBPATH',str_replace(SELF,'',FCPATH)); // added
                            if ( ! $this->upload->do_upload('img'.$imgnum))
                            {
                                    $data['error'] = $this->upload->display_errors();
                                //If Statement For Changing Lang
                                    if($data['error'] == '<p>The filetype you are attempting to upload is not allowed.</p>'){
                                        $data['error']='امتداد الملف غير مسموح.';
                                    }
                                    if($data['error'] == '<p>You did not select a file to upload.</p>'){
                                        ///*update Event
                                        $updateProduct = $this->main_model->update('items','id',$data['item'][0]->id,array(
                                            'title' => $data['p_title'],
                                            'content' => $data['p_content'],
                                            'mtag' => $data['p_mtag'],
                                            'tags' => $data['p_tags'],
                                            'subtag' => $data['p_subtag']
                                        ));
                                            redirect(base_url().'users/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/done');
                                    }
                                // Upload Errors
                                    $this->load->view('userarea/eventForm_view', $data);
                            }
                            else
                            {
                                // Image
                                    $data['img'.$imgnum] = array('upload_data' => $this->upload->data());
                                /// resize Image
                                    $config['image_library'] = 'gd2';
                                    $config['source_image'] = $data['img'.$imgnum]['upload_data']['full_path'];
                                    $config['create_thumb'] = TRUE;
                                    $config['maintain_ratio'] = TRUE;
                                    $config['width']         = 800;
                                    $config['height']       = 400;
                                    $this->image_lib->initialize($config);
                                    $this->image_lib->resize();
                                        $this->image_lib->clear();
                                    /// resize Image for thumb
                                        $config_thumb['image_library'] = 'gd2';
                                        $config_thumb['source_image'] = $data['img'.$imgnum]['upload_data']['full_path'];
                                        $config_thumb['create_thumb'] = TRUE;
                                        $config_thumb['maintain_ratio'] = TRUE;
                                        $config_thumb['width']         = 270;
                                        $config_thumb['height']       = 160;
                                        $config_thumb['new_image'] = $data['img'.$imgnum]['upload_data']['file_path'] . "vthumb_" . $data['img'.$imgnum]['upload_data']['file_name'];
                                        $this->image_lib->initialize($config_thumb);
                                        $this->image_lib->resize();
                                        $this->image_lib->clear();
                                    $myFile = PUBPATH.'vendor/uploads/images/'.$data['img'.$imgnum]['upload_data']['file_name'];
                                    unlink($myFile) or die("يوجد خطأ ما");
                                    $userNewFile1 = explode('.',$data['img'.$imgnum]['upload_data']['file_name']);
                                    $images[$imgnum] = $userNewFile1[0].'_thumb.'.$userNewFile1[1];                        
                            $data['thumbnails'] = $images;
                            $myFile2 = PUBPATH.'vendor/uploads/images/'.$data['item'][0]->image;
                            unlink($myFile2) or die("يوجد خطأ ما");
                            $myFile3 = PUBPATH.'vendor/uploads/images/'.$this->main_model->vthumb($data['item'][0]->image);
                            unlink($myFile3) or die("يوجد خطأ ما");
                            ///*update Event
                            $updateProduct = $this->main_model->update('items','id',$data['item'][0]->id,array(
                                'title' => $data['p_title'],
                                'content' => $data['p_content'],
                                'mtag' => $data['p_mtag'],
                                'tags' => $data['p_tags'],
                                'subtag' => $data['p_subtag'],
                                'image' => $data['thumbnails'][1]
                            ));
                                redirect(base_url().'wjhatnacadmin/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/done');
                            }
                        }else{
                            $this->load->view('blog/blogForm_view',$data);
                            }
            }else{
                redirect(base_url().'404/');
            }
        }else{
            redirect(base_url().'404/');
        }
    }else{
        redirect(base_url().'404/');
    }
    }
}
