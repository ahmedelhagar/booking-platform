<div class="container-fluid item-pub">
    <?php
        $tickets = $this->main_model->getByData('tickets','i_id',$item[0]->id);
    $this->main_model->insertData('visits',array(
        'ip' => $this->input->ip_address(),
        'i_id' => $item[0]->id
    ));
    ?>
    <div class="col-lg-8 col-md-8 col-sm-12 v-itemp">
        <div class="col-lg-12 col-md-12 col-sm-12 v-item">
        <?php
        if($item[0]->state == 7){
            redirect(base_url().'404/');
        }
        ?>
            <img alt="<?php echo $item[0]->title; ?>" class="vi-image" src="<?php echo base_url().'vendor/uploads/images/'.$item[0]->image; ?>">
            <h3 class="item-head"><?php echo $item[0]->title; ?></h3>
            <h6 class="pxy-10 by-user">بواسطة صفحة <a href="<?php echo base_url().'p/'.$page[0]->username; ?>"><?php echo $page[0]->p_name; ?></a></h6>
            <ul class="vi-det">
                <li class="vi-i"><span class="fa fa-clock-o"></span> <div class="se_date"><?php echo $item[0]->s_date.
        ' - '.$item[0]->e_date; ?></div></li>
                <li class="vi-i"><span class="fa fa-map-pin"></span> <?php echo $item[0]->g_location; ?></li>
                <li class="vi-i"><span class="fa fa-id-card"></span> <?php
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
                        ?></li>
            </ul>
            <?php if($tickets){ ?>
                <div class="col-lg-12 col-md-12 col-sm-12 vi-tickets">
                <h3 class="item-head">التذاكر</h3>
                    <?php 
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    if($this->uri->segment(2) == 'buyCheck'){
                        $contin = $this->uri->segment(3).'/'.$this->uri->segment(4);
                    }else{
                        $contin = $this->uri->segment(2).'/'.$this->uri->segment(3);
                    }
                    echo form_open_multipart(base_url().'pages/buyCheck/'.$contin,$atrr2);

                    echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>');
                    if(isset($error) && $error !== ''){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$error.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                   ?>
                    <input type="hidden" value="<?php echo $item[0]->id; ?>" name="itemId">
                <?php foreach($tickets as $ticket){ ?>
                    <?php
                        $paid = $this->main_model->getFullRequest('p_tickets','t_id = '.$ticket->id.' AND state = 1');
                       $paidTickets = 0;
                       if($paid){
                           foreach($paid as $paidtick){
                           $paidTickets += $paidtick->num;
                       }}
                       if($paidTickets == $ticket->num && $paidTickets !== '0'){
                           $disabled = 1;
                       }else{
                           $disabled = 0;
                       }
                    ?>
                    <div class="vi-ticket">
                        <div class="col-lg-8 col-md-8 col-sm-12 float-right vitp" <?php if($disabled){echo 'style="color:#b1b1b1;cursor: not-allowed;"';} ?>><h6><?php echo $ticket->title; ?><?php if($disabled){echo ' - مباعة';} ?></h6>
                            <div class="float-left">
                                <div class="vit-price<?php if($ticket->discount){echo ' line-thought';} ?>"><?php echo $ticket->price.' SR'; ?></div>
                                <?php if($ticket->discount){ ?>
                                    <div class="vit-price"><?php echo $ticket->price-$ticket->discount.' SR'; ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 float-right col-auto">
                          <label class="sr-only" for="inlineFormInputGroup">0</label>
                          <div class="input-group mb-2">
                            <div class="input-group-prepend">
                              <div class="input-group-text">الكمية</div>
                            </div>
                            <input<?php if($disabled){echo ' disabled style="cursor: not-allowed;"';} ?> min="0" max="<?php echo $ticket->num; ?>" name="t<?php echo $ticket->id; ?>" type="number" class="form-control" id="inlineFormInputGroup" placeholder="0">
                          </div>
                        </div>
                    </div>
            <?php } ?>
                    <?php if($item[0]->state == '1'){ ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 float-right">
                        <?php
                       $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn buy-tickets',
                            'name'=>'submit'
                        );
                            echo form_button($submit,'<span class="fa fa-pay"></span> شراء');
?>

                        <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>
                        <p class="container-fluid">طريقة الدفع المتوفرة حالياً هي - عند الإستلام - ... إذا قمت بالشراء سيتم إعطائك كود الدفع.</p>
                    </div>
                    <?php }else{
                       echo 'لايمكنك الشراء ... لم تقم الإدارة بالموافقة على النشر بعد.';
                   } ?>
                        <?php echo form_close(); ?>
                </div>
              <?php } ?>
            <h3 class="item-head"><?php if($item[0]->state == '0'){echo 'لايمكنك الشراء ... لم تقم الإدارة بالموافقة على النشر بعد.';} ?></h3>
            <pre><h3 class="item-head"><?php echo $item[0]->title; ?></h3><?php echo $item[0]->content; ?></pre>
            <iframe src="https://maps.google.com/maps?q=<?php echo $item[0]->search_latitude; ?>, <?php echo $item[0]->search_longitude; ?>&z=10&output=embed" class="vi-map" frameborder="0" style="border:0"></iframe>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 float-right publisher">
        <?php 
        if($page[0]){
        ?>
        <div class="col-lg-12 col-md-12 col-sm-12 page">
            <div class="page-image"><img src="<?php echo base_url().'vendor/uploads/images/'.$this->main_model->vthumb($page[0]->logo); ?>"></div>
            <h6><a href="<?php echo base_url().'p/'.$page[0]->username; ?>"><?php echo $page[0]->p_name; ?> <span class="fa fa-caret-left"></span></a></h6>
            <div class="followers">
                <?php if($this->session->userdata('id') == $page[0]->u_id){ ?>
                <div class="follow float-right"><a href="<?php echo base_url().'users/addEvent/'.$page[0]->id; ?>"><span class="fa fa-plus"></span> أضف فعالية</a></div>
                <div class="follow float-right"><a href="<?php echo base_url().'users/addPromo/'.$page[0]->id; ?>"><span class="fa fa-plus"></span> أضف عرض</a></div>
                <div class="follow"><span class="fa fa-cog"></span> تعديل</div>
                <?php }else{
                $followers = $this->main_model->getFullRequest('followers','p_id = '.$page[0]->id,'count');
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
    <?php
    }else{ ?>
    <?php }
    ?>
    </div>
</div>