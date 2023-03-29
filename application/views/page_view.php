<?php $this->load->view('include/header.php'); ?>
<div class="container-fluid allUsers">
    <br />
    <?php 
        if($page[0]){
        ?>
    <div class="col-lg-4 col-md-4 col-sm-12 float-right pad-page">
        <div class="col-lg-12 col-md-12 col-sm-12 page">
            <div class="page-image"><img src="<?php echo base_url().'vendor/uploads/images/'.$this->main_model->vthumb($page[0]->logo); ?>"></div>
            <h6><a href="<?php echo base_url().'p/'.$page[0]->username; ?>"><?php echo $page[0]->p_name; ?> <span class="fa fa-caret-left"></span></a></h6>
            <div class="followers">
                <?php if($this->session->userdata('id') == $page[0]->u_id){ ?>
                <div class="follow float-right"><a href="<?php echo base_url().'users/addEvent/'.$page[0]->id; ?>"><span class="fa fa-plus"></span> أضف فعالية</a></div>
                <div class="follow float-right"><a href="<?php echo base_url().'users/addPromo/'.$page[0]->id; ?>"><span class="fa fa-plus"></span> أضف عرض</a></div>
                <div class="float-right container-fluid" style="margin-top:10px;">
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'users/edit/pages/'.$page[0]->id.'/page/'; ?>"><span class="fa fa-cog"></span> تعديل</a></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'users/delete/pages/'.$page[0]->id.'/?m=users/pages/'.$this->session->userdata('username'); ?>"><span class="fa fa-trash"></span> حذف</a></div>
                </div>
                <?php }else{ $followers = $this->main_model->getFullRequest('followers','p_id = '.$page[0]->id,'count');
                if($followers == null){
                    $followers = 0;
                }
                ?>
                <div class="followers-num"><span id="f-num"><?php echo $followers; ?></span> متابع</div>
                <?php
                    if($this->main_model->is_logged_in()){
                    $followed = $this->main_model->getFullRequest('followers','f_id = '.$this->session->userdata('id').' AND p_id = '.$page[0]->id);
                    if(!$followed){
                ?>
                <div id="follow-btn" onclick="return follow('<?php echo $page[0]->id; ?>')" class="follow"><span class="fa fa-plus"></span> متابعة</div>
                <?php }else{ ?>
                <div id="follow-btn" onclick="return follow('<?php echo $page[0]->id; ?>')" class="follow"><span class="fa fa-trash"></span> إلغاء متابعة</div>
                <?php }}else{ ?>
                <div id="follow-btn" onclick="return follow('<?php echo $page[0]->id; ?>')" class="follow"><span class="fa fa-plus"></span> متابعة</div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    }else{}
    ?>
    <div class="col-lg-8 col-md-8 col-sm-12 float-right">
        <div class="container text-center">
        <div class="f_item">
                    <h3>
                        <a href="<?php echo $page[0]->instagram; ?>"><span class="fab fa-instagram"></span></a>
                        <a href="<?php echo $page[0]->fb; ?>"><span class="fab fa-facebook"></span></a>
                        <a href="<?php echo $page[0]->twitter; ?>"><span class="fab fa-twitter"></span></a>
                        <a href="<?php echo $page[0]->yt; ?>"><span class="fab fa-youtube"></span></a>
                        <a href="<?php echo $page[0]->website; ?>"><span class="fa fa-link"></span></a>
                   </h3>
        </div>
        </div>
            <div class="col-lg-6 col-md-6 col-sm-12 float-right r-type2 evpro-active" id="events-block-btn">
                <p>فعاليات</p>
                <p>الصفحة</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 float-right r-type2" id="promos-block-btn">
                <p>عروض</p>
                <p>الصفحة</p>
            </div>
    </div>
    
    <div class="col-lg-8 col-md-8 col-sm-12 float-right posts" id="events-block">
        
    <?php if($events){foreach($events as $event){
    ?>
        <div class="col-lg-4 col-md-4 col-sm-12 float-right ppost">
                <div class="col-lg-12 col-md-12 col-sm-12 float-right post">
                    <img src="<?php echo base_url(); ?>vendor/uploads/images/<?php echo $this->main_model->vthumb($event->image); ?>">
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
    if(strlen($event->g_location) <= 36){
        echo $event->g_location;}
    else{echo substr($event->g_location,0,30).'...';} ?></p>
                        </div>
                        <div class="price">
                        <?php
                            $tickets = $this->main_model->getByData('tickets','i_id',$event->id);
                            if($tickets){foreach($tickets as $ticket){
                                $prices[] = $ticket->price;
                            }
                             $prices_num = count($prices);
                             if($prices_num>1){
                                 echo $prices[0].' - '.$prices[$prices_num-1];
                             }else{
                                 echo $prices[0];
                             }
                            }else{
                                echo 0;
                            }
                        ?> SR
                        </div>
                    </div>
                    <?php if($event->state == 7){
                        echo '<code>هذا العنصر محذوف لكن تم الاحتفاظ به لأغراض إحصائية</code>';
                        }else{if($this->session->userdata('id') == $event->u_id){ ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'users/edit/items/'.$event->id.'/event/'; ?>"><span class="fa fa-cog"></span> تعديل</a></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'users/delete/items/'.$event->id.'/?m=p/'.$this->uri->segment(2); ?>"><span class="fa fa-trash"></span> حذف</a></div>
                    <?php }} ?>
                </div>
            </div>
    <?php
    }}else{echo '<h3>لايوجد فعاليات</h3>';} ?>
        <!-- Pagination -->
      <ul class="pagination justify-content-center pager"><?php echo $links; ?></ul>
    </div>
    
    <div class="col-lg-8 col-md-8 col-sm-12 float-right posts" id="promos-block">
    <?php if($promos){foreach($promos as $promo){
    ?>
        <div class="col-lg-4 col-md-4 col-sm-12 float-right ppost">
                <div class="col-lg-12 col-md-12 col-sm-12 float-right post">
                    <img src="<?php echo base_url(); ?>vendor/uploads/images/<?php echo $this->main_model->vthumb($promo->image); ?>">
                    <div class="title-desc">
                        <h6 class="p-title"><a href="<?php
                echo base_url().'i/'.str_replace(' ','-',$promo->title).'/'.$promo->id.'/';
                ?>"><?php
    if(strlen($promo->title) <= 36){
        echo $promo->title;}
    else{echo substr($promo->title,0,33).'...';}
                            ?></a></h6>
                        <div class="p-desc">
                            <p class="mb-0">تبدأ في <?php echo $promo->s_date; ?></p>
                            <p class="mb-0"><?php
    if(strlen($promo->g_location) <= 33){
        echo $promo->g_location;}
    else{echo substr($promo->g_location,0,30).'...';} ?></p>
                        </div>
                        <div class="price">
                        <?php
                            $tickets = $this->main_model->getByData('tickets','i_id',$promo->id);
                            if($tickets){foreach($tickets as $ticket){
                                $prices[] = $ticket->price;
                            }
                             $prices_num = count($prices);
                             if($prices_num>1){
                                 echo $prices[0].' - '.$prices[$prices_num-1];
                             }else{
                                 echo $prices[0];
                             }
                            }else{
                                echo 0;
                            }
                        ?> SR
                        </div>
                    </div>
                    <?php if($event->state == 7){
                        echo '<code>هذا العنصر محذوف لكن تم الاحتفاظ به لأغراض إحصائية</code>';
                        }else{if($this->session->userdata('id') == $promo->u_id){ ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'users/edit/items/'.$promo->id.'/promo/'; ?>"><span class="fa fa-cog"></span> تعديل</a></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'users/delete/items/'.$promo->id.'/?m=p/'.$this->uri->segment(2); ?>"><span class="fa fa-trash"></span> حذف</a></div>
                    <?php }} ?>
                </div>
            </div>
    <?php
    }}else{echo '<h3>لايوجد عروض</h3>';} ?>
        <!-- Pagination -->
      <ul class="pagination justify-content-center pager"><?php echo $links; ?></ul>
    </div>
    
</div>
<?php $this->load->view('include/footer.php'); ?>