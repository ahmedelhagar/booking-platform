<div class="d-content">
    <?php if($this->uri->segment(1) !== 'users'){ ?>
    <div class="col-lg-12 col-md-12 col-sm-12 float-right evnpro-btn py-0 px-0">
                <div class="col-lg-6 col-md-6 col-sm-12 float-right evnts-btn py-0 px-0">
                    <a href="<?php echo base_url().'pages/discover'; ?>" <?php if($this->uri->segment(2) == 'discover' OR $this->uri->segment(2) == 'events'){echo 'class="eva"';} ?> >الفعاليات</a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 float-right pros-btn">
                    <a href="<?php echo base_url().$this->uri->segment(1).'/promos'; ?>" <?php if($this->uri->segment(2) == 'promos'){echo 'class="eva"';} ?>>العروض الترويجية</a> 
                </div>
    </div>
    <?php }else{ ?>
        <div class="user-image">
        <a href="<?php echo base_url().'user/'.$this->uri->segment(3); ?>"><img src="<?php if(isset($user[0]->picture) && $user[0]->picture !== ''){echo $user[0]->picture;}else{echo base_url().'vendor/images/user.png';}; ?>"></a>
        </div>
        <h6 class="text-center"><?php echo $user[0]->username; ?></h6>
    <?php } ?>
    <?php if($this->uri->segment(1) == 'pages'){ ?>
    <div class="all-events">
        <div class="container">
            <h1>كل <?php if($this->uri->segment(2) == 'promos'){echo 'العروض';}else{echo 'الفعاليات';} ?></h1>
            <?php
                    $atrr2 = array(
                        'class' => 'd-form',
                        'method' => 'post'
                    );
                    echo form_open_multipart(base_url().'pages/'.$this->uri->segment(2),$atrr2);

                    echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>');
                    if(isset($error) && $error !== ''){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$error.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }elseif(isset($state) && $state !== ''){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم التحصيل بنجاح
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    } ?>
                <input type="text" id="search_ByState" name="search_for" value="<?php if(get_cookie('search_for') && !$this->input->post('search_for')){echo get_cookie('search_for');}elseif($this->input->post('search_for')){echo $this->input->post('search_for');} ?>" placeholder="ادخل العنوان">
            <!-- search input box -->
                <button class="search-map get_map" style="display:none;" type="submit">
                    ابحث
                </button>
                <!-- display google map -->
                <div id="geomap" style="display:none;"></div>

                <!-- display selected location information -->
                <input type="hidden" class="search_latitude" id="search_latitude" name="search_latitude" size="30" value="<?php if(get_cookie('search_latitude') && !$this->input->post('search_latitude')){echo get_cookie('search_latitude');}elseif($this->input->post('search_latitude')){echo $this->input->post('search_latitude');} ?>">
                <input type="hidden" class="search_longitude" id="search_longitude" name="search_longitude" size="30" value="<?php if(get_cookie('search_longitude') && !$this->input->post('search_longitude')){echo get_cookie('search_longitude');}elseif($this->input->post('search_longitude')){echo $this->input->post('search_longitude');} ?>">
                <div class="form-group">
                    <input class="date" id="datepicker" value="<?php if(get_cookie('date') && !$this->input->post('date')){echo get_cookie('date');}elseif($this->input->post('date')){echo $this->input->post('date');} ?>" name="date" type="text" placeholder="التاريخ">
                    <i class="fa fa-caret-down"></i>
                </div>
            <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn gobtn',
                            'name'=>'submit'
                        );
                            echo form_button($submit,'<span class="fa fa-search"></span> بحث'); ?>
                           <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>
            <?php echo form_close(); ?>
            <ul class="categories">
                <li class="cat<?php if(!get_cookie('mtag')){echo ' c-active';} ?>"><a href="<?php echo base_url().'pages/tag/0/'.$this->uri->segment(2); ?>">كل <?php if($this->uri->segment(2) == 'promos'){echo 'العروض';}else{echo 'الفعاليات';} ?></a></li>
                <?php if($mtags){foreach($mtags as $mtag){ ?>
                <li class="cat<?php if(get_cookie('mtag') == $mtag->id){echo ' c-active';} ?>"><a href="<?php echo base_url().'pages/tag/'.$mtag->id.'/'.$this->uri->segment(2); ?>"><?php echo $mtag->tag; ?></a></li>
                <?php }}; ?>
            </ul>
        </div>
    </div>
    <?php } ?>
    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-12 float-right posts">
            <?php if($this->uri->segment(1) !== 'users'){ ?>
            <div class="col-lg-12 col-md-12 col-sm-12 float-right">
                <div class="posts-num"><?php echo $total_rows; ?> نتيجة</div>
            </div>
            <?php } ?>
                <div class="col-lg-12 col-md-12 col-sm-12 float-right px-0 py-0 posts" id="events-block">
    <?php if($events){foreach($events as $event){
    ?>
        <div class="col-lg-4 col-md-4 col-sm-12 float-right ppost">
            
                <div class="col-lg-12 col-md-12 col-sm-12 float-right post">
                    <img alt="<?php echo $event->title; ?>" src="<?php echo base_url(); ?>vendor/uploads/images/<?php echo $this->main_model->vthumb($event->image); ?>">
                    <div class="title-desc">
                        <h6 class="p-title"><a href="<?php
                echo base_url().'i/'.str_replace(' ','-',$event->title).'/'.$event->id.'/';
                ?>"><?php
    if(strlen($event->title) <= 36){
        echo $event->title;}
    else{echo substr($event->title,0,33).'...';}
                            ?></a></h6>
                        <div class="p-desc">
                            <p class="mb-0">تبدأ في <?php echo $event->s_date; ?></p>
                            <p class="mb-0"><?php
    if(strlen($event->g_location) <= 28){
        echo $event->g_location;}
    else{echo substr($event->g_location,0,25).'...';} ?></p>
                        </div>
                        <div class="price">
                        <?php
                            $tickets = $this->main_model->getByData('tickets','i_id',$event->id);
                            if($tickets){
                                foreach($tickets as $ticket){
                                $prices[] = $ticket->price;
                                $discounts[] = $ticket->discount;
                            }
                             $prices_num = count($prices);
                             if($prices_num>1){
                         if($ticket->discount !== '0'){ ?>
                            <div class="vit-price<?php if($ticket->discount !== 0){echo ' line-thought';} ?>"><?php echo $prices[0].' - '.$prices[$prices_num-1].' SR'; ?></div>
                        <?php }
                                 if($discounts[0] == '0'){
                                     $dis0 = $prices[0];
                                 }else{
                                     $dis0 = $prices[0]-$discounts[0];
                                 }
                                 if($discounts[$prices_num-1] == '0'){
                                     $disnum = $prices[$prices_num-1];
                                 }else{
                                     $disnum = $prices[$prices_num-1]-$discounts[$prices_num-1];
                                 }
                                 echo $dis0.' - '.$disnum.' SR';
                                 $prices = array();
                                 $discounts = array();
                             }else{
                                 if($discounts[0] == '0'){
                                     $dis0 = $prices[0];
                                 }else{
                                     $dis0 = $prices[0]-$discounts[0];
                                 }
                         if($ticket->discount !== '0'){ ?>
                            <div class="vit-price<?php if($ticket->discount !== 0){echo ' line-thought';} ?>"><?php echo $prices[0].' SR'; ?></div>
                        <?php }
                                 echo $dis0.' SR';
                                 $prices = array();
                                 $discounts = array();
                             }
                            }else{
                                echo '0 SR';
                            }
                        ?>
                        
                        </div>
                    </div>
                    <?php if($event->state == 7){
                        echo '<code>هذا العنصر محذوف لكن تم الاحتفاظ به لأغراض إحصائية</code>';
                        }else{if($this->uri->segment(1) == 'users' && $this->session->userdata('id') == $user[0]->id){ ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'users/edit/items/'.$event->id.'/event/'; ?>"><span class="fa fa-cog"></span> تعديل</a></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'users/delete/items/'.$event->id.'/?m=users/'.$this->uri->segment(2).'/'.$this->session->userdata('username'); ?>"><span class="fa fa-trash"></span> حذف</a></div>
                    <?php }elseif($this->main_model->is_admin_logged_in() && $this->uri->segment(1) == 'wjhatnacadmin'){ ?>
                    <?php if($event->state == 0){ ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'wjhatnacadmin/publish/'.$event->id.'/'.$this->uri->segment(2); ?>"><span class="fa fa-bullhorn"></span> نشر</a></div>
                    <?php } ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'wjhatnacadmin/delete/items/'.$event->id.'/?m=wjhatnacadmin/'.$this->uri->segment(2); ?>"><span class="fa fa-trash"></span> حذف</a></div>
                    <?php }} ?>
                </div>
            
            <?php if($this->main_model->is_logged_in() OR $this->main_model->is_admin_logged_in()){ ?>
            <?php if($this->uri->segment(1) == 'users' OR $this->uri->segment(1) == 'wjhatnacadmin'){
            if($this->session->userdata('id') == $event->u_id OR $this->uri->segment(1) == 'wjhatnacadmin'){
                
                $visits = $this->main_model->getFullRequest('visits','i_id = '.$event->id,'count');
                $unpaid = $this->main_model->getFullRequest('p_tickets','state = 0 AND i_id = '.$event->id,'count');
                $paid = $this->main_model->getFullRequest('p_tickets','state = 1 AND i_id = '.$event->id,'count');
                if($visits == null){
                    $visits=0;
                }
                if($unpaid == null){
                    $unpaid=0;
                }
                if($paid == null){
                    $paid=0;
                }
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 float-right">
                <div class="col-lg-4 col-md-4 col-sm-12 float-right stats-item">
                    <span class="si-desc"><?php echo $visits; ?></span>
                    <span class="si-tit">زيارة</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 float-right stats-item">
                    <span class="si-desc"><?php echo $unpaid; ?></span>
                    <span class="si-tit">حجز</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 float-right stats-item">
                    <span class="si-desc"><?php echo $paid; ?></span>
                    <span class="si-tit">بيع</span>
                </div>
            </div>
            <?php }} ?>
            <?php } ?>
        </div>
    <?php
    }}else{ echo '<h3>لا يوجد مواضيع - فارغ -.</h3>'; } ?>
        <!-- Pagination -->
      <ul class="pagination justify-content-center pager"><?php echo $links; ?></ul>
    </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 float-right">
            <div class="discov">
                <h5>اكتشف.</h5>
                <h5>خطط.</h5>
                <h5>استمتع.</h5>
                    <div class="_1st-getit">
                          <a href="#">
                              <img src="<?php echo base_url(); ?>vendor/images/gplay.png" class="getit-btn">
                          </a>
                          <a href="#">
                              <img src="<?php echo base_url(); ?>vendor/images/appstore.png" class="getit-btn">
                          </a>
                    </div>
            </div>
        </div>
    </div>
</div>