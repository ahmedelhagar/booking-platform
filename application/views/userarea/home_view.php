<?php
if($this->main_model->is_logged_in()){
    // Logged In
    if($this->session->userdata('username') == $this->uri->segment(2)){
        //Same User
        $sameOr = $this->main_model->getByData('users','id',$this->session->userdata('id'));
        $sameUser = 1;
    }else{
        //Logged In Not Same User
        $sameOr = $this->main_model->getByData('users','id',$this->uri->segment(2));
        $sameUser = 0;
    }
}else{
    //Not Logged
        $sameOr = $this->main_model->getByData('users','username',$this->uri->segment(2));
    $sameUser = 0;
}
?>
<div class="container-fluid allUsers">
    <div class="user-image">
        <a href="#"><img src="<?php if($user[0]->picture !== '' && $user[0]->oauth_provider == 'facebook'){echo $user[0]->picture;}elseif($user[0]->picture == ''){echo base_url().'vendor/images/user.png';}else{echo base_url().'vendor/uploads/images/'.$user[0]->picture;}; ?>"></a>
    </div>
    <h6><?php echo $user[0]->username; ?></h6>
        <?php
        $events = $this->main_model->getFullRequest('items','u_id = '.$user[0]->id.' AND type = 0','count');
        if($events){
            $eventsNum = $events;
        }else{
            $eventsNum = 0;
        }
        $promos = $this->main_model->getFullRequest('items','u_id = '.$user[0]->id.' AND type = 1','count');
        if($promos){
            $promosNum = $promos;
        }else{
            $promosNum = 0;
        }
        $tickets = $this->main_model->getFullRequest('p_tickets','u_id = '.$user[0]->id.' OR s_id = '.$user[0]->id,'count');
        if($tickets){
            $ticketsNum = $tickets;
        }else{
            $ticketsNum = 0;
        }
        $pages = $this->main_model->getFullRequest('pages','u_id = '.$user[0]->id,'count');
        if($pages){
            $pagesNum = $pages;
        }else{
            $pagesNum = 0;
        }
    ?>
    <?php
        $creds = explode(',',$user[0]->cred);
            if(in_array('events',$creds)){
    ?>
    <div class="col-lg-4 col-md-4 col-sm-12 s-pro">
        <div class="col-lg-12 col-md-12 col-sm-12 s_block">
            <div class="col-lg-12 col-md-12 col-sm-12 h_block float-right">
                <a href="<?php echo base_url().'users/events/'.$this->uri->segment(2); ?>">
                    <h3>الفعاليات</h3>
                    <h1><?php echo $eventsNum; ?></h1>
                </a>
            </div>
            <?php 
            if($sameUser){
            ?>
            <a href="<?php echo base_url().'users/pages/'.$this->session->userdata('username'); ?>">
                <div class="col-lg-12 col-md-12 col-sm-12 b_blocks float-right">
                    <span class="fa fa-plus-circle"></span>
                    أضف فعالية
                </div>
            </a>
            <?php } ?>
        </div>
    </div>
    <?php
            }
    ?>
    <?php
        $creds = explode(',',$user[0]->cred);
            if(in_array('promos',$creds)){
    ?>
    <div class="col-lg-4 col-md-4 col-sm-12 s-pro">
        <div class="col-lg-12 col-md-12 col-sm-12 s_block">
            <div class="col-lg-12 col-md-12 col-sm-12 h_block float-right">
                <a href="<?php echo base_url().'users/promos/'.$this->uri->segment(2); ?>">
                    <h3>العروض الترويجية</h3>
                    <h1><?php echo $promosNum; ?></h1>
                </a>
            </div>
            <?php 
            if($sameUser){
            ?>
            <a href="<?php echo base_url().'users/pages/'.$this->session->userdata('username'); ?>">
                <div class="col-lg-12 col-md-12 col-sm-12 b_blocks float-right">
                    <span class="fa fa-plus-circle"></span>
                    أضف عرض ترويجي
                </div>
            </a>
            <?php } ?>
        </div>
    </div>
    <?php
            }
    if($sameUser){
    ?>
    
    <div class="col-lg-4 col-md-4 col-sm-12 s-pro">
        <div class="col-lg-12 col-md-12 col-sm-12 s_block">
            <div class="col-lg-12 col-md-12 col-sm-12 h_block float-right">
                <a href="<?php echo base_url().'users/tickets'; ?>">
                    <h3>تذاكري</h3>
                    <h1><?php echo $ticketsNum; ?></h1>
                </a>
            </div>
            <?php 
            if($sameUser){
            ?>
            <a href="<?php echo base_url().'pages/discover'; ?>">
                <div class="col-lg-12 col-md-12 col-sm-12 b_blocks float-right">
                    <span class="fa fa-search"></span>
                     تصفح لشراء تذكرة
                </div>
            </a>
            <?php } ?>
        </div>
    </div>
    
    <?php
    }
        $creds = explode(',',$user[0]->cred);
            if(in_array('events',$creds)){
    ?>
    <div class="col-lg-4 col-md-4 col-sm-12 s-pro">
        <div class="col-lg-12 col-md-12 col-sm-12 s_block">
            <div class="col-lg-12 col-md-12 col-sm-12 h_block float-right">
                <a href="<?php echo base_url().'users/pages/'.$this->uri->segment(2); ?>">
                    <h3>الصفحات</h3>
                    <h1><?php echo $pagesNum; ?></h1>
                </a>
            </div>
            <?php 
            if($sameUser){
            ?>
            <a href="<?php echo base_url().'users/addPage'; ?>">
                <div class="col-lg-12 col-md-12 col-sm-12 b_blocks float-right">
                    <span class="fa fa-plus-circle"></span>
                     أضف صفحة
                </div>
            </a>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    <?php
        $creds = explode(',',$user[0]->cred);
            if(in_array('events',$creds) OR in_array('promos',$creds)){
                if($sameUser){
    ?>
    <div class="col-lg-4 col-md-4 col-sm-12 s-pro">
        <div class="col-lg-12 col-md-12 col-sm-12 s_block">
            <div class="col-lg-12 col-md-12 col-sm-12 h_block float-right">
                <a href="<?php echo base_url().'users/sells/'.$user[0]->id; ?>">
                    <h3>المبيعات والمشتريات</h3>
                    <h1><?php echo $ticketsNum; ?></h1>
                </a>
            </div>
        </div>
    </div>
    <?php }} ?>
</div>