<div class="container-fluid search-view">
    <div class="col-lg-8 col-md-8 col-sm-12 container-auto">
            <div class="col-lg-12 col-md-12 col-sm-12 float-right search-form">
            <?php
            $atrr2 = array(
                'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                'method' => 'get'
            );
                if($this->uri->segment(3) == 'promos'){
                    $type = $this->uri->segment(3);
                }else{
                    $type = '';
                }
            echo form_open_multipart(base_url().'pages/searchCheck/'.$type,$atrr2);

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
            }
            ?>
    <div class="form-group" style="position: relative;">
    <input style="height: 70px;" placeholder="كلمة البحث" value="<?php if($this->input->get('search_for')){echo $this->input->get('search_for');} ?>" type="text" class="form-control input-lg search_for search_for_" name="search_for" required="" autocomplete="off">
      <i class="fa fa-search search_for-i"></i>
      <i class="close_for-i"><a href="<?php echo base_url(); ?>">إغلاق</a></i>
      </div>
            <?php
            echo form_close();
            ?>
        </div>
        <div class="cat-url">
            <a<?php if($this->uri->segment(3) !== 'promos'){echo ' class="cat-active"';} ?> href="<?php echo base_url().'pages/search'; ?>">الفعاليات</a>
            <a<?php if($this->uri->segment(3) == 'promos'){echo ' class="cat-active"';} ?> href="<?php echo base_url().'pages/search/promos'; ?>">العروض</a>
        </div>
        <h3 class="container-fluid float-right text-center">البحث في موقع وجهتنا.</h3>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 float-right px-0 py-0 posts" id="events-block">
    <?php if($search){foreach($search as $item){ ?>
        <div class="col-lg-3 col-md-3 col-sm-12 float-right ppost">
                <div class="col-lg-12 col-md-12 col-sm-12 float-right post">
                    <img src="<?php echo base_url(); ?>vendor/uploads/images/<?php echo $this->main_model->vthumb($item->image); ?>">
                    <div class="title-desc">
                        <h6 class="p-title"><a href="<?php
                echo base_url().'i/'.str_replace(' ','-',$item->title).'/'.$item->id.'/';
                ?>"><?php
    if(strlen($item->title) <= 36){
        echo $item->title;}
    else{echo substr($item->title,0,33).'...';}
                            ?></a></h6>
                        <div class="p-desc">
                            <p class="mb-0">تبدأ في <?php echo $item->s_date; ?></p>
                            <p class="mb-0"><?php
    if(strlen($item->g_location) <= 28){
        echo $item->g_location;}
    else{echo substr($item->g_location,0,25).'...';} ?></p>
                        </div>
                        <div class="price">
                        <?php
                            $tickets = $this->main_model->getByData('tickets','i_id',$item->id);
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
                    <?php if($this->uri->segment(1) == 'users' && $this->session->userdata('id') == $user[0]->id){ ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'users/edit/items/'.$item->id.'/event/'; ?>"><span class="fa fa-cog"></span> تعديل</a></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'users/delete/items/'.$item->id.'/?m=users/events/'.$this->session->userdata('username'); ?>"><span class="fa fa-trash"></span> حذف</a></div>
                    <?php }elseif($this->main_model->is_admin_logged_in() && $this->uri->segment(1) == 'wjhatnacadmin'){ ?>
                    <?php if($item->state == 0){ ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'wjhatnacadmin/publish/'.$item->id.'/'.$this->uri->segment(2); ?>"><span class="fa fa-bullhorn"></span> نشر</a></div>
                    <?php } ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'wjhatnacadmin/delete/items/'.$item->id.'/?m=wjhatnacadmin/'.$this->uri->segment(2); ?>"><span class="fa fa-trash"></span> حذف</a></div>
                    <?php } ?>
                </div>
            </div>
    <?php
    }} ?>
        <!-- Pagination -->
      <ul class="pagination justify-content-center pager"><?php //echo $links; ?></ul>
    </div>
</div>