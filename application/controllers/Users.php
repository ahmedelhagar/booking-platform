<?php
class Users extends CI_Controller {

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
    public function index(){
            $data['title']='لوحة التحكم في حسابك في موقع وجهتنا | موقع وجهتنا';
            $data['user'] = $this->main_model->getByData('users','username',$this->uri->segment(2));
            if(!$data['user']){
                redirect(base_url().'404/');
            }
            $this->load->view('include/header',$data);
            $data['mtags'] = $this->main_model->getByData('tags','state',0);
            $data['subtags'] = $this->main_model->getByData('tags','state',1);
            $this->load->view('userarea/home_view',$data);
            $this->load->view('include/footer',$data);
    }
    public function fetchalerts(){
        if($this->main_model->is_logged_in()){
           if(strip_tags($this->input->post('request')) == 'seen'){
               $this->main_model->update('alerts','u_id',$this->session->userdata('id'),array(
                   'statue' => 1
               ));
            $response = array(
                        'done' => 1,
                        );
            echo json_encode($response);
           }elseif(strip_tags($this->input->post('request')) == 'unseen'){
               $nums = $this->main_model->getFullRequest('alerts','statue = 0 AND u_id = '.$this->session->userdata('id'),'count');
               $alerts = $this->main_model->getFullRequest('alerts','(u_id = '.$this->session->userdata('id').') ORDER BY `id` DESC');
               if($nums > 0){
                   $done = 1;
               }else{
                   $done = 0;
               }
               $response = array(
                       'done' => $done,
                       'nums' => $nums,
                       'alerts' => $alerts
                        );
                echo json_encode($response);
           }
        }else{
                redirect(base_url().'404/');
            }
    }
    public function checkTicket(){
        if($this->main_model->is_logged_in()){
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
    $ticketOrder = $this->main_model->getFullRequest('p_tickets','(id = '.strip_tags($this->input->post('p_id')).' AND num >= '.strip_tags($this->input->post('t_id')).') AND (s_id = '.$this->session->userdata('id').' OR u_id = '.$this->session->userdata('id').')');
            $uId = $this->session->userdata('id');
            $config = array();
            $config["base_url"] = base_url() . "users/tickets/";

            $config["total_rows"] = $this->main_model->getFullRequest('p_tickets','u_id = '.$uId.' OR s_id = '.$uId,'count');

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
            
            $data['orders'] = $this->main_model->getFullRequest('p_tickets','(u_id = '.$uId.') OR (s_id = '.$uId.') ORDER BY `id` DESC LIMIT '.$limitval);
            
            $data["total_rows"] = $config["total_rows"];
            
            $data['title'] = 'تذاكري | موقع وجهتنا';
            
            if($ticketOrder){
                $used = $this->main_model->getFullRequest('used','(p_id = '.strip_tags($this->input->post('p_id')).' AND num = '.strip_tags($this->input->post('t_id')).')');
                if($used){
                    $data['state11'] = 'التذكرة مُستخدمة';
                }else{
                    $data['state11'] = 'التذكرة مُحصلة وصالحة';
                }
            $this->load->view('include/header',$data);
            $this->load->view('cpay_view',$data);
            $this->load->view('include/footer',$data);
            }else{
            $data['error'] = 'لايوجد لديك تذكرة مُحصلة بهذه البيانات';
            $this->load->view('include/header',$data);
            $this->load->view('cpay_view',$data);
            $this->load->view('include/footer',$data);
            }
        }else{
                $this->tickets();
            }
        }
    }
    public function used(){
        if($this->main_model->is_logged_in()){
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
    $ticketOrder = $this->main_model->getFullRequest('p_tickets','(id = '.strip_tags($this->input->post('p_id')).' AND num >= '.strip_tags($this->input->post('t_id')).') AND (s_id = '.$this->session->userdata('id').')');
            $uId = $this->session->userdata('id');
            $config = array();
            $config["base_url"] = base_url() . "users/tickets/";

            $config["total_rows"] = $this->main_model->getFullRequest('p_tickets','u_id = '.$uId.' OR s_id = '.$uId,'count');

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
            
            $data['orders'] = $this->main_model->getFullRequest('p_tickets','(u_id = '.$uId.') OR (s_id = '.$uId.') ORDER BY `id` DESC LIMIT '.$limitval);
            
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
            $this->load->view('include/header',$data);
            $this->load->view('cpay_view',$data);
            $this->load->view('include/footer',$data);
            }else{
            $data['error'] = 'لايوجد لديك تذكرة مُحصلة بهذه البيانات';
            $this->load->view('include/header',$data);
            $this->load->view('cpay_view',$data);
            $this->load->view('include/footer',$data);
            }
                }else{
                $this->tickets();
            }
        }
    }
    public function follow(){
        if($this->main_model->is_logged_in()){
            $p_id = $this->input->post('id');
            $f_id = $this->session->userdata('id');
            $followed = $this->main_model->getFullRequest('followers','f_id = '.$f_id.' AND p_id = '.$p_id);
            if(!$followed){
                $this->main_model->insertData('followers',array(
                    'f_id' => $f_id,
                    'p_id' => $p_id
                ));
                $page = $this->main_model->getByData('pages','id',$p_id);
                $this->main_model->alert('تمت متابعة صفحة <a href="'.base_url().'/p/'.$page[0]->username.'">'.$page[0]->p_name.'</a>','قام '.$this->session->userdata('username').' بمتابعة صفحتك.',$page[0]->u_id);
                $done = 1;
            }else{
                $this->main_model->deleteData('followers','id',$followed[0]->id);
                $done = 2;
            }
            $num = $this->main_model->getFullRequest('followers','p_id = '.$p_id,'count');
                if($num == null){
                    $num = 0;
                }
        $response = array(
                       'done' => $done,
                       'num' => $num
                        );
                echo json_encode($response);
        }else{
                $response = array(
                       'done' => 0
                        );
                echo json_encode($response);
            }
    }
    function addEvent(){
        if($this->main_model->is_logged_in()){
            $creds = explode(',',$this->session->userdata('cred'));
            if(in_array('events',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
            if($creded == 1){
                $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة فعالية | موقع وجهتنا';
                $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','state = 0 AND c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
                $data['msubtag'] = $msubtag;
                $this->load->view('userarea/eventForm_view',$data);
            }else{
                redirect(base_url().'404/');
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    function addEventCheck(){
        $creds = explode(',',$this->session->userdata('cred'));
            if(in_array('events',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
        if($this->main_model->is_logged_in() && $creded == 1){
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','state = 0 AND c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
            $data['msubtag'] = $msubtag;
            $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة فعالية | موقع وجهتنا';
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
            $data['mtags2'] = (array) $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $data['subtags2'] = (array) $this->main_model->getByData('tags','c_tag',$this->input->post('mtag'));
            if($this->input->post('mtag')){
            foreach($data['subtags2'] as $tag){
                $stags[] = $tag->id;
            }}
            foreach($data['mtags2'] as $mtag){
                $mtags[] = $mtag->id;
            }
            $this->form_validation->set_rules('title','عنوان الفعالية','required|alpha_numeric_spaces',$rul);
            $this->form_validation->set_rules('content','وصف الفعالية','required|min_length[30]',$rul);
            $this->form_validation->set_rules('mtag','تصنيف رئيسي','required|in_list['.$this->main_model->list_rule($mtags).']',$rul);
            if($this->input->post('mtag')){
            $this->form_validation->set_rules('subtag','تصنيف فرعي','required|in_list['.$this->main_model->list_rule($stags).']',$rul);
            }
            $this->form_validation->set_rules('tags','الكلمات المفتاحية','required',$rul);
            $this->form_validation->set_rules('from','تاريخ البداية','required',$rul);
            $this->form_validation->set_rules('fmin','دقائق البداية','required',$rul);
            $this->form_validation->set_rules('fhours','ساعات البداية','required',$rul);
            $this->form_validation->set_rules('to','تاريخ النهاية','required',$rul);
            $this->form_validation->set_rules('tmin','دقائق النهاية','required',$rul);
            $this->form_validation->set_rules('thours','ساعات النهاية','required',$rul);
            $this->form_validation->set_rules('location','العنوان التفصيلي','required',$rul);
            $this->form_validation->set_rules('g_location','الولاية أو المحافظة','required',$rul);
            $this->form_validation->set_rules('search_latitude','عنوان صحيح من الخريطة','required',$rul);
            $this->form_validation->set_rules('search_longitude','عنوان صحيح من الخريطة','required',$rul);
            $this->form_validation->set_rules('fm','نوع الوقت','required|in_list['.$this->main_model->list_rule(array('AM','PM')).']',$rul);
            $this->form_validation->set_rules('tm','نوع الوقت','required|in_list['.$this->main_model->list_rule(array('AM','PM')).']',$rul);
            // Check if validation true
        if($this->form_validation->run() == true){
            $data['p_title'] = $this->input->post('title');
            $data['p_content'] = $this->input->post('content');
            $data['p_mtag'] = $this->input->post('mtag');
            $data['p_subtag'] = $this->input->post('subtag');
            $data['p_tags'] = $this->input->post('tags');
            $data['p_location'] = $this->input->post('location');
            $data['p_g_location'] = $this->input->post('g_location');
            $data['search_latitude'] = $this->input->post('search_latitude');
            $data['search_longitude'] = $this->input->post('search_longitude');
            $data['p_s_date'] = $this->input->post('from').' '.$this->input->post('fhours').':'.$this->input->post('fmin').' '.$this->input->post('fm');
            $data['p_e_date'] = $this->input->post('to').' '.$this->input->post('thours').':'.$this->input->post('tmin').' '.$this->input->post('tm');
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
                
                if(in_array('bank',explode(',',$userData['cred']))){
                    $data['pay'] = 1;
                }else{
                    $data['pay'] = 0;
                }
                    
                ///*Insert Event
                $insertProduct = $this->main_model->insertData('items',array(
                    'title' => $data['p_title'],
                    'content' => $data['p_content'],
                    's_date' => $data['p_s_date'],
                    'e_date' => $data['p_e_date'],
                    'location' => $data['p_location'],
                    'g_location' => $data['p_g_location'],
                    'mtag' => $data['p_mtag'],
                    'tags' => $data['p_tags'],
                    'subtag' => $data['p_subtag'],
                    'image' => $data['thumbnails'][1],
                    'date' => $this->main_model->dateTime('current'),
                    'u_id' => $userId,
                    'p_id' => $data['p_id'],
                    'search_latitude' => $data['search_latitude'],
                    'search_longitude' => $data['search_longitude'],
                    'pay' => $data['pay'],
                    'state' => 0,
                    'type' => 0
                ));
                    $this->main_model->alert('تمت إضافة '.$data['p_title'],'تحت المراجعة من قبل الإدارة ... وسيتم إبلاغك فور نشر الموضوع',$userId);
                 $followers = $this->main_model->getByData('followers','p_id',$data['p_id']);
                 $page = $this->main_model->getByData('pages','id',$data['p_id']);
                    if($followers){foreach($followers as $follower){
                         $this->main_model->alert('لقد قامت صفحة <a href="'.base_url().'p/'.$page[0]->username.'">'.$page[0]->p_name.'</a>','بإضافة فعالية جديدة تفقد الصفحة.',$follower->f_id);
                    }
                    }
                $data['state'] = 2;
                $itemId = (array) $this->main_model->getAllDataCond('items','u_id',$userId,'image',$data['thumbnails'][1])[0];
                redirect(base_url().'users/addTicket/'.$itemId['id'],$data);
                }
        }else{
            $this->load->view('userarea/eventForm_view',$data);
            }
        }else{
            redirect(base_url().'404/');
        }
    }
        function addPage(){
        if($this->main_model->is_logged_in()){
            $creds = explode(',',$this->session->userdata('cred'));
            if(in_array('pages',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
            if($creded == 1){
                $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة صفحة | موقع وجهتنا';
                $data['mtags'] = $this->main_model->getAllDataCond('tags','state',3,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
                $data['msubtag'] = $msubtag;
                $this->load->view('userarea/pageForm_view',$data);
            }else{
                redirect(base_url().'404/');
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    public function lisence()
        {
        if($this->main_model->is_logged_in()){
            $userD = $this->main_model->getByData('users','id',$this->session->userdata('id'))[0];
            if($userD->img1 !== null){
                redirect(base_url().'404/');
            }
        $error = array('error'=>'');
        $error['title'] = 'رفع الرخصة التجارية';
                $this->load->view('include/header', $error);
                $this->load->view('userarea/upload_form',$error);
                $this->load->view('include/footer', $error);
        }else{
            redirect(base_url().'404/');
        }
        }

        public function do_upload()
        {
            if($this->main_model->is_logged_in()){
            $userD = $this->main_model->getByData('users','id',$this->session->userdata('id'))[0];
            if($userD->img1 !== null){
                redirect(base_url().'404/');
            }
            $error = array('error'=>'');
            $error['title'] = 'رفع الرخصة التجارية';
                $config['upload_path']          = './vendor/uploads/images/';
                $config['allowed_types']        = 'jpeg|jpg|png';
                $config['max_size']             = 5000;
                $config['max_width']            = 5000;
                $config['max_height']           = 5000;
                $config['encrypt_name']           = TRUE;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('include/header', $error);
                        $this->load->view('userarea/upload_form', $error);
                        $this->load->view('include/footer', $error);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        $this->main_model->update('users','id',$this->session->userdata('id'),array(
                            'img1'=>$data['upload_data']['file_name'],
                        ));
                        $this->load->view('include/header', $error);
                        $this->load->view('userarea/upload_success', $data);
                        $this->load->view('include/footer', $error);
                }
                }else{
            redirect(base_url().'404/');
        }
        }
    function addPageCheck(){
        $creds = explode(',',$this->session->userdata('cred'));
            if(in_array('pages',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
        if($this->main_model->is_logged_in() && $creded == 1){
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',3,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
            $data['msubtag'] = $msubtag;
            $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة صفحة | موقع وجهتنا';
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.',
                'alpha_numeric' => '%s يجب أن يكون أرقام وحروف فقط',
                'is_unique' => '%s مستخدم من قبل.'
                );
            $data['mtags2'] = (array) $this->main_model->getAllDataCond('tags','state',3,'c_tag',NULL);
            $data['subtags2'] = (array) $this->main_model->getByData('tags','c_tag',$this->input->post('mtag'));
            if($this->input->post('mtag')){
            foreach($data['subtags2'] as $tag){
                $stags[] = $tag->id;
            }}
            foreach($data['mtags2'] as $mtag){
                $mtags[] = $mtag->id;
            }
            $this->form_validation->set_rules('title','عنوان الصفحة','required|alpha_numeric_spaces',$rul);
            $this->form_validation->set_rules('content','وصف الصفحة','required|min_length[10]',$rul);
            if($this->input->post('fb')){
                $this->form_validation->set_rules('fb','facebook','valid_url',$rul);
                $fb = $this->input->post('fb');
            }else{
                $fb = NULL;
            }
            if($this->input->post('instagram')){
                $this->form_validation->set_rules('instagram','instagram','valid_url',$rul);
                $instagram = $this->input->post('instagram');
            }else{
                $instagram = NULL;
            }
            if($this->input->post('twitter')){
                $this->form_validation->set_rules('twitter','twitter','valid_url',$rul);
                $twitter = $this->input->post('twitter');
            }else{
                $twitter = NULL;
            }
            if($this->input->post('yt')){
                $this->form_validation->set_rules('yt','Youtube','valid_url',$rul);
                $yt = $this->input->post('yt');
            }else{
                $yt = NULL;
            }
            if($this->input->post('website')){
                $this->form_validation->set_rules('website','website','valid_url',$rul);
                $website = $this->input->post('website');
            }else{
                $website = NULL;
            }
            $this->form_validation->set_rules('mtag','تصنيف رئيسي','required|in_list['.$this->main_model->list_rule($mtags).']',$rul);
            if($this->input->post('mtag')){
            $this->form_validation->set_rules('subtag','تصنيف فرعي','required|in_list['.$this->main_model->list_rule($stags).']',$rul);
            }
            $this->form_validation->set_rules('tags','الكلمات المفتاحية','required',$rul);
            $this->form_validation->set_rules('username','رابط الصفحة','required|alpha_numeric|is_unique[pages.username]',$rul);
            
            // Check if validation true
        if($this->form_validation->run() == true){
            $data['p_name'] = $this->input->post('title');
            $data['p_desc'] = $this->input->post('content');
            $data['mtag'] = $this->input->post('mtag');
            $data['subtag'] = $this->input->post('subtag');
            $data['tags'] = $this->input->post('tags');
            $data['username'] = $this->input->post('username');
            $data['fb'] = $fb;
            $data['instagram'] = $instagram;
            $data['twitter'] = $twitter;
            $data['yt'] = $yt;
            $data['website'] = $website;
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
                        $this->load->view('userarea/pageForm_view', $data);
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
                $insertProduct = $this->main_model->insertData('pages',array(
                    'p_name' => $data['p_name'],
                    'p_desc' => $data['p_desc'],
                    'mtag' => $data['mtag'],
                    'subtag' => $data['subtag'],
                    'tags' => $data['tags'],
                    'username' => $data['username'],
                    'fb' => $data['fb'],
                    'instagram' => $data['instagram'],
                    'twitter' => $data['twitter'],
                    'yt' => $data['yt'],
                    'website' => $data['website'],
                    'logo' => $data['thumbnails'][1],
                    'date' => $this->main_model->dateTime('current'),
                    'u_id' => $userId,
                    'state' => 0
                ));
                    
                $data['state'] = 1;
                $this->load->view('userarea/pageForm_view',$data);
                }
        }else{
            $this->load->view('userarea/pageForm_view',$data);
            }//
        }else{
            redirect(base_url().'404/');
        }
    }
        function addTicket(){
        if($this->main_model->is_logged_in()){
            $creds = explode(',',$this->session->userdata('cred'));
            if(in_array('tickets',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            $perm = $this->main_model->getAllDataCond('items','id',$this->uri->segment(3),'u_id',$userId);
            if($creded == 1 && $perm){
                $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة فعالية | موقع وجهتنا';
                $data['item2'] = (array) $perm[0];
                $this->load->view('userarea/ticketForm_view',$data);
            }else{
                redirect(base_url().'404/');
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    function addTicketCheck(){
        $creds = explode(',',$this->session->userdata('cred'));
            if(in_array('tickets',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
        if($this->main_model->is_logged_in() && $creded == 1){
            $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة فعالية | موقع وجهتنا';
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            $perm = $this->main_model->getAllDataCond('items','id',$this->uri->segment(3),'u_id',$userId);
            if($perm){
                $data['item2'] = (array) $perm[0];
            }else{
                redirect(base_url().'404/');
            }
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'numeric' => 'برجاء إدخال أرقام فقط في خانة %s.',
                'less_than_equal_to' => 'يجب أن لا يتخطى قيمة التخفيض سعر التذكرة',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
            $this->form_validation->set_rules('title','اسم التذكرة','required|alpha_numeric_spaces',$rul);
            $this->form_validation->set_rules('price','سعر التذكرة','required',$rul);
            $this->form_validation->set_rules('num','عدد التذاكر المتاحة','required|is_natural_no_zero',$rul);
            if($this->input->post('discount')){
                $this->form_validation->set_rules('discount','قيمة التخفيض','numeric|less_than_equal_to['.$this->input->post('price').']',$rul);
            }
            $data['p_title'] = $this->input->post('title');
            $data['p_price'] = $this->input->post('price');
            $data['p_num'] = $this->input->post('num');
        if($this->form_validation->run() == true){
            // Accepted Validation
            $insert = $this->main_model->insertData('tickets',array(
                'title' => $data['p_title'],
                'price' => $data['p_price'],
                'num' => $data['p_num'],
                'date' => $this->main_model->dateTime('current'),
                'u_id' => $userId,
                'i_id' => $this->uri->segment(3),
                'discount' => $this->input->post('discount'),
            ));
            redirect(base_url().'users/addTicket/'.$this->uri->segment(3).'/done',$data);
        }else{
            $this->load->view('userarea/ticketForm_view',$data);
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    function pages(){
        if($this->main_model->is_logged_in()){
            $cred = $this->session->userdata('cred');
        }else{
            $cred = '';
        }
            $creds = explode(',',$cred);
            if(in_array('pages',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in($this->uri->segment(3))[0];
                $userId = $userData['id'];
            $config = array();

            $config["base_url"] = base_url() . "wjhatnacadmin/allUsers/";

            $config["total_rows"] = $this->main_model->record_count('','users');

            $config["per_page"] = 20;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            $data['pages'] = $this->main_model->getAllDataAdv('pages','id','DESC','u_id',$userId,$config["per_page"],$page,'','');
            if($data['pages']){
                $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - الصفحات | موقع وجهتنا';
                $this->load->view('userarea/pages_view',$data);
            }else{redirect(base_url().'404/');}
    }
        function addPromo(){
        if($this->main_model->is_logged_in()){
            $creds = explode(',',$this->session->userdata('cred'));
            if(in_array('promos',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
            if($creded == 1){
                $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة عرض | موقع وجهتنا';
                $data['mtags'] = $this->main_model->getAllDataCond('tags','state',2,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
                $data['msubtag'] = $msubtag;
                $this->load->view('userarea/promoForm_view',$data);
            }else{
                redirect(base_url().'404/');
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    function addPromoCheck(){
        $creds = explode(',',$this->session->userdata('cred'));
            if(in_array('promos',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
        if($this->main_model->is_logged_in() && $creded == 1){
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',2,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
            $data['msubtag'] = $msubtag;
            $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة عرض | موقع وجهتنا';
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
            $data['mtags2'] = (array) $this->main_model->getAllDataCond('tags','state',2,'c_tag',NULL);
            $data['subtags2'] = (array) $this->main_model->getByData('tags','c_tag',$this->input->post('mtag'));
            if($this->input->post('mtag')){
            foreach($data['subtags2'] as $tag){
                $stags[] = $tag->id;
            }}
            foreach($data['mtags2'] as $mtag){
                $mtags[] = $mtag->id;
            }
            $this->form_validation->set_rules('title','عنوان الفعالية','required|alpha_numeric_spaces',$rul);
            $this->form_validation->set_rules('content','وصف الفعالية','required|min_length[30]',$rul);
            $this->form_validation->set_rules('mtag','تصنيف رئيسي','required|in_list['.$this->main_model->list_rule($mtags).']',$rul);
            if($this->input->post('mtag')){
            $this->form_validation->set_rules('subtag','تصنيف فرعي','required|in_list['.$this->main_model->list_rule($stags).']',$rul);
            }
            $this->form_validation->set_rules('tags','الكلمات المفتاحية','required',$rul);
            $this->form_validation->set_rules('from','تاريخ البداية','required',$rul);
            $this->form_validation->set_rules('fmin','دقائق البداية','required',$rul);
            $this->form_validation->set_rules('fhours','ساعات البداية','required',$rul);
            $this->form_validation->set_rules('to','تاريخ النهاية','required',$rul);
            $this->form_validation->set_rules('tmin','دقائق النهاية','required',$rul);
            $this->form_validation->set_rules('thours','ساعات النهاية','required',$rul);
            $this->form_validation->set_rules('location','العنوان التفصيلي','required',$rul);
            $this->form_validation->set_rules('g_location','الولاية أو المحافظة','required',$rul);
            $this->form_validation->set_rules('search_latitude','عنوان صحيح','required',$rul);
            $this->form_validation->set_rules('search_longitude','عنوان صحيح','required',$rul);
            $this->form_validation->set_rules('fm','نوع الوقت','required|in_list['.$this->main_model->list_rule(array('AM','PM')).']',$rul);
            $this->form_validation->set_rules('tm','نوع الوقت','required|in_list['.$this->main_model->list_rule(array('AM','PM')).']',$rul);
            // Check if validation true
        if($this->form_validation->run() == true){
            $data['p_title'] = $this->input->post('title');
            $data['p_content'] = $this->input->post('content');
            $data['p_mtag'] = $this->input->post('mtag');
            $data['p_subtag'] = $this->input->post('subtag');
            $data['p_tags'] = $this->input->post('tags');
            $data['p_location'] = $this->input->post('location');
            $data['p_g_location'] = $this->input->post('g_location');
            $data['search_latitude'] = $this->input->post('search_latitude');
            $data['search_longitude'] = $this->input->post('search_longitude');
            $data['p_s_date'] = $this->input->post('from').' '.$this->input->post('fhours').':'.$this->input->post('fmin').' '.$this->input->post('fm');
            $data['p_e_date'] = $this->input->post('to').' '.$this->input->post('thours').':'.$this->input->post('tmin').' '.$this->input->post('tm');
            if($this->input->post('p_id')){
                $data['p_id'] = $this->input->post('p_id');
            }else{
                $data['p_id'] = 0;
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
                    // Upload Errors
                        $this->load->view('userarea/promoForm_view', $data);
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
                
                if(!in_array('bank',explode(',',$userData['cred']))){
                    $data['pay'] = 1;
                }else{
                    $data['pay'] = 0;
                }
                    
                ///*Insert Event
                $insertProduct = $this->main_model->insertData('items',array(
                    'title' => $data['p_title'],
                    'content' => $data['p_content'],
                    's_date' => $data['p_s_date'],
                    'e_date' => $data['p_e_date'],
                    'location' => $data['p_location'],
                    'g_location' => $data['p_g_location'],
                    'mtag' => $data['p_mtag'],
                    'tags' => $data['p_tags'],
                    'subtag' => $data['p_subtag'],
                    'image' => $data['thumbnails'][1],
                    'date' => $this->main_model->dateTime('current'),
                    'u_id' => $userId,
                    'p_id' => $data['p_id'],
                    'search_latitude' => $data['search_latitude'],
                    'search_longitude' => $data['search_longitude'],
                    'pay' => $data['pay'],
                    'state' => 0,
                    'type' => 1
                ));
                    $this->main_model->alert('تمت إضافة '.$data['p_title'],'تحت المراجعة من قبل الإدارة ... وسيتم إبلاغك فور نشر الموضوع',$userId);
                    $followers = $this->main_model->getByData('followers','p_id',$data['p_id']);
                 $page = $this->main_model->getByData('pages','id',$data['p_id']);
                    if($followers){foreach($followers as $follower){
                         $this->main_model->alert('لقد قامت صفحة <a href="'.base_url().'p/'.$page[0]->username.'">'.$page[0]->p_name.'</a>','بإضافة عرض ترويجي جديد تفقد الصفحة.',$follower->f_id);
                    }
                    }
                $data['state'] = 2;
                $itemId = (array) $this->main_model->getAllDataCond('items','u_id',$userId,'image',$data['thumbnails'][1])[0];
                redirect(base_url().'users/addTicket/'.$itemId['id'],$data);
                }
        }else{
            $this->load->view('userarea/promoForm_view',$data);
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    public function events(){
            $data['user'] = $this->main_model->getByData('users','username',$this->uri->segment(3));
            if(!$data['user']){
                redirect(base_url().'404/');
            }
            $data['title'] = 'وجهتنا | الفعاليات';
            $config = array();
            $config["base_url"] = base_url() . "users/events/".$this->uri->segment(3);

            $config["total_rows"] = $this->main_model->getFullRequest('items','type = 0 AND u_id = '.$data['user'][0]->id,'count');

            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            $data['events'] = $this->main_model->getAllDataAdv('items','id','DESC','u_id',$data['user'][0]->id,$config["per_page"],$page,'type',0);
            $data["total_rows"] = $config["total_rows"];
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $this->load->view('include/header',$data);
            $this->load->view('discover_view',$data);
            $this->load->view('include/footer',$data);
    }
    public function promos(){
            $data['user'] = $this->main_model->getByData('users','username',$this->uri->segment(3));
            if(!$data['user']){
                redirect(base_url().'404/');
            }
            $data['title'] = 'وجهتنا | الفعاليات';
            $config = array();
            $config["base_url"] = base_url() . "users/promos/".$this->uri->segment(3);

            $config["total_rows"] = $this->main_model->getFullRequest('items','type = 1 AND u_id = '.$data['user'][0]->id,'count');

            $config["per_page"] = 15;

            $config["uri_segment"] = 3;

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["links"] = $this->pagination->create_links();
            $data['events'] = $this->main_model->getAllDataAdv('items','id','DESC','u_id',$data['user'][0]->id,$config["per_page"],$page,'type',1);
            $data["total_rows"] = $config["total_rows"];
            $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $this->load->view('include/header',$data);
            $this->load->view('discover_view',$data);
            $this->load->view('include/footer',$data);
    }
    public function delete(){
        if($this->main_model->is_logged_in()){
            $tables = array('tickets','items','pages');
            if(in_array($this->uri->segment(3),$tables)){
                $table = $this->uri->segment(3);
            }else{
                redirect(base_url().'404/');
            }
            $data['item'] = $this->main_model->getAllDataCond($table,'id',$this->uri->segment(4),'u_id',$this->session->userdata('id'));
            if(isset($data['item'][0]->u_id) && $data['item'][0]->u_id == $this->session->userdata('id')){
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
        }else{
            redirect(base_url().'404/');
        }
    }
    public function edit(){
        if($this->main_model->is_logged_in()){
            $tables = array('tickets','items','pages');
            if(in_array($this->uri->segment(3),$tables)){
                $table = $this->uri->segment(3);
            }else{
                redirect(base_url().'404/');
            }
            $data['item'] = $this->main_model->getAllDataCond($table,'id',$this->uri->segment(4),'u_id',$this->session->userdata('id'));
            if($data['item'][0]->u_id == $this->session->userdata('id')){
                $data['title'] = 'تعديل | موقع وجهتنا';
                if($this->uri->segment(5) == 'event'){
                    $data['user'] = $this->main_model->getByData('users','id',$data['item'][0]->u_id);
                    $data['allTickets'] = $this->main_model->getByData('tickets','i_id',$data['item'][0]->id);
                    $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
                    foreach($data['mtags'] as $mtag){
                        $data['subtags'] = $this->main_model->getFullRequest('tags','state = 0 AND c_tag = '.$mtag->id);
                        $msubtag[$mtag->id] = $data['subtags'];
                    }
                    $data['msubtag'] = $msubtag;
                    $this->load->view('userarea/eventForm_view',$data);
                }elseif($this->uri->segment(5) == 'promo'){
                    $data['user'] = $this->main_model->getByData('users','id',$data['item'][0]->u_id);
                    $data['allTickets'] = $this->main_model->getByData('tickets','i_id',$data['item'][0]->id);
                    $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
                    foreach($data['mtags'] as $mtag){
                        $data['subtags'] = $this->main_model->getFullRequest('tags','state = 0 AND c_tag = '.$mtag->id);
                        $msubtag[$mtag->id] = $data['subtags'];
                    }
                    $data['msubtag'] = $msubtag;
                    $this->load->view('userarea/promoForm_view',$data);
                }elseif($this->uri->segment(5) == 'page'){
                    $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
                    foreach($data['mtags'] as $mtag){
                        $data['subtags'] = $this->main_model->getFullRequest('tags','state = 0 AND c_tag = '.$mtag->id);
                        $msubtag[$mtag->id] = $data['subtags'];
                    }
                    $data['msubtag'] = $msubtag;
                    $this->load->view('userarea/pageForm_view',$data);
                }elseif($this->uri->segment(5) == 'ticket'){
                    // Access User Data Securly
                        $userData = (array) $this->main_model->is_logged_in(1)[0];
                        $userId = $userData['id'];
                    $perm = $this->main_model->getAllDataCond('items','id',$this->uri->segment(6),'u_id',$userId);
                    if($perm){
                        $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - تعديل تذكرة | موقع وجهتنا';
                        $data['item2'] = (array) $perm[0];
                        $this->load->view('userarea/ticketForm_view',$data);
                    }else{
                        redirect(base_url().'404/');
                    }
                }
            }else{
                redirect(base_url().'404/');
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    public function editCheck(){
        if($this->main_model->is_logged_in()){
            $tables = array('tickets','items','pages');
            if(in_array($this->uri->segment(3),$tables)){
                $table = $this->uri->segment(3);
            }else{
                redirect(base_url().'404/');
            }
            $data['item'] = $this->main_model->getAllDataCond($table,'id',$this->uri->segment(4),'u_id',$this->session->userdata('id'));
            if($data['item'][0]->u_id == $this->session->userdata('id')){
                $data['title'] = 'تعديل | موقع وجهتنا';
                if($this->uri->segment(5) == 'event'){
                    $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','state = 0 AND c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
            $data['msubtag'] = $msubtag;
            $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة فعالية | موقع وجهتنا';
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
            $data['mtags2'] = (array) $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $data['subtags2'] = (array) $this->main_model->getByData('tags','c_tag',$this->input->post('mtag'));
            if($this->input->post('mtag')){
            foreach($data['subtags2'] as $tag){
                $stags[] = $tag->id;
            }}
            foreach($data['mtags2'] as $mtag){
                $mtags[] = $mtag->id;
            }
            $this->form_validation->set_rules('title','عنوان الفعالية','required|alpha_numeric_spaces',$rul);
            $this->form_validation->set_rules('content','وصف الفعالية','required|min_length[100]',$rul);
            $this->form_validation->set_rules('mtag','تصنيف رئيسي','required|in_list['.$this->main_model->list_rule($mtags).']',$rul);
            if($this->input->post('mtag')){
            $this->form_validation->set_rules('subtag','تصنيف فرعي','required|in_list['.$this->main_model->list_rule($stags).']',$rul);
            }
            $this->form_validation->set_rules('tags','الكلمات المفتاحية','required',$rul);
            $this->form_validation->set_rules('from','تاريخ البداية','required',$rul);
            $this->form_validation->set_rules('fmin','دقائق البداية','required',$rul);
            $this->form_validation->set_rules('fhours','ساعات البداية','required',$rul);
            $this->form_validation->set_rules('to','تاريخ النهاية','required',$rul);
            $this->form_validation->set_rules('tmin','دقائق النهاية','required',$rul);
            $this->form_validation->set_rules('thours','ساعات النهاية','required',$rul);
            $this->form_validation->set_rules('location','العنوان التفصيلي','required',$rul);
            $this->form_validation->set_rules('g_location','الولاية أو المحافظة','required',$rul);
            $this->form_validation->set_rules('search_latitude','عنوان صحيح من الخريطة','required',$rul);
            $this->form_validation->set_rules('search_longitude','عنوان صحيح من الخريطة','required',$rul);
            $this->form_validation->set_rules('fm','نوع الوقت','required|in_list['.$this->main_model->list_rule(array('AM','PM')).']',$rul);
            $this->form_validation->set_rules('tm','نوع الوقت','required|in_list['.$this->main_model->list_rule(array('AM','PM')).']',$rul);
            // Check if validation true
        if($this->form_validation->run() == true){
            $data['p_title'] = $this->input->post('title');
            $data['p_content'] = $this->input->post('content');
            $data['p_mtag'] = $this->input->post('mtag');
            $data['p_subtag'] = $this->input->post('subtag');
            $data['p_tags'] = $this->input->post('tags');
            $data['p_location'] = $this->input->post('location');
            $data['p_g_location'] = $this->input->post('g_location');
            $data['search_latitude'] = $this->input->post('search_latitude');
            $data['search_longitude'] = $this->input->post('search_longitude');
            $data['p_s_date'] = $this->input->post('from').' '.$this->input->post('fhours').':'.$this->input->post('fmin').' '.$this->input->post('fm');
            $data['p_e_date'] = $this->input->post('to').' '.$this->input->post('thours').':'.$this->input->post('tmin').' '.$this->input->post('tm');
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
                                's_date' => $data['p_s_date'],
                                'e_date' => $data['p_e_date'],
                                'location' => $data['p_location'],
                                'g_location' => $data['p_g_location'],
                                'mtag' => $data['p_mtag'],
                                'tags' => $data['p_tags'],
                                'subtag' => $data['p_subtag'],
                                'search_latitude' => $data['search_latitude'],
                                'search_longitude' => $data['search_longitude']
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
                    's_date' => $data['p_s_date'],
                    'e_date' => $data['p_e_date'],
                    'location' => $data['p_location'],
                    'g_location' => $data['p_g_location'],
                    'mtag' => $data['p_mtag'],
                    'tags' => $data['p_tags'],
                    'subtag' => $data['p_subtag'],
                    'image' => $data['thumbnails'][1],
                    'search_latitude' => $data['search_latitude'],
                    'search_longitude' => $data['search_longitude']
                ));
                    redirect(base_url().'users/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/done');
                }
        }else{
            $this->load->view('userarea/eventForm_view',$data);
            }
                }elseif($this->uri->segment(5) == 'promo'){
                    $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','state = 0 AND c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
            $data['msubtag'] = $msubtag;
            $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة عرض | موقع وجهتنا';
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
            $data['mtags2'] = (array) $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $data['subtags2'] = (array) $this->main_model->getByData('tags','c_tag',$this->input->post('mtag'));
            if($this->input->post('mtag')){
            foreach($data['subtags2'] as $tag){
                $stags[] = $tag->id;
            }}
            foreach($data['mtags2'] as $mtag){
                $mtags[] = $mtag->id;
            }
            $this->form_validation->set_rules('title','عنوان العرض','required|alpha_numeric_spaces',$rul);
            $this->form_validation->set_rules('content','وصف العرض','required|min_length[100]',$rul);
            $this->form_validation->set_rules('mtag','تصنيف رئيسي','required|in_list['.$this->main_model->list_rule($mtags).']',$rul);
            if($this->input->post('mtag')){
            $this->form_validation->set_rules('subtag','تصنيف فرعي','required|in_list['.$this->main_model->list_rule($stags).']',$rul);
            }
            $this->form_validation->set_rules('tags','الكلمات المفتاحية','required',$rul);
            $this->form_validation->set_rules('from','تاريخ البداية','required',$rul);
            $this->form_validation->set_rules('fmin','دقائق البداية','required',$rul);
            $this->form_validation->set_rules('fhours','ساعات البداية','required',$rul);
            $this->form_validation->set_rules('to','تاريخ النهاية','required',$rul);
            $this->form_validation->set_rules('tmin','دقائق النهاية','required',$rul);
            $this->form_validation->set_rules('thours','ساعات النهاية','required',$rul);
            $this->form_validation->set_rules('location','العنوان التفصيلي','required',$rul);
            $this->form_validation->set_rules('g_location','الولاية أو المحافظة','required',$rul);
            $this->form_validation->set_rules('search_latitude','عنوان صحيح من الخريطة','required',$rul);
            $this->form_validation->set_rules('search_longitude','عنوان صحيح من الخريطة','required',$rul);
            $this->form_validation->set_rules('fm','نوع الوقت','required|in_list['.$this->main_model->list_rule(array('AM','PM')).']',$rul);
            $this->form_validation->set_rules('tm','نوع الوقت','required|in_list['.$this->main_model->list_rule(array('AM','PM')).']',$rul);
            // Check if validation true
        if($this->form_validation->run() == true){
            $data['p_title'] = $this->input->post('title');
            $data['p_content'] = $this->input->post('content');
            $data['p_mtag'] = $this->input->post('mtag');
            $data['p_subtag'] = $this->input->post('subtag');
            $data['p_tags'] = $this->input->post('tags');
            $data['p_location'] = $this->input->post('location');
            $data['p_g_location'] = $this->input->post('g_location');
            $data['search_latitude'] = $this->input->post('search_latitude');
            $data['search_longitude'] = $this->input->post('search_longitude');
            $data['p_s_date'] = $this->input->post('from').' '.$this->input->post('fhours').':'.$this->input->post('fmin').' '.$this->input->post('fm');
            $data['p_e_date'] = $this->input->post('to').' '.$this->input->post('thours').':'.$this->input->post('tmin').' '.$this->input->post('tm');
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
                            ///*update promo
                            $updateProduct = $this->main_model->update('items','id',$data['item'][0]->id,array(
                                'title' => $data['p_title'],
                                'content' => $data['p_content'],
                                's_date' => $data['p_s_date'],
                                'e_date' => $data['p_e_date'],
                                'location' => $data['p_location'],
                                'g_location' => $data['p_g_location'],
                                'mtag' => $data['p_mtag'],
                                'tags' => $data['p_tags'],
                                'subtag' => $data['p_subtag'],
                                'search_latitude' => $data['search_latitude'],
                                'search_longitude' => $data['search_longitude']
                            ));
                                redirect(base_url().'users/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/done');
                        }
                    // Upload Errors
                        $this->load->view('userarea/promoForm_view', $data);
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
                ///*update promo
                $updateProduct = $this->main_model->update('items','id',$data['item'][0]->id,array(
                    'title' => $data['p_title'],
                    'content' => $data['p_content'],
                    's_date' => $data['p_s_date'],
                    'e_date' => $data['p_e_date'],
                    'location' => $data['p_location'],
                    'g_location' => $data['p_g_location'],
                    'mtag' => $data['p_mtag'],
                    'tags' => $data['p_tags'],
                    'subtag' => $data['p_subtag'],
                    'image' => $data['thumbnails'][1],
                    'search_latitude' => $data['search_latitude'],
                    'search_longitude' => $data['search_longitude']
                ));
                    redirect(base_url().'users/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/done');
                }
        }else{
            $this->load->view('userarea/promoForm_view',$data);
            }
                }elseif($this->uri->segment(5) == 'page'){
                    $data['mtags'] = $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
                foreach($data['mtags'] as $mtag){
                    $data['subtags'] = $this->main_model->getFullRequest('tags','state = 0 AND c_tag = '.$mtag->id);
                    $msubtag[$mtag->id] = $data['subtags'];
                }
            $data['msubtag'] = $msubtag;
            $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة صفحة | موقع وجهتنا';
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'in_list' => 'برجاء اختيار %s موجود.',
                'alpha_numeric' => '%s يجب أن يكون أرقام وحروف فقط',
                'is_unique' => '%s مستخدم من قبل.'
                );
            $data['mtags2'] = (array) $this->main_model->getAllDataCond('tags','state',0,'c_tag',NULL);
            $data['subtags2'] = (array) $this->main_model->getByData('tags','c_tag',$this->input->post('mtag'));
            if($this->input->post('mtag')){
            foreach($data['subtags2'] as $tag){
                $stags[] = $tag->id;
            }}
            foreach($data['mtags2'] as $mtag){
                $mtags[] = $mtag->id;
            }
            $this->form_validation->set_rules('title','عنوان الصفحة','required|alpha_numeric_spaces',$rul);
            $this->form_validation->set_rules('content','وصف الصفحة','required|min_length[100]',$rul);
            if($this->input->post('fb')){
                $this->form_validation->set_rules('fb','facebook','valid_url',$rul);
                $fb = $this->input->post('fb');
            }else{
                $fb = NULL;
            }
            if($this->input->post('instagram')){
                $this->form_validation->set_rules('instagram','instagram','valid_url',$rul);
                $instagram = $this->input->post('instagram');
            }else{
                $instagram = NULL;
            }
            if($this->input->post('twitter')){
                $this->form_validation->set_rules('twitter','twitter','valid_url',$rul);
                $twitter = $this->input->post('twitter');
            }else{
                $twitter = NULL;
            }
            if($this->input->post('yt')){
                $this->form_validation->set_rules('yt','Youtube','valid_url',$rul);
                $yt = $this->input->post('yt');
            }else{
                $yt = NULL;
            }
            if($this->input->post('website')){
                $this->form_validation->set_rules('website','website','valid_url',$rul);
                $website = $this->input->post('website');
            }else{
                $website = NULL;
            }
            $this->form_validation->set_rules('mtag','تصنيف رئيسي','required|in_list['.$this->main_model->list_rule($mtags).']',$rul);
            if($this->input->post('mtag')){
            $this->form_validation->set_rules('subtag','تصنيف فرعي','required|in_list['.$this->main_model->list_rule($stags).']',$rul);
            }
            $this->form_validation->set_rules('tags','الكلمات المفتاحية','required',$rul);
            if($data['item'][0]->username !== $this->input->post('username')){
                $this->form_validation->set_rules('username','رابط الصفحة','required|alpha_numeric|is_unique[pages.username]',$rul);
            }else{
                $this->form_validation->set_rules('username','رابط الصفحة','required|alpha_numeric',$rul);
            }
            
            
            // Check if validation true
        if($this->form_validation->run() == true){
            $data['p_name'] = $this->input->post('title');
            $data['p_desc'] = $this->input->post('content');
            $data['mtag'] = $this->input->post('mtag');
            $data['subtag'] = $this->input->post('subtag');
            $data['tags'] = $this->input->post('tags');
            $data['username'] = $this->input->post('username');
            $data['fb'] = $fb;
            $data['instagram'] = $instagram;
            $data['twitter'] = $twitter;
            $data['yt'] = $yt;
            $data['website'] = $website;
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
                    ///*update promo
                $updateProduct = $this->main_model->update('pages','id',$data['item'][0]->id,array(
                    'p_name' => $data['p_name'],
                    'p_desc' => $data['p_desc'],
                    'mtag' => $data['mtag'],
                    'subtag' => $data['subtag'],
                    'tags' => $data['tags'],
                    'username' => $data['username'],
                    'fb' => $data['fb'],
                    'instagram' => $data['instagram'],
                    'twitter' => $data['twitter'],
                    'yt' => $data['yt'],
                    'website' => $data['website']
                ));
                    
                redirect(base_url().'users/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/done');
                    }
                    // Upload Errors
                        $this->load->view('userarea/pageForm_view', $data);
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
                
                ///*update promo
                $updateProduct = $this->main_model->update('pages','id',$data['item'][0]->id,array(
                    'p_name' => $data['p_name'],
                    'p_desc' => $data['p_desc'],
                    'mtag' => $data['mtag'],
                    'subtag' => $data['subtag'],
                    'tags' => $data['tags'],
                    'username' => $data['username'],
                    'fb' => $data['fb'],
                    'instagram' => $data['instagram'],
                    'twitter' => $data['twitter'],
                    'yt' => $data['yt'],
                    'website' => $data['website'],
                    'logo' => $data['thumbnails'][1]
                ));
                    
                redirect(base_url().'users/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/done');
                }
        }else{
            $this->load->view('userarea/pageForm_view',$data);
            }//
                }elseif($this->uri->segment(5) == 'ticket'){
                    $data['title']='لوحة التحكم في حسابك في موقع وجهتنا - إضافة فعالية | موقع وجهتنا';
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            $perm = $this->main_model->getAllDataCond('items','id',$this->uri->segment(6),'u_id',$userId);
            if($perm){
                $data['item2'] = (array) $perm[0];
            }else{
                redirect(base_url().'404/');
            }
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .',
                'min_length' => '%s قصير جداُ.',
                'alpha_numeric_spaces' => 'لا تدخل رموزاً في %s.',
                'valid_url' => 'برجاء إدخال رابط صالح في %s.',
                'is_natural_no_zero' => 'برجاء إدخال أرقام فقط في خانة %s وتكون أعلى من 1.',
                'less_than_equal_to' => 'يجب أن لا يتخطى قيمة التخفيض سعر التذكرة',
                'numeric' => 'برجاء إدخال أرقام فقط في خانة %s.',
                'in_list' => 'برجاء اختيار %s موجود.'
                );
            $this->form_validation->set_rules('title','اسم التذكرة','required|alpha_numeric_spaces',$rul);
            $this->form_validation->set_rules('price','سعر التذكرة','required',$rul);
            $this->form_validation->set_rules('num','عدد التذاكر المتاحة','required|is_natural_no_zero',$rul);
            $this->form_validation->set_rules('discount','قيمة التخفيض','required|numeric|less_than_equal_to['.$this->input->post('price').']',$rul);
            $data['p_title'] = $this->input->post('title');
            $data['p_price'] = $this->input->post('price');
            $data['p_num'] = $this->input->post('num');
        if($this->form_validation->run() == true){
            // Accepted Validation
            $insert = $this->main_model->update('tickets','id',$data['item'][0]->id,array(
                'title' => $data['p_title'],
                'price' => $data['p_price'],
                'num' => $data['p_num'],
                'discount' => $this->input->post('discount')
            ));
            redirect(base_url().'users/edit/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/done');
        }else{
            $this->load->view('userarea/ticketForm_view',$data);
            }
                }
            }else{
                redirect(base_url().'404/');
            }
        }else{
            redirect(base_url().'404/');
        }
    }
        function settings(){
        if($this->main_model->is_logged_in()){
            // Convert c_balance To a_balance
                if($this->main_model->is_logged_in()){
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $id = $userData['id'];
                }
                $data['title']='اعدادات حسابك موقع وجهتنا | موقع وجهتنا';
                $data['countries'] = $this->main_model->getAllData('countries');
                $data['error'] = '';
                $this->load->view('userarea/userEdit_view',$data);
        }else{
            redirect(base_url().'404/');
        }
    }
    function settingsCheck(){
        if($this->main_model->is_logged_in()){
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
            ///*Form Validation
            $rul=array(
                'required'      => 'يجب عليك إدخال %s .'
                );
            if($userData['oauth_provider'] !== 'facebook'){
            $this->form_validation->set_rules('firstname','الاسم الأول','required',$rul);
            $this->form_validation->set_rules('lastname','الاسم الأخير','required',$rul);
            }
            $this->form_validation->set_rules('country','الدولة','required',$rul);
            $this->form_validation->set_rules('mobile','رقم الهاتف','required',$rul);
            $this->form_validation->set_rules('address','العنوان','required',$rul);
            if(strip_tags($this->input->post('type')) == '1' OR strip_tags($this->input->post('type')) == '2'){
                $this->form_validation->set_rules('c_name','اسم الشركة/المؤسسة','required',$rul);
                $c_name = strip_tags($this->input->post('c_name'));
            }else{
                $c_name = NULL;
            }
            // Check if validation true
        if($this->form_validation->run() == true){
            // Accepted Validation
                //Upload Settings
            $config['upload_path']          = './vendor/uploads/images/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 10240;
                $config['max_width']            = 3000;
                $config['max_height']           = 3000;
                $config['encrypt_name']           = TRUE;
                
                
                $this->load->library('upload', $config);
                
            if ( ! $this->upload->do_upload('userfile'))
                {
                    $data['title']='اعدادات حسابك موقع وجهتنا | موقع وجهتنا';
                    $data['countries'] = $this->main_model->getAllData('countries');
                    $data['error'] = $this->upload->display_errors();
                    
                    if($data['error'] == '<p>You did not select a file to upload.</p>'){
                        //Don`t Need To Change Image
                        $userNewSett = array(
                            'country' => strip_tags($this->input->post('country')),
                            'mobile' => strip_tags($this->input->post('mobile')),
                            'type' => strip_tags($this->input->post('type')),
                            'c_name' => $c_name,
                            'address' => strip_tags($this->input->post('address'))
                        );
                        if($userData['oauth_provider'] !== 'facebook'){
                        $userNewSett['first_name'] = strip_tags($this->input->post('firstname'));
                        $userNewSett['last_name'] = strip_tags($this->input->post('lastname'));
                        }
                        $data['error'] = '';
                        $data['state'] = 1;
                        $this->main_model->update('users','id',$userId,$userNewSett);
                        
                        $this->load->view('userarea/userEdit_view', $data);
                    }else{
                        //Changed Wrong Extinsion
                        //If Statement For Changing Lang
                        if($data['error'] == '<p>The filetype you are attempting to upload is not allowed.</p>'){
                            $data['error']='لقد قمت بإختيار ملف ذو امتداد غير مسموح ... يمكنك تغيير الصورة بـ JPG & PNG فقط.';
                        }
                    $this->load->view('userarea/userEdit_view',$data);
                    }
                }
                elseif($userData['oauth_provider'] !== 'facebook')
                {
                        $data = array('upload_data' => $this->upload->data(),
                                      'countries' => $this->main_model->getAllData('countries'),
                                      'state' => 1,
                                      'error' => $this->upload->display_errors(),
                                      'title' => 'اعدادات حسابك موقع وجهتنا | موقع وجهتنا'
                                     );
                        /// resize
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $data['upload_data']['full_path'];
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['width']         = 50;
                        $config['height']       = 70;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
                        define('PUBPATH',str_replace(SELF,'',FCPATH)); // added
                        $myFile = PUBPATH.'vendor/uploads/images/'.$data['upload_data']['file_name'];
                        $myFile2 = PUBPATH.'vendor/uploads/images/'.$userData['picture'];
                        unlink($myFile) or die("يوجد خطأ ما");
                        if(file_exists($myFile2) == false){
                            unlink($myFile2) or die("يوجد خطأ ما");
                        }
                        $userNewFile1 = explode('.',$data['upload_data']['file_name']);
                        $userNewFile = $userNewFile1[0].'_thumb.'.$userNewFile1[1];
                        $userNewSett = array(
                            'first_name' => strip_tags($this->input->post('firstname')),
                            'last_name' => strip_tags($this->input->post('lastname')),
                            'picture' => $userNewFile,
                            'type' => strip_tags($this->input->post('type')),
                            'c_name' => $c_name,
                            'country' => strip_tags($this->input->post('country')),
                            'mobile' => strip_tags($this->input->post('mobile')),
                            'address' => strip_tags($this->input->post('address')),
                        );
                        
                        $this->main_model->update('users','id',$userId,$userNewSett);
                        
                        $this->load->view('userarea/userEdit_view', $data);
                }
            
            }else{
            $this->settings();
        }
        }else{
            redirect(base_url().'404/');
        }
    }
    public function tickets(){
        if($this->main_model->is_logged_in()){
            $uId = $this->session->userdata('id');
            $config = array();
            $config["base_url"] = base_url() . "users/tickets/";

            $config["total_rows"] = $this->main_model->getFullRequest('p_tickets','u_id = '.$uId.' OR s_id = '.$uId,'count');

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
            
            $data['orders'] = $this->main_model->getFullRequest('p_tickets','(u_id = '.$uId.') OR (s_id = '.$uId.') ORDER BY `id` DESC LIMIT '.$limitval);
            $data["total_rows"] = $config["total_rows"];
            
            $data['title'] = 'تذاكري | موقع وجهتنا';
            $this->load->view('include/header',$data);
            $this->load->view('cpay_view',$data);
            $this->load->view('include/footer',$data);
    }else{
            redirect(base_url().'404/');
        }
    }
    public function getTicket(){
        if($this->main_model->is_logged_in() OR $this->main_model->is_admin_logged_in()){
            $order_id = $this->uri->segment(3);
            if($this->main_model->is_admin_logged_in()){
                $sbId = $this->uri->segment(4);
            }else{
                $sbId = $this->session->userdata('id');
            }
            $order = $this->main_model->getFullRequest('p_tickets','(id = '.$order_id.' AND u_id = '.$sbId.') OR (id = '.$order_id.' AND s_id = '.$sbId.')');
            if($order){
                $item = $this->main_model->getByData('items','id',$order[0]->i_id);
                $user = $this->main_model->getByData('users','id',$order[0]->u_id);
            }else{
                redirect(base_url().'404/');
            }
            $this->load->library('pdf');
            $order_data = array(
                'ticket_id' => $order_id,
                'username' => $user[0]->username,
                'email' => $user[0]->email,
                'google_map_link' => 'https://maps.google.com/maps?q='.$item[0]->search_latitude.', '.$item[0]->search_longitude.'&z=10',
                'date' => $order[0]->date,
                'price' => $order[0]->price,
                'event_link' => base_url().'i/'.str_replace(' ','-',$item[0]->title).'/'.$item[0]->id.'/',
                'num' => $order[0]->num
            );
			$html_content = $this->main_model->getTickets($order_data);
			$this->pdf->loadHtml($html_content);
			$this->pdf->render();
			$this->pdf->stream("".$order_id.".pdf", array("Attachment"=>0));
        }else{
            redirect(base_url().'404/');
        }
    }
    public function qrCode(){
            $this->load->library('Ciqrcode');
            $order_id = explode('.',$this->uri->segment(3));
            QRcode::png(
                $order_id[0],
                $outfile = false,
                $level = QR_ECLEVEL_H,
                $size = 6,
                $margin = 2
            );
    }
    public function bankMyself(){
        if($this->main_model->is_logged_in()){
            $this->main_model->update('users','id',$this->session->userdata('id'),array(
                'rcred' => 'bank'
            ));
            $this->main_model->alert('لقد تم تقديم طلب لتقوم بالتحصيل بنفسك','سيتم إعلامك عند قبول طلبك',$this->session->userdata('id'));
            redirect(base_url().'users/tickets');
        }else{
            redirect(base_url().'404/');
        }
    }
    public function bankUp(){
        $creds = explode(',',$this->session->userdata('cred'));
            if(in_array('bank',$creds)){
                $creded = 1;
            }else{
                $creded = 0;
            }
        if($this->main_model->is_logged_in() && $creded == 1){
            // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
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
            $checkTicket = $this->main_model->getFullRequest('p_tickets','id = '.$this->input->post('p_id').' AND s_id = '.$this->session->userdata('id'));
            if(!$checkTicket){
                redirect(base_url().'users/tickets');
            }else{
                $this->main_model->update('p_tickets','id',$this->input->post('p_id'),array(
                    'state' => 1
                ));
                $uId = $this->session->userdata('id');
                $this->main_model->alert('تم تحصيل الطلبية رقم '.strip_tags($this->input->post('p_id')),'ويمكنك تحميل التذاكر من لوحة التحكم الخاصة بك',$checkTicket[0]->s_id);
                $this->main_model->alert('تم تحصيل الطلبية رقم '.strip_tags($this->input->post('p_id')),'ويمكنك تحميل التذاكر من لوحة التحكم الخاصة بك',$checkTicket[0]->u_id);
                // Here I`ll Send the message.
            // Multiple recipients
            $buyer = $this->main_model->getByData('users','id',$checkTicket[0]->u_id);
            $to = strip_tags($buyer[0]->email); // note the comma

            // Subject
            $subject = 'تم تحصيل طلبية في حسابك | موقع وجهتنا';

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
                قام البائع بتحصيل طلبيتك بنجاح
                </h4>
                <h5 style="
                padding: 10px;
                background: #ddd;
                text-align: center;
                border: 1px solid #b5b5b5;
            ">يٌمكنك تحميل تذاكر طلبيتك من حسابك في الموقع</h5>
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
            $config = array();
            $config["base_url"] = base_url() . "users/tickets/";

            $config["total_rows"] = $this->main_model->getFullRequest('p_tickets','u_id = '.$uId.' OR s_id = '.$uId,'count');

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
            
            $data['orders'] = $this->main_model->getFullRequest('p_tickets','(u_id = '.$uId.') OR (s_id = '.$uId.') ORDER BY `id` DESC LIMIT '.$limitval);
            
            $data["total_rows"] = $config["total_rows"];
            
            $data['title'] = 'تذاكري | موقع وجهتنا';
            $data['state'] = 1;
            $this->load->view('include/header',$data);
            $this->load->view('cpay_view',$data);
            $this->load->view('include/footer',$data);
            }
            }else{
                $this->tickets();
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    public function sells(){
        if($this->main_model->is_logged_in() || $this->main_model->is_admin_logged_in()){
            if($this->main_model->is_admin_logged_in() && $this->uri->segment(3) == 'all'){
                $userda = false;
            }else{
                $userda = $this->main_model->getFullRequest('users','id = '.$this->uri->segment(3));
            }
            
            if(($this->main_model->is_logged_in() && $userda[0]->username == $this->session->userdata('username')) || ($this->main_model->is_admin_logged_in() && isset($userda))){
                $config = array();
                if($this->main_model->is_admin_logged_in() && $this->uri->segment(3) == 'all'){
                    $config["base_url"] = base_url() . "users/sells/all";
                }else{
                    $config["base_url"] = base_url() . "users/sells/".$this->uri->segment(3);
                }

                if($this->main_model->is_admin_logged_in() && $this->uri->segment(3) == 'all'){
                    $config["total_rows"] = $this->main_model->getFullRequest('p_tickets','id IS NOT NULL','count');
                }else{
                    $config["total_rows"] = $this->main_model->getFullRequest('p_tickets','u_id = '.$this->uri->segment(3).' OR s_id = '.$this->uri->segment(3),'count');
                }
                if($this->uri->segment(3) == ''){
                    $config["per_page"] = 12;
                }else{
                    $config["per_page"] = 10;
                }
                $config["uri_segment"] = 1;

                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                if($page){
                    $limitval = $page.','.$config["per_page"];
                }else{
                    $limitval = $config["per_page"];
                }
                
                $data["links"] = $this->pagination->create_links();
                if($this->main_model->is_admin_logged_in() && $this->uri->segment(3) == 'all'){
                    $data['records'] = $this->main_model->getAllDataAdv('p_tickets','id','DESC','','',$config["per_page"],$page,'','');
                }else{
                    $data['records'] = $this->main_model->getFullRequest('p_tickets','(u_id = '.$this->uri->segment(3).') OR (s_id = '.$this->uri->segment(3).') ORDER BY `id` DESC LIMIT '.$limitval);
                }
                
                    $data['title'] = 'المبيعات والمشتريات | موقع وجهتنا';
                    if($this->main_model->is_admin_logged_in()){
                        $this->load->view('admin/include/header',$data);
                        $this->load->view('userarea/sells_view',$data);
                        $this->load->view('admin/include/footer',$data);
                    }else{
                        $this->load->view('include/header',$data);
                        $this->load->view('userarea/sells_view',$data);
                        $this->load->view('include/footer',$data);
                    }
            }else{
                redirect(base_url().'404/');
            }
        }else{
            redirect(base_url().'404/');
        }
    }
    public function activate(){
        if($this->uri->segment(2) == 'reactivate' && $this->main_model->is_logged_in()){
            $data['title']='إعادة تفعيل حسابك في موقع وجهتنا | موقع وجهتنا';
            $userData = (array) $this->main_model->is_logged_in(1)[0];
            $state = $userData['state'];
            $id = $userData['id'];
            if($state == 1){
                // Redirect to profile
            redirect(base_url().'user/');
            }
            $result = $this->main_model->getByData('users_activation','u_id',$id);
            $u_act = (array) $result[0];
            $data['time'] = $u_act['time'];
            $data['code'] = $u_act['code'];
            $this->load->view('activation_view',$data);
        }elseif($this->uri->segment(2) == 'reactivate' && $this->uri->segment(3) == 'sent'){
            $data['title']='إرسال كود تفعيل حسابك في موقع وجهتنا | موقع وجهتنا';
            $this->load->view('activation_view',$data);
        }else{
            $data['title']='تفعيل حسابك في موقع وجهتنا | موقع وجهتنا';
            $data['code']=$this->uri->segment(2);
            $result = $this->main_model->getByData('users_activation','code',$data['code']);
            if($result == true){
                // If Activate code true
                $u_act = (array) $result[0];
                $activate_result = $this->main_model->update('users','id',$u_act['u_id'],array('state'=>1));
                $this->main_model->deleteData('users_activation','code',$data['code']);
                // Redirect to done page
                $data['state']=1;
                $this->load->view('activation_view',$data);
            }else{
                // If Activate code false
                $data['title']='تفعيل حسابك في موقع وجهتنا | موقع وجهتنا';
                $data['state']=0;
                $this->load->view('activation_view',$data);
            }
        }
    }
    
}
?>