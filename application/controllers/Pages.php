<?php

class Pages extends CI_Controller {

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
            $this->load->helper('cookie');
        }
         function notfound()
        {
           $this->load->view('notfound'); 
        }
	public function index()
	{
        // URL :- http://localhost/ci_main/
            $data['title'] = 'وجهتنا | الصفحة الرئيسية';
            $this->load->view('include/header',$data);
            $this->load->view('home_view',$data);
            $this->load->view('include/footer',$data);
	}
    public function spage(){
        if(is_numeric($this->uri->segment(3))){
            $data['page'] = $this->main_model->getByData('site_pages','id',$this->uri->segment(3));
            if(!$data['page']){
                redirect(base_url().'wjhatnacadmin/login');
            }
            $data['title'] = 'صفحة '.$data['page'][0]->title;
            $this->load->view('include/header',$data);
            $this->load->view('site_page_view',$data);
            $this->load->view('include/footer',$data);
        }else{
            redirect(base_url().'404/');
        }
    }
    public function search()
	{
        // URL :- http://localhost/ci_main/
            $data['title'] = 'وجهتنا | البحث';
            if($this->uri->segment(3) == 'promos'){
                $type = 1;
            }else{
                $type = 0;
            }
            if($this->input->get('search_for')){
            $data['search'] = $this->main_model->search('items','type = '.$type.' AND state = 1','title',$this->input->get('search_for'));
            }else{
                $data['search'] = 0;
            }
            $this->load->view('include/header',$data);
            $this->load->view('search_view',$data);
            $this->load->view('include/footer',$data);
	}
    public function searchCheck()
	{
        // URL :- http://localhost/ci_main/
            $data['title'] = 'وجهتنا | البحث';
            if($this->uri->segment(3) == 'promos'){
                $type = 1;
            }else{
                $type = 0;
            }
            if($this->input->get('search_for')){
            $data['search'] = $this->main_model->search('items','type = '.$type.' AND state = 1','title',$this->input->get('search_for'));
            }else{
                $data['search'] = 0;
            }
            $this->load->view('include/header',$data);
            $this->load->view('search_view',$data);
            $this->load->view('include/footer',$data);
	}
    public function promote(){
            $data['title'] = 'وجهتنا | الصفحة الترويج';
            $this->load->view('include/header',$data);
            $this->load->view('promote_view',$data);
            $this->load->view('include/footer',$data);
    }
    public function discover(){
            $data['title'] = 'وجهتنا | اكتشف';
            $config = array();
            $config["base_url"] = base_url() . "pages/discover/";
            if($this->uri->segment(3) == '' && !$this->input->post('search_latitude') && !$this->input->post('date')){
                delete_cookie('search_latitude'); 
                delete_cookie('search_longitude'); 
                delete_cookie('date'); 
                delete_cookie('search_for'); 
            }
            if(get_cookie('mtag') !== null){
                set_cookie(array(
                    'name'   => 'search_latitude',
                    'value'  => strip_tags($this->input->post('search_latitude')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'search_longitude',
                    'value'  => strip_tags($this->input->post('search_longitude')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'date',
                    'value'  => strip_tags($this->input->post('date')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'search_for',
                    'value'  => strip_tags($this->input->post('search_for')),
                    'expire' => time()+86500
                ));
                $data['search_latitude'] = strip_tags($this->input->post('search_latitude'));
                $data['search_longitude'] = strip_tags($this->input->post('search_longitude'));
                $data['date'] = strip_tags($this->input->post('date'));
                $data['search_for'] = strip_tags($this->input->post('search_for'));
                $data['mtag'] = strip_tags(get_cookie('mtag'));
                $mtagrul = ' AND mtag = '.$data['mtag'];
            }else{
                $mtagrul = '';
            }
            if(get_cookie('search_latitude')){
                $data['search_latitude'] = strip_tags(get_cookie('search_latitude'));
                $data['search_longitude'] = strip_tags(get_cookie('search_longitude'));
                $data['date'] = strip_tags(get_cookie('date'));
                $data['search_for'] = strip_tags(get_cookie('search_for'));
            }
            if($this->input->post('search_latitude')){
                set_cookie(array(
                    'name'   => 'search_latitude',
                    'value'  => strip_tags($this->input->post('search_latitude')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'search_longitude',
                    'value'  => strip_tags($this->input->post('search_longitude')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'date',
                    'value'  => strip_tags($this->input->post('date')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'search_for',
                    'value'  => strip_tags($this->input->post('search_for')),
                    'expire' => time()+86500
                ));
                $data['search_latitude'] = strip_tags($this->input->post('search_latitude'));
                $data['search_longitude'] = strip_tags($this->input->post('search_longitude'));
                $data['date'] = strip_tags($this->input->post('date'));
                $data['search_for'] = strip_tags($this->input->post('search_for'));
            }
            if($this->input->post('date')){
                set_cookie(array(
                    'name'   => 'date',
                    'value'  => strip_tags($this->input->post('date')),
                    'expire' => time()+86500
                ));
                $data['date'] = strip_tags($this->input->post('date'));
            }else{
                $data['date'] = '';
            }
            if(isset($data['date']) && $data['date'] !== ''){
                $s_date = explode(' ',$data['date']);
                $dateQ = " AND s_date like '%".$s_date[0]."%'";
            }else{
                $dateQ = '';
            }
            if($this->input->post('search_latitude') OR get_cookie('search_latitude') OR get_cookie('date') OR $this->input->post('date')){
                if(!is_numeric($data['search_latitude']) OR !is_numeric($data['search_latitude'])){
                    redirect(base_url().'404/');
                }
                if($this->input->post('search_latitude') OR get_cookie('search_latitude')){
                $items = $this->main_model->fullQuery('SELECT id,search_latitude,search_longitude FROM items WHERE state != 7 AND type != 5');
                if($items){
                foreach($items as $item){
                    $distance = $this->main_model->calculateDistance($data['search_latitude'],$data['search_longitude'],$item->search_latitude,$item->search_longitude,'K');
                    if($distance <= 50){
                        $ids[] = $item->id;
                    }
                }
                }
                    if(isset($ids)){
                        $inarea = ' AND id IN (' . implode(",", $ids) . ')';
                    }else{
                        $inarea = ' AND id IN (0)';
                    }
                }else{
                    $inarea = '';
                }
                $config["total_rows"] = $this->main_model->fullQuery('SELECT * FROM items WHERE (state = 1 AND type = 0)'.$mtagrul.$dateQ.$inarea,'count');
            }else{
                $inarea = '';
                $config["total_rows"] = $this->main_model->fullQuery('SELECT * FROM items WHERE (state = 1 AND type = 0)'.$mtagrul.$dateQ.$inarea,'count');
            }
        
            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            if($this->input->post('search_latitude') OR get_cookie('search_latitude') OR get_cookie('date') OR $this->input->post('date') OR get_cookie('mtag')){
                if($page){
                    $limit = $config["per_page"].','.$page;
                }else{
                    $limit = $config["per_page"];
                }
        $data['events'] = $this->main_model->fullQuery('SELECT * FROM items WHERE (state = 1 AND type = 0)'.$mtagrul.$dateQ.$inarea.' LIMIT '.$limit);
            }else{
                $data['events'] = $this->main_model->getAllDataAdv('items','id','DESC','state',1,$config["per_page"],$page,'type',0);
            }
        
            $data["total_rows"] = $config["total_rows"];
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $this->load->view('include/header',$data);
            $this->load->view('discover_view',$data);
            $this->load->view('include/footer',$data);
    }
    public function tag(){
        if($this->uri->segment(3) == 0){
            delete_cookie('mtag');
            redirect(base_url().'pages/'.$this->uri->segment(4));
        }else{
        set_cookie(array(
                    'name'   => 'mtag',
                    'value'  => $this->uri->segment(3),
                    'expire' => time()+86500
                ));
        redirect(base_url().'pages/'.$this->uri->segment(4));
        }
    }
    public function post(){
        $data['post'] = $this->main_model->getAllDataCond('items','type',5,'id',$this->uri->segment(4));
        $data['title'] = 'وجهتنا | '.$data['post'][0]->title;
        if(!$data['post']){
            redirect(base_url().'404/');
        }
        $this->load->view('include/header',$data);
        $this->load->view('blog/post_view',$data);
        $this->load->view('include/footer',$data);
    }
    public function promos(){
            $data['title'] = 'وجهتنا | اكتشف';
            $config = array();
            $config["base_url"] = base_url() . "pages/promos/";
            if($this->uri->segment(3) == '' && !$this->input->post('search_latitude') && !$this->input->post('date')){
                delete_cookie('search_latitude'); 
                delete_cookie('search_longitude'); 
                delete_cookie('date'); 
                delete_cookie('search_for'); 
            }
            if(get_cookie('mtag') !== null){
                set_cookie(array(
                    'name'   => 'search_latitude',
                    'value'  => strip_tags($this->input->post('search_latitude')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'search_longitude',
                    'value'  => strip_tags($this->input->post('search_longitude')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'date',
                    'value'  => strip_tags($this->input->post('date')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'search_for',
                    'value'  => strip_tags($this->input->post('search_for')),
                    'expire' => time()+86500
                ));
                $data['search_latitude'] = strip_tags($this->input->post('search_latitude'));
                $data['search_longitude'] = strip_tags($this->input->post('search_longitude'));
                $data['date'] = strip_tags($this->input->post('date'));
                $data['search_for'] = strip_tags($this->input->post('search_for'));
                $data['mtag'] = strip_tags(get_cookie('mtag'));
                $mtagrul = ' AND mtag = '.$data['mtag'];
            }else{
                $mtagrul = '';
            }
            if(get_cookie('search_latitude')){
                $data['search_latitude'] = strip_tags(get_cookie('search_latitude'));
                $data['search_longitude'] = strip_tags(get_cookie('search_longitude'));
                $data['date'] = strip_tags(get_cookie('date'));
                $data['search_for'] = strip_tags(get_cookie('search_for'));
            }
            if($this->input->post('search_latitude')){
                set_cookie(array(
                    'name'   => 'search_latitude',
                    'value'  => strip_tags($this->input->post('search_latitude')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'search_longitude',
                    'value'  => strip_tags($this->input->post('search_longitude')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'date',
                    'value'  => strip_tags($this->input->post('date')),
                    'expire' => time()+86500
                ));
                set_cookie(array(
                    'name'   => 'search_for',
                    'value'  => strip_tags($this->input->post('search_for')),
                    'expire' => time()+86500
                ));
                $data['search_latitude'] = strip_tags($this->input->post('search_latitude'));
                $data['search_longitude'] = strip_tags($this->input->post('search_longitude'));
                $data['date'] = strip_tags($this->input->post('date'));
                $data['search_for'] = strip_tags($this->input->post('search_for'));
            }
            if($this->input->post('date')){
                set_cookie(array(
                    'name'   => 'date',
                    'value'  => strip_tags($this->input->post('date')),
                    'expire' => time()+86500
                ));
                $data['date'] = strip_tags($this->input->post('date'));
            }else{
                $data['date'] = '';
            }
            if(isset($data['date']) && $data['date'] !== ''){
                $s_date = explode(' ',$data['date']);
                $dateQ = " AND s_date like '%".$s_date[0]."%'";
            }else{
                $dateQ = '';
            }
            if($this->input->post('search_latitude') OR get_cookie('search_latitude') OR get_cookie('date') OR $this->input->post('date')){
                if(!is_numeric($data['search_latitude']) OR !is_numeric($data['search_latitude'])){
                    redirect(base_url().'404/');
                }
                if($this->input->post('search_latitude') OR get_cookie('search_latitude')){
                $items = $this->main_model->fullQuery('SELECT id,search_latitude,search_longitude FROM items WHERE state != 7 AND type != 5');
                if($items){
                    foreach($items as $item){
                        $distance = $this->main_model->calculateDistance($data['search_latitude'],$data['search_longitude'],$item->search_latitude,$item->search_longitude,'K');
                        if($distance <= 50){
                            $ids[] = $item->id;
                        }
                    }
                }
                    if(isset($ids)){
                        $inarea = ' AND id IN (' . implode(",", $ids) . ')';
                    }else{
                        $inarea = ' AND id IN (0)';
                    }
                }else{
                    $inarea = '';
                }
                $config["total_rows"] = $this->main_model->fullQuery('SELECT * FROM items WHERE (state = 1 AND type = 1)'.$mtagrul.$dateQ.$inarea,'count');
            }else{
                $inarea = '';
                $config["total_rows"] = $this->main_model->fullQuery('SELECT * FROM items WHERE (state = 1 AND type = 1)'.$mtagrul.$dateQ.$inarea,'count');
            }
        
            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            if($this->input->post('search_latitude') OR get_cookie('search_latitude') OR get_cookie('date') OR get_cookie('mtag') OR $this->input->post('date')){
                if($page){
                    $limit = $config["per_page"].','.$page;
                }else{
                    $limit = $config["per_page"];
                }
        $data['events'] = $this->main_model->fullQuery('SELECT * FROM items WHERE (state = 1 AND type = 1)'.$mtagrul.$dateQ.$inarea.' LIMIT '.$limit);
            }else{
                $data['events'] = $this->main_model->getAllDataAdv('items','id','DESC','state',1,$config["per_page"],$page,'type',1);
            }
            $data["total_rows"] = $config["total_rows"];
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',2,'c_tag',NULL);
            $this->load->view('include/header',$data);
            $this->load->view('discover_view',$data);
            $this->load->view('include/footer',$data);
    }
    public function register(){
    if($this->main_model->is_logged_in()){
            // Redirect to profile
            redirect(base_url().'user/'.$this->session->userdata('username'));
        }else{
        $data['title'] = 'تسجيل حساب جديد في موقع وجهتنا - موقع وجهتنا';
        $this->load->helper('form');
        $data['countries'] = $this->main_model->getAllData('countries');
            // Get login URL
            $data['authURL'] =  $this->facebook->login_url();
            /*END FB REGISTER & LOGIN*/
        $this->load->view('include/header.php',$data);
        $cookieVal = get_cookie('co');
        if($cookieVal == 1 AND $this->uri->segment(2) == 'registerCheck'){
            set_cookie(array(
            'name'   => 'co',
            'value'  => '1',
            'expire' => time()+86500
        ));
            $this->load->view('registerco_view',$data);
        }elseif($this->uri->segment(2) == 'registerco'){
            set_cookie(array(
            'name'   => 'co',
            'value'  => '1',
            'expire' => time()+86500
        ));
            $this->load->view('registerco_view',$data);
        }else{
            set_cookie(array(
            'name'   => 'co',
            'value'  => '0',
            'expire' => time()+86500
        ));
            $this->load->view('register_view',$data);
        }
        $this->load->view('include/footer.php',$data);
    }
    }
    public function continueFBregistration(){
        // Check if user is logged in
        if($this->facebook->is_authenticated()){
            /*Start FB REGISTER & LOGIN*/
                    $userData = array();
        // Get user facebook profile details
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');

            // Preparing data for database insertion
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';;
            $userData['first_name']    = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
            $userData['last_name']    = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
            $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';
            $userData['gender']        = !empty($fbUser['gender'])?$fbUser['gender']:'';
            $userData['picture']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:'';
            $userData['link']        = !empty($fbUser['link'])?$fbUser['link']:'';
            $userData['fb_access_token'] = $this->session->userdata()['fb_access_token'];
            $userData['balance'] = 0;
            $userData['all_balance'] = 0;
            $userData['ip'] = $this->input->ip_address();
            $userData['date'] = $this->main_model->dateTime('date');
            $userData['l_logout'] = $this->main_model->dateTime('date').' '.$this->main_model->dateTime('time');
            $userData['state'] = 1;
            
            // Insert or update user data
            $userID = $this->main_model->checkUser($userData);
            // Check user data insert or update status
            if(!empty($userID)){
                $data['userData'] = $userData;
                $this->session->set_userdata('userData', $userData);
                // Get logout URL
                $data['logoutURL'] = $this->facebook->logout_url();
                $data['title'] = 'وجهتنا | إكمال بيانات الحساب';
                $this->load->helper('form');
                $data['countries'] = $this->main_model->getAllData('countries');
                $this->load->view('include/header',$data);
                $cookieVal = get_cookie('co');
                if($cookieVal == 1){
                    $this->load->view('completeco_view',$data);
                }else{
                    $this->load->view('complete_view',$data);
                }
                $this->load->view('include/footer',$data);
            }else{
               $data['userData'] = array();
                $this->register();
            }
        }else{
            $this->register();
        }
    }
    public function cFBreg(){
        $record = (array) $this->main_model->getByData('users','fb_access_token',$this->session->userdata('fb_access_token'))[0];
        if(isset($record['username'])){
            redirect(base_url().'user/'.$record['username']);
        }
        // Check if FB user is logged in
        if($this->facebook->is_authenticated()){
            
            /*Start FB REGISTER & LOGIN*/
                    $userData = array();
        // Get user facebook profile details
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');

            // Preparing data for database insertion
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';;
            $userData['first_name']    = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
            $userData['last_name']    = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
            $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';
            $userData['gender']        = !empty($fbUser['gender'])?$fbUser['gender']:'';
            $userData['picture']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:'';
            $userData['link']        = !empty($fbUser['link'])?$fbUser['link']:'';
            $userData['fb_access_token'] = $this->session->userdata()['fb_access_token'];
            $userData['balance'] = 0;
            $userData['all_balance'] = 0;
            $userData['ip'] = $this->input->ip_address();
            $userData['date'] = $this->main_model->dateTime('date');
            $userData['l_logout'] = $this->main_model->dateTime('date').' '.$this->main_model->dateTime('time');
            $userData['state'] = 1;
            
            // Insert or update user data
            $userID = $this->main_model->checkUser($userData);
            // Check user data insert or update status
            if(!empty($userID)){
                $data['userData'] = $userData;
                $this->session->set_userdata('userData', $userData);
                // Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'is_unique'     => '%s مسجل لدينا بالفعل',
                'matches'     => 'يجب عليك إدخال %s .',
                'integer'     => 'يجب عليك إدخال %s .',
                'valid_email'     => 'يجب عليك إدخال %s صحيح.',
                'alpha_numeric' => 'في %s يجب إدخال أرقام وحروف انجليزية فقط',
                'min_length' => 'يجب أن لا يقل {field} عن عدد {param} حروف',
                'numeric' => 'يجب أن يتكون %s من أرقام فقط',
                'alpha' => 'يجب أن يتكون %s من حروف فقط'
            );
        $this->form_validation->set_rules('username','اسم المستخدم','required|alpha_numeric|is_unique[users.username]',$rul);
        $this->form_validation->set_rules('mobile','رقم الهاتف','required|numeric',$rul);
        $this->form_validation->set_rules('country','الدولة','required|alpha',$rul);
        $this->form_validation->set_rules('address','العنوان','required',$rul);
        if(strip_tags($this->input->post('type')) == '1' OR strip_tags($this->input->post('type')) == '2'){
            $this->form_validation->set_rules('c_name','اسم الشركة/المؤسسة','required',$rul);
        }
                // Check if validation true
        if($this->form_validation->run() == true){
                $user=array(
                        'username' => strip_tags($this->input->post('username')),
                        'mobile' => strip_tags($this->input->post('mobile')),
                        'country' => strip_tags($this->input->post('country')),
                        'address' => strip_tags($this->input->post('address'))
                    );
                    if(strip_tags($this->input->post('type')) == '1' OR strip_tags($this->input->post('type')) == '2'){
                        $user['c_name'] = strip_tags($this->input->post('c_name'));
                    }
                    if(strip_tags($this->input->post('type')) !== '0' AND strip_tags($this->input->post('type')) !== '1' AND strip_tags($this->input->post('type')) !== '2'){
                        $user['type'] = '0';
                    }else{
                        $user['type'] = $this->input->post('type');
                    }
                //Update User
                $update = $this->main_model->update('users','oauth_uid',$userData['oauth_uid'],$user);
                if($update){
                    $userd = $this->main_model->getByData('users','username',$user['username']);
                    $userd2 = (array) $userd[0];
                    $this->session->set_userdata($userd2);
                    $ettings = (array) $this->main_model->getByData('settings','id',1)[0];
                    $this->email->set_mailtype("html");
            $this->email->from('support@wjhatna.com', 'منصة وجهتنا');
            $this->email->to(strip_tags($this->input->post('email')));
            $this->email->cc('support@wjhatna.com');
            $this->email->bcc('support@wjhatna.com');
            
            $this->email->subject('موقع وجهتنا | الرسالة الترحيبية');
            $this->email->message('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <style type="text/css">
                @font-face {
            font-family: "Droid Arabic Kufi";
            src: url("'.base_url().'vendor/fonts/Droid Arabic Kufi.ttf");
            }
                    body{
                    font-family: "Droid Arabic Kufi",sans-serif;
                    }
                </style>
            </head><body><div style="
                width: 90%;
                margin: auto;
                padding: 25px;
                border-bottom: 1px solid #ddd;
                text-align: left;
                height: 30px;
                font-size: 18px;
            ">
            <img src="'.base_url().'vendor/images/logo.png" style="
                width: 140px;
                margin: auto;
                display: block;
            ">

                <div style="
                float: right;
                width: 100%;
                text-align: right;
                direction: rtl;
                clear: both;
            ">
                <h4>
                أهلاً '.$userd2['username'].'
                <br />
                مرحبا بك على منصة وجهتنا ، نشكرك على التسجيل لبيع التذاكر والعروض الترويجة عبر الإنترنت باستخدام WJHATNA
<br />
نحن متحمسون لأن تكون التذاكر بسيطة ومنخفضة التكلفة قدر الإمكان - بما في ذلك خدمة العملاء الممتازة وجميع الميزات التي تحتاجها لإعدادك للنجاح كمعيار.
<br />
للرجوع اليها ، يمكنك تسجيل الدخول هنا والبريد الإلكتروني لتسجيل الدخول الخاص بك هو:
'.$userd2['email'].'
<br />
كلمة موجزة عن التسعير ...
<br />
سيتم تحويلك إلى خطة الدفع الفوري.
يمكنك الانتقال في أي وقت إلى واحدة من خططنا الشهرية والتي غالباً ما تكون قيمة أفضل.
إذا كنت مؤسسة خيرية ، فيرجى الاتصال بدعم العملاء لتفعيل خصم 20٪.
للحصول على الخطة الشهرية المناسبة لك تواصل معنا 
<br />
إذا كنت بحاجة إلى أي مساعدة للبدء ، تحقق من موقع المساعدة للحصول على مقالات مفيدة ، أو قم بالرد على رسالة البريد الإلكتروني هذه إذا كانت لديك أي أسئلة .
<br />
أتمنى لك كل خير،
<br />
فريق وجهتنا
                </h4>
                <div style="
                    width: 250px;
                    margin: auto;
                    display: block;
                ">
                    <a href="'.$ettings['facebook'].'"><img style="width:70px;float:right;" src="'.base_url().'vendor/images/fb.png'.'"></a>
                    <a href="'.$ettings['twitter'].'"><img style="width:70px;float:right;" src="'.base_url().'vendor/images/tw.png'.'"></a>
                    <a href="'.$ettings['instagram'].'"><img style="width:70px;float:right;" src="'.base_url().'vendor/images/in.png'.'"></a>
                </div>
            </div>
            </div><style>
            h3#msg_ti {
                text-align: center;
                font-size: 30px;
                background: #292929;
                color: #fff;
                font-family: tahoma;
            }
            .container{
            width:250px;
            margin:auto;
            display:block;
            text-align:center;
            }
            </style>
            </body></html>');
            
            // Mail it
            $this->email->send();
                    // Redirect to profile
                    redirect(base_url().'user/'.$this->session->userdata('username'));
                }else{
                    // Get logout URL
                    $data['logoutURL'] = $this->facebook->logout_url();
                    $data['title'] = 'وجهتنا | إكمال بيانات الحساب';
                    $this->load->helper('form');
                    $data['countries'] = $this->main_model->getAllData('countries');
                    $data['error'] = 'يوجد خطأ ما برجاء المحاولة مرة أخرى.';
                    $this->load->view('include/header',$data);
                    $this->load->view('complete_view',$data);
                    $this->load->view('include/footer',$data);
                }
                }else{
                    $this->register();
                }
            }else{
               $data['userData'] = array();
                $this->register();
            }
        }else{
            $this->register();
        }
    }
    public function registerCheck(){
            $now = new DateTime();
            $now->setTimezone(new DateTimezone('Africa/Cairo'));
            $dateNow = (array) $now;
            // Declare and define two dates 
            $currentDTime = explode('.',$dateNow['date']);
        if($this->main_model->is_logged_in()){
            // Redirect to profile
            redirect(base_url().'user/'.$this->session->userdata('username'));
        }else{

        // Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'is_unique'     => '%s مسجل لدينا بالفعل',
                'matches'     => 'يجب عليك إدخال %s .',
                'integer'     => 'يجب عليك إدخال %s .',
                'valid_email'     => 'يجب عليك إدخال %s صحيح.',
                'alpha_numeric' => 'في %s يجب إدخال أرقام وحروف انجليزية فقط',
                'min_length' => 'يجب أن لا يقل {field} عن عدد {param} حروف',
                'numeric' => 'يجب أن يتكون %s من أرقام فقط',
                'alpha' => 'يجب أن يتكون %s من حروف فقط'
            );
        $this->form_validation->set_rules('username','اسم المستخدم','required|alpha_numeric|is_unique[users.username]',$rul);
        $this->form_validation->set_rules('email','البريد الالكتروني','required|valid_email|is_unique[users.email]',$rul);
        $this->form_validation->set_rules('password','كلمة السر','required',$rul);
        $this->form_validation->set_rules('passwordConf','تأكيد كلمة السر صحيحة','required|matches[password]',$rul);
        $this->form_validation->set_rules('mobile','رقم الهاتف','required|numeric',$rul);
        $this->form_validation->set_rules('country','الدولة','required|alpha',$rul);
        $this->form_validation->set_rules('address','العنوان','required',$rul);
        if(strip_tags($this->input->post('type')) == '1' OR strip_tags($this->input->post('type')) == '2'){
            $this->form_validation->set_rules('c_name','اسم الشركة/المؤسسة','required',$rul);
        }
                // Check if validation true
        if($this->form_validation->run() == true){
        $user=array(
                'username' => strip_tags($this->input->post('username')),
                'email' => strip_tags($this->input->post('email')),
                'password' => $this->encryption->encrypt($this->input->post('password')),
                'mobile' => strip_tags($this->input->post('mobile')),
                'country' => strip_tags($this->input->post('country')),
                'address' => strip_tags($this->input->post('address')),
                'balance' => 0,
                'all_balance' => 0,
                'ip' => $this->input->ip_address(),
                'picture' => '',
                'date' => $this->main_model->dateTime('date'),
                'l_logout' => $this->main_model->dateTime('date').' '.$this->main_model->dateTime('time'),
                'state' => 0
            );
            if(strip_tags($this->input->post('type')) == '1' OR strip_tags($this->input->post('type')) == '2'){
                $user['c_name'] = strip_tags($this->input->post('c_name'));
            }
            if(strip_tags($this->input->post('type')) !== '0' AND strip_tags($this->input->post('type')) !== '1' AND strip_tags($this->input->post('type')) !== '2'){
                $user['type'] = '0';
            }else{
                $user['type'] = $this->input->post('type');
            }
            if($user['type'] == '1' OR $user['type'] == '2'){
                $user['first_name'] = strip_tags($this->input->post('firstname'));
                $user['last_name'] = strip_tags($this->input->post('lastname'));
            }
            $this->main_model->insertData('users',$user);
            $userd = $this->main_model->getByData('users','username',$user['username']);
            $userd2 = (array) $userd[0];
            $this->session->set_userdata($userd2);
            $random_code=$this->main_model->random_number();
            $this->main_model->insertData('users_activation',array(
                'u_id' => $userd2['id'],
                'code' => $random_code,
                'time' => $currentDTime[0]
            ));
            $ettings = (array) $this->main_model->getByData('settings','id',1)[0];
            // Here I`ll Send the message.
            // Multiple recipients
            $to = strip_tags($this->input->post('email')); // note the comma

            // Subject
            $subject = 'تأكيد حسابك في موقع وجهتنا';

            // Message
            $message = '
            <html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <style type="text/css">
                @font-face {
            font-family: "Droid Arabic Kufi";
            src: url("'.base_url().'vendor/fonts/Droid Arabic Kufi.ttf");
            }
                    body{
                    font-family: "Droid Arabic Kufi",sans-serif;
                    }
                </style>
            </head><body><div style="
                width: 90%;
                margin: auto;
                padding: 25px;
                border-bottom: 1px solid #ddd;
                text-align: left;
                height: 30px;
                font-size: 18px;
            ">
            <img src="'.base_url().'vendor/images/logo.png" style="
                width: 140px;
                margin: auto;
                display: block;
            ">

                <div style="
                float: right;
                width: 100%;
                text-align: right;
                direction: rtl;
                clear: both;
            ">
                <h4>
                أهلاً '.strip_tags($this->input->post('username')).'
                <br />
                شكراً على تسجيلك في موقع وجهتنا يجب عليك تأكيد حسابك من الرابط التالي:
                </h4>
                <h5 style="
                padding: 10px;
                background: #ddd;
                text-align: center;
                border: 1px solid #b5b5b5;
            "><a href="'.base_url().'activate/'.$random_code.'" target="_blank">'.base_url().'activate/'.$random_code.'</a></h5>
            <div style="
                    width: 250px;
                    margin: auto;
                    display: block;
                ">
                    <a href="'.$ettings['facebook'].'"><img style="width:70px;float:right;" src="'.base_url().'vendor/images/fb.png'.'"></a>
                    <a href="'.$ettings['twitter'].'"><img style="width:70px;float:right;" src="'.base_url().'vendor/images/tw.png'.'"></a>
                    <a href="'.$ettings['instagram'].'"><img style="width:70px;float:right;" src="'.base_url().'vendor/images/in.png'.'"></a>
                </div>
            </div>
            </div><style>
            h3#msg_ti {
                text-align: center;
                font-size: 30px;
                background: #292929;
                color: #fff;
                font-family: tahoma;
            }
            </style>
            </body></html>
            ';
            $this->load->library('email');
            $this->email->set_mailtype("html");
            $this->email->from('support@wjhatna.com', 'منصة وجهتنا');
            $this->email->to(strip_tags($this->input->post('email')));
            $this->email->cc('support@wjhatna.com');
            $this->email->bcc('support@wjhatna.com');

            $this->email->subject($subject);
            $this->email->message($message);
            
            // Mail it
            $this->email->send();
            
            $this->email->set_mailtype("html");
            $this->email->from('support@wjhatna.com', 'منصة وجهتنا');
            $this->email->to(strip_tags($this->input->post('email')));
            $this->email->cc('support@wjhatna.com');
            $this->email->bcc('support@wjhatna.com');
            
            $this->email->subject('موقع وجهتنا | الرسالة الترحيبية');
            $this->email->message('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <style type="text/css">
                @font-face {
            font-family: "Droid Arabic Kufi";
            src: url("'.base_url().'vendor/fonts/Droid Arabic Kufi.ttf");
            }
                    body{
                    font-family: "Droid Arabic Kufi",sans-serif;
                    }
                </style>
            </head><body><div style="
                width: 90%;
                margin: auto;
                padding: 25px;
                border-bottom: 1px solid #ddd;
                text-align: left;
                height: 30px;
                font-size: 18px;
            ">
            <img src="'.base_url().'vendor/images/logo.png" style="
                width: 140px;
                margin: auto;
                display: block;
            ">

                <div style="
                float: right;
                width: 100%;
                text-align: right;
                direction: rtl;
                clear: both;
            ">
                <h4>
                أهلاً '.strip_tags($this->input->post('username')).'
                <br />
                مرحبا بك على منصة وجهتنا ، نشكرك على التسجيل لبيع التذاكر والعروض الترويجة عبر الإنترنت باستخدام WJHATNA
<br />
نحن متحمسون لأن تكون التذاكر بسيطة ومنخفضة التكلفة قدر الإمكان - بما في ذلك خدمة العملاء الممتازة وجميع الميزات التي تحتاجها لإعدادك للنجاح كمعيار.
<br />
للرجوع اليها ، يمكنك تسجيل الدخول هنا والبريد الإلكتروني لتسجيل الدخول الخاص بك هو:
'.strip_tags($this->input->post('email')).'
<br />
كلمة موجزة عن التسعير ...
<br />
سيتم تحويلك إلى خطة الدفع الفوري.
يمكنك الانتقال في أي وقت إلى واحدة من خططنا الشهرية والتي غالباً ما تكون قيمة أفضل.
إذا كنت مؤسسة خيرية ، فيرجى الاتصال بدعم العملاء لتفعيل خصم 20٪.
للحصول على الخطة الشهرية المناسبة لك تواصل معنا 
<br />
إذا كنت بحاجة إلى أي مساعدة للبدء ، تحقق من موقع المساعدة للحصول على مقالات مفيدة ، أو قم بالرد على رسالة البريد الإلكتروني هذه إذا كانت لديك أي أسئلة .
<br />
أتمنى لك كل خير،
<br />
فريق وجهتنا
                </h4>
                <div style="
                    width: 250px;
                    margin: auto;
                    display: block;
                ">
                    <a href="'.$ettings['facebook'].'"><img style="width:70px;float:right;" src="'.base_url().'vendor/images/fb.png'.'"></a>
                    <a href="'.$ettings['twitter'].'"><img style="width:70px;float:right;" src="'.base_url().'vendor/images/tw.png'.'"></a>
                    <a href="'.$ettings['instagram'].'"><img style="width:70px;float:right;" src="'.base_url().'vendor/images/in.png'.'"></a>
                </div>
            </div>
            </div><style>
            h3#msg_ti {
                text-align: center;
                font-size: 30px;
                background: #292929;
                color: #fff;
                font-family: tahoma;
            }
            .container{
            width:250px;
            margin:auto;
            display:block;
            text-align:center;
            }
            </style>
            </body></html>');
            
            // Mail it
            $this->email->send();
            
            // Redirect to profile
            redirect(base_url().'user/'.$this->session->userdata('username'));
           }else{
            if(strip_tags($this->input->post('type')) !== '0' AND strip_tags($this->input->post('type')) !== '1' AND strip_tags($this->input->post('type')) !== '2'){
                $user['type'] = '0';
            }else{
                $user['type'] = $this->input->post('type');
            }
                $this->register();
        }
    }
    }
    public function login(){
        if($this->main_model->is_logged_in()){
            // Redirect to profile
            redirect(base_url().'user/'.$this->session->userdata('username'));
        }else{
        $data['title'] = 'دخول في موقع وجهتنا - موقع وجهتنا';
            // Get login URL
            $data['authURL'] =  $this->facebook->login_url();
            /*END FB REGISTER & LOGIN*/
        //echo urldecode($this->uri->segment(2)); Arabic letters Function in url
        $this->load->view('login_view',$data);
        }
    }
    public function restPassword(){
        if($this->main_model->is_logged_in()){
            // Redirect to profile
            redirect(base_url().'user/'.$this->session->userdata('username'));
        }else{
        $data['title'] = 'استعادة كلمة السر - موقع وجهتنا';
            // Get login URL
            $data['authURL'] =  $this->facebook->login_url();
            /*END FB REGISTER & LOGIN*/
        //echo urldecode($this->uri->segment(2)); Arabic letters Function in url
        $this->load->view('reset_view',$data);
        }
    }
    public function repass(){
        if($this->main_model->is_logged_in()){
            // Redirect to profile
            redirect(base_url().'user/'.$this->session->userdata('username'));
        }else{
        $data['title'] = 'استعادة كلمة السر - موقع وجهتنا';
            // Get login URL
            $data['authURL'] =  $this->facebook->login_url();
            /*END FB REGISTER & LOGIN*/
        //echo urldecode($this->uri->segment(2)); Arabic letters Function in url
        $records = $this->main_model->getByData('users_activation','code',$this->uri->segment(3));
            if($records == false){
                redirect(base_url().'404/');
            }
            $data['user'] = $this->main_model->getByData('users','id',$records[0]->u_id)[0];
        $this->load->view('repass_view',$data);
        }
    }
    public function repassCheck()
	{
            if($this->main_model->is_logged_in()){
                // Redirect to profile
            redirect(base_url().'user/'.$this->session->userdata('username'));
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
        $this->form_validation->set_rules('passwordConf','تأكيد كلمة السر صحيحة','required|matches[password]',$rul);
        // Check if val. true
        if($this->form_validation->run() == true){
            $email=strip_tags($this->input->post('email'));
                $records = $this->main_model->getByData('users','email',$email);
            if($records == TRUE){
                $this->main_model->update('users','id',$records[0]->id,array(
                    'password' =>$this->encryption->encrypt($this->input->post('password'))
                ));
                $this->main_model->deleteData('users_activation','u_id',$records[0]->id);
                redirect(base_url().'login');
            }else {
                redirect(base_url().'pages/restPassword/wrong');
            }
            }  else {
                $this->login();
            }
            }
        }
                public function resetCheck()
	{
            if($this->main_model->is_logged_in()){
                // Redirect to profile
            redirect(base_url().'user/'.$this->session->userdata('username'));
            }else{
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'is_unique'     => '%s مسجل لدينا بالفعل',
                'matches'     => 'يجب عليك إدخال %s .',
                'integer'     => 'يجب عليك إدخال %s .',
                'valid_email'     => 'يجب عليك إدخال %s صحيح.'
            );
        $this->form_validation->set_rules('email','البريد الالكتروني','required|valid_email',$rul);
        // Check if val. true
        if($this->form_validation->run() == true){
            $email=strip_tags($this->input->post('email'));
                $records = $this->main_model->getByData('users','email',$email);
                if($records == TRUE){
                    $now = new DateTime();
                    $now->setTimezone(new DateTimezone('Africa/Cairo'));
                    $dateNow = (array) $now;
                    // Declare and define two dates 
                    $currentDTime = explode('.',$dateNow['date']);
                    $random_code=$this->main_model->random_number();
                    $this->main_model->deleteData('users_activation','u_id',$records[0]->id);
                    $this->main_model->insertData('users_activation',array(
                'u_id' => $records[0]->id,
                'code' => $random_code,
                'state' => 1,
                'time' => $currentDTime[0]
            ));
            // Here I`ll Send the message.
            // Multiple recipients
            $to = strip_tags($this->input->post('email')); // note the comma

            // Subject
            $subject = 'استعادة كلمة السر | موقع وجهتنا';

            // Message
            $message = '
            <html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <style type="text/css">
                @font-face {
            font-family: "Droid Arabic Kufi";
            src: url("'.base_url().'vendor/fonts/Droid Arabic Kufi.ttf");
            }
                    body{
                    font-family: "Droid Arabic Kufi",sans-serif;
                    }
                </style>
            </head><body><div style="
                width: 90%;
                margin: auto;
                padding: 25px;
                border-bottom: 1px solid #ddd;
                text-align: left;
                height: 30px;
                font-size: 18px;
            ">
            <img src="'.base_url().'vendor/images/logo.png" style="
                width: 140px;
                margin: auto;
                display: block;
            ">

                <div style="
                float: right;
                width: 100%;
                text-align: right;
                direction: rtl;
                clear: both;
            ">
                <h4>
                أهلاً '.$records[0]->username.'
                <br />
                لقد تم طلب استعادة كلمة سر حسابك ... اتبع الرابط التالي لتغيير كلمة السر:
                </h4>
                <h5 style="
                padding: 10px;
                background: #ddd;
                text-align: center;
                border: 1px solid #b5b5b5;
            "><a href="'.base_url().'pages/repass/'.$random_code.'" target="_blank">'.base_url().'pages/repass/'.$random_code.'</a></h5>
            </div>
            </div><style>
            h3#msg_ti {
                text-align: center;
                font-size: 30px;
                background: #292929;
                color: #fff;
                font-family: tahoma;
            }
            </style>
            </body></html>
            ';
            $this->load->library('email');
            $this->email->set_mailtype("html");
            $this->email->from('support@wjhatna.com', 'منصة وجهتنا');
            $this->email->to(strip_tags($this->input->post('email')));
            $this->email->cc('support@wjhatna.com');
            $this->email->bcc('support@wjhatna.com');

            $this->email->subject($subject);
            $this->email->message($message);
            
            // Mail it
            $this->email->send();
                    redirect(base_url().'pages/restPassword/done');
            }else {
                redirect(base_url().'pages/restPassword/wrong');
            }
            }  else {
                $this->login();
            }
            }
        }
            public function loginCheck()
	{
            if($this->main_model->is_logged_in()){
                // Redirect to profile
            redirect(base_url().'user/'.$this->session->userdata('username'));
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
                $records = $this->main_model->getByData('users','email',$email);
                if($records == TRUE){
                foreach ($records as $row){
                    $password_f = $row->password;
                    $email_f = $row->email;
                    if($password == $this->encryption->decrypt($password_f) and $email == $email_f){
                        $row_arr = (array) $row;
                        $this->session->set_userdata($row_arr);
                        redirect(base_url().'user/'.$this->session->userdata('username'));
                    }  else {
                        redirect(base_url().'pages/login/wrong');
                    }
                }
        }else {
                redirect(base_url().'pages/login/wrong');
            }
            }  else {
                $this->login();
            }
            }
        }
    public function logout(){
        if($this->main_model->is_logged_in()){
            $l_logout = (array) $this->main_model->is_logged_in(1)[0];
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
    public function page(){
        $data['page'] = $this->main_model->getByData('pages','username',$this->uri->segment(2));
        if($data['page']){
            $data['title'] = 'صفحة '.$data['page'][0]->p_name;
            $config = array();
            $config["base_url"] = base_url() . "p/".$this->uri->segment(2).'/';

            $config["total_rows"] = $this->main_model->getFullRequest('items','p_id = '.$data['page'][0]->id,'count');

            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            $data['events'] = $this->main_model->getAllDataAdv('items','id','DESC','p_id',$data['page'][0]->id,$config["per_page"],$page,'type',0);
            $data['promos'] = $this->main_model->getAllDataAdv('items','id','DESC','p_id',$data['page'][0]->id,$config["per_page"],$page,'type',1);
            $this->load->view('page_view',$data);
        }else{
            redirect(base_url().'404');
        }
    }
    public function i(){
        
        //echo urldecode($this->uri->segment(2)); Arabic letters Function in url
        if($this->uri->segment(2) !== 'buyCheck'){
            $data['item'] = $this->main_model->getByData('items','id',$this->uri->segment(3));
        }else{
            $data['item'] = $this->main_model->getByData('items','id',$this->uri->segment(4));
        }
        if(!$data['item']){
            redirect(base_url().'404');
        }
        $data['title'] = 'صفحة '.$data['item'][0]->title;
        $data['page'] = $this->main_model->getByData('pages','id',$data['item'][0]->p_id);
        $data['user'] = $this->main_model->getByData('users','id',$data['item'][0]->u_id);
        $this->load->view('include/header',$data);
        $this->load->view('item_view',$data);
        $this->load->view('include/footer',$data);
    }
    public function buyCheck(){
        if($this->main_model->is_logged_in()){
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال عدد نوع التذاكر من "%s" .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.',
                'alpha_numeric' => '%s يجب أن يكون أرقام وحروف فقط',
                'less_than_equal_to' => 'لقد تخطيت العدد المسموح لشراء هذه التذكرة.',
                'is_unique' => '%s مستخدم من قبل.'
                );
            $tickets = $this->main_model->getByData('tickets','i_id',$this->input->post('itemId'));
            if(!$tickets){
                redirect(base_url().'404');
            }
            foreach($tickets as $ticket){
                $paid = $this->main_model->getFullRequest('p_tickets','t_id = '.$ticket->id.' AND state = 1');
                $paidTickets = 0;
                       if($paid){
                           foreach($paid as $paidtick){
                           $paidTickets += $paidtick->num;
                       }}
                       $available = $ticket->num - $paidTickets;
                       if($available <= 0){
                           $unable[$ticket->id] = $ticket->id;
                       }
                if($this->input->post('t'.$ticket->id)){
                    $this->form_validation->set_rules('t'.$ticket->id,$ticket->title,'required|is_natural_no_zero|less_than_equal_to['.$ticket->num.']',$rul);
                }
            }
            // Check if validation true
            if($this->form_validation->run() == true){
                $data['title'] = 'الحجز والدفع عند الإستلام | موقع وجهتنا';
                $data["links"] = '';
                foreach($tickets as $ticket){
                    if($this->input->post('t'.$ticket->id)){
                        $items = (array) $this->main_model->getByData('items','id',$this->input->post('itemId'))[0];
                        if($items['state'] == '0'){
                            redirect(base_url().'404');
                        }
                        if(!isset($unable[$ticket->id])){
                            $insertTicket = $this->main_model->insertData('p_tickets',array(
                                'i_id'=>$this->input->post('itemId'),
                                's_id'=>$items['u_id'],
                                'num'=>$this->input->post('t'.$ticket->id),
                                'u_id'=>$this->session->userdata('id'),
                                't_id'=>$ticket->id,
                                'price'=>$ticket->price-$ticket->discount,
                                'date'=>$this->main_model->dateTime('current'),
                                'state'=>0
                            ));
                            // Here I`ll Send the message.
            // Multiple recipients
            $buyer = $this->main_model->getByData('users','id',$this->session->userdata('id'));
            $to = strip_tags($buyer[0]->email); // note the comma

            // Subject
            $subject = 'تم انشاء طلبية في حسابك | موقع وجهتنا';

            // Message
            $message = '
            <html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <style type="text/css">
                @font-face {
            font-family: "Droid Arabic Kufi";
            src: url("'.base_url().'vendor/fonts/Droid Arabic Kufi.ttf");
            }
                    body{
                    font-family: "Droid Arabic Kufi",sans-serif;
                    }
                </style>
            </head><body><div style="
                width: 90%;
                margin: auto;
                padding: 25px;
                border-bottom: 1px solid #ddd;
                text-align: left;
                height: 30px;
                font-size: 18px;
            ">
            <img src="'.base_url().'vendor/images/logo.png" style="
                width: 140px;
                margin: auto;
                display: block;
            ">

                <div style="
                float: right;
                width: 100%;
                text-align: right;
                direction: rtl;
                clear: both;
            ">
                <h4>
                أهلاً '.$buyer[0]->username.'
                <br />
                تم انشاء طلبية حالتها - لم يتم التحصيل بعد.
                </h4>
                <h5 style="
                padding: 10px;
                background: #ddd;
                text-align: center;
                border: 1px solid #b5b5b5;
            ">تواصل مع التاجر عن طريق البيانات - بيانات التاجر على التذكرة في حسابك</h5>
            </div>
            </div><style>
            h3#msg_ti {
                text-align: center;
                font-size: 30px;
                background: #292929;
                color: #fff;
                font-family: tahoma;
            }
            </style>
            </body></html>
            ';
            $this->load->library('email');
            $this->email->set_mailtype("html");
            $this->email->from('support@wjhatna.com', 'منصة وجهتنا');
            $this->email->to($to);
            $this->email->cc('support@wjhatna.com');
            $this->email->bcc('support@wjhatna.com');

            $this->email->subject($subject);
            $this->email->message($message);
            
            // Mail it
            $this->email->send();
                            $this->main_model->alert('لقد انشاء طلبية','لقد تم انشاء طلبية رقم '.$insertTicket->id,$items['u_id']);
                            $data['orders'][] = $insertTicket;
                        }
                    }
                }
                $this->load->view('include/header',$data);
                $this->load->view('cpay_view',$data);
                $this->load->view('include/footer',$data);
            }else{
                $this->i();
            }
        }else{
            redirect(base_url().'pages/login');
        }
    }
    function sitemap()
    {

        $data['records'] = $this->main_model->getByData('items','state',1);//select urls from DB to Array
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap",$data);
    }
    function blog(){
        $data=array();
        $data['title'] = 'مدونة موقع وجهتنا';
        $config = array();
        $config["base_url"] = base_url() . "pages/blog/";

        $config["total_rows"] = $this->main_model->getFullRequest('items','type = 5','count');
        if($this->uri->segment(3) == ''){
            $config["per_page"] = 12;
        }else{
            $config["per_page"] = 10;
        }
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();
        $data['AllRecords'] = $this->main_model->getAllDataAdv('items','id','DESC','type',5,$config["per_page"],$page,'','');
        $data['recordsLimited'] = $this->main_model->getAllDataAdv('items','id','DESC','type',5,2);//select 2 posts from DB to Array
        if($this->uri->segment(3) == ''){
            // The following lines will remove values from the first two indexes.
            unset($data['AllRecords'][0]);
            unset($data['AllRecords'][1]);
            if($data['recordsLimited']){
            // This line will re-set the indexes (the above just nullifies the values...) and make a     new array without the original first two slots.
            $data['records'] = array_values($data['AllRecords']);
            }else{
                $data['records'] = 0;
            }
        }else{
            if($data['recordsLimited']){
            $data['records'] = array_values($data['AllRecords']);
            }else{
                $data['records'] = 0;
            }
        }
        if($this->main_model->is_admin_logged_in()){
            $this->load->view('admin/include/header',$data);
            $this->load->view('blog/main_view',$data);
            $this->load->view('admin/include/footer',$data);
        }else{
            $this->load->view('include/header',$data);
            $this->load->view('blog/main_view',$data);
            $this->load->view('include/footer',$data);
        }
        
    }
}
