<div class="container-fluid allUsers">
    <?php $Buser = (array) $this->main_model->getByData('users','id',$this->session->userdata('id'))[0]; ?>
    <?php $ettings = (array) $this->main_model->getByData('settings','id',1)[0]; ?>
    <div class="col-lg-8 col-md-8 col-sm-12 float-right">
        <?php if($orders){foreach($orders as $order){
          $item = (array) $this->main_model->getByData('items','id',$order->i_id)[0];
          if($item){
            $user = (array) $this->main_model->getByData('users','id',$order->s_id)[0];
            $Buser = (array) $this->main_model->getByData('users','id',$order->u_id)[0];
            $country = (array) $this->main_model->getByData('countries','code',$user['country'])[0];
            $Bcountry = (array) $this->main_model->getByData('countries','code',$Buser['country'])[0];
        ?>
            <div class="col-lg-12 col-md-12 col-sm-12 float-right order" <?php if(isset($item['u_id'])){if($this->session->userdata('id') == $item['u_id'] AND $order->u_id !== $order->s_id AND $order->state == 1){echo 'style="border: 2px solid #35bb52;"';}elseif($this->session->userdata('id') == $item['u_id'] AND $order->u_id !== $order->s_id AND $order->state == 0){echo 'style="border: 2px solid red;"';}} ?>>
                <h3 class="o-dets">
                    <?php
                        if($this->session->userdata('id') == $item['u_id']){
                            echo 'طلب دفع';
                            if($order->u_id == $order->s_id){
                                echo ' وحجز';
                            }
                        }else{
                            echo 'حجز';
                        }
                    ?>
                </h3>
                <?php $ticket = (array) $this->main_model->getByData('tickets','id',$order->t_id)[0]; ?>
                <h3 class="o-dets"><?php echo $order->num.' X '.$order->price.' SR'; ?></h3>
                <p>من <?php echo $ticket['title']; ?></p>
                <h3>الإجمالي :
                    <?php echo $order->num*$order->price; ?> 
                    ريال سعودي
                </h3>
                <h3>كود الطلب</h3>
                <h3 class="o-dets"><?php echo '#TW - '.$order->id; ?></h3>
                <?php if($this->uri->segment(1) == 'users'){ ?>
                <div class="mb-0">
                    
                    الفعالية/العرض:
                    <h3 class="o-dets"><a href="<?php
                echo base_url().'i/'.str_replace(' ','-',$item['title']).'/'.$item['id'].'/';
                ?>"><?php echo $item['title']; ?></a></h3>
                    <?php
                    if($order->u_id == $order->s_id){
                         echo '<h3 class="o-dets">لقد تم هذا الحجز من خلال حسابك على تذكرة من انتاجك</h3>';
                        }elseif($order->u_id !== $order->s_id AND $order->s_id !== $this->session->userdata('id')){
                          if($item['pay']){
                              ?>
                            للدفع والإستعلام - 
                          البريد الإلكتروني: <?php echo $ettings['email']; ?> | رقم الهاتف : <?php echo $ettings['mobile']; ?>
                          <?php
                          }else{
                          ?>
                        للدفع والإستعلام - 
                          البريد الإلكتروني: <?php echo $user['email']; ?> | رقم الهاتف : <?php echo $country['tel'].$user['mobile'].'+'; ?>
                          <?
                          }}
                        if($this->session->userdata('id') == $item['u_id']){
                            ?>
                     بيانات المشتري - 
                    البريد الإلكتروني: <?php echo $Buser['email']; ?> | رقم الهاتف : <?php echo $Bcountry['tel'].$Buser['mobile'].'+'; ?>
                    <?php
                        }
                      ?>
                  </div>
                <?php } ?>
                <?php if($order->state == 1){ ?>
                <a target="_blank" class="btn btn-success" href="<?php echo base_url().'users/getTicket/'.$order->id; ?>"><span class="fa fa-ticket"></span> تحميل التذاكر</a>
                <?php } ?>
            </div>
        <?php }}}else{echo '<h3 class="text-center">لايوجد تذاكر تخص حسابك</h3>';} ?>
        <!-- Pagination -->
      <ul class="pagination justify-content-center pager"><?php if($links){echo $links;} ?></ul>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 float-right">
        <?php if($this->uri->segment(1) == 'pages'){ ?>
        <div class="alert alert-success" role="alert">
          <h4 class="alert-heading">تم الحجز بنجاح</h4>
          <p>لقد تم حجز طلبك بنجاح يمكنك انتظار مكالمتنا أو تواصل معنا عن طريق البيانات التالية.</p>
          <hr>
          <p class="mb-0">
            <?php
                  $item = (array) $this->main_model->getByData('items','id',$order->i_id)[0];
                  $user = (array) $this->main_model->getByData('users','id',$item['u_id'])[0];
                  if($item['pay']){
                      ?>
                  البريد الإلكتروني: <?php echo $ettings['email']; ?> | رقم الهاتف : <?php echo $ettings['mobile']; ?>
                  <?php
                  }else{
                  $country = (array) $this->main_model->getByData('countries','code',$user['country'])[0];
                  ?>
                  البريد الإلكتروني: <?php echo $user['email']; ?> | رقم الهاتف : <?php echo $country['tel'].$user['mobile'].'+'; ?>
                  <?
                  }
              ?>
          </p>
            <p class="mb-0">
                يمكنك أن تجد طلبك بأكواد الدفع مرة أخرى في حسابك الشخصي.
            </p>
        </div>
        <?php }elseif($this->uri->segment(1) == 'users'){ ?>
            <div class="container-fluid float-right statics">
                <div class="col-lg-12 col-md-12 col-sm-12 stats">
                    <?php
                    $ordersNum = $this->main_model->getFullRequest('p_tickets','u_id = '.$this->session->userdata('id'),'count');
                        if($ordersNum){
                            $Onum = $ordersNum;
                        }else{
                            $Onum = 0;
                        }
                    ?>
                    <h3><?php echo $Onum; ?></h3>
                    <p>نوع من التذاكر قمت بحجزه</p>
                </div>
                <?php 
                    $creds = explode(',',$this->session->userdata('cred'));
                    if(in_array('tickets',$creds)){
                        $allpri = 0;
                        $alltcks = 0;
                        $items = $this->main_model->getByData('items','u_id',$this->session->userdata('id'));
                        if($items){
                        foreach($items as $item){
                            $i_tickets = (array) $this->main_model->getByData('p_tickets','i_id',$item->id);
                            foreach($i_tickets as $i_tick){
                                if(isset($i_tick->price)){
                                    $allpri += $i_tick->price*$i_tick->num;
                                    $alltcks += $i_tick->num;
                                }
                            }
                        } ?>
                <div class="col-lg-12 col-md-12 col-sm-12 stats">
                    <h3>SR <?php echo $allpri; ?></h3>
                    <p>إجمالي قيمة كل الطلبات</p>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 stats">
                    <h3><?php echo $alltcks; ?></h3>
                    <p>إجمالي عدد التذاكر المطلوبة</p>
                </div>
                <?php
                    $creds = explode(',',$this->session->userdata('cred'));
                        if(in_array('bank',$creds)){
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 float-right stats">
                    <?php
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    echo form_open_multipart(base_url().'users/bankUp',$atrr2);

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
                        $p_id = array(
                            'type'=>'number',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'p_id',
                            'placeholder'=>'كود الطلب الـ XXXXX'
                        );
                        echo form_input($p_id);
                        ?>
                    <p class="a_rules">أدخل رقم الطلب #TW - XXXXX</p>
                    <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                            echo form_button($submit,'<span class="fa fa-credit-card"></span> تحصيل'); ?>
                            <p class="a_rules">تأكد من تحصيلك كل أموال الطلب قبل الضغط.</p>
                           <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>
                    
                    <?php
                    echo form_close();
                    ?>
                </div>
                <?php
                }elseif($Buser['rcred'] == null){
                    ?>
                <div class="col-lg-12 col-md-12 col-sm-12 float-right stats">
                    <h3>تقديم طلب للتحصيل بنفسك.</h3>
                    <a class="btn btn-success" href="<?php echo base_url().'users/bankMyself'; ?>">تقديم</a>
                </div>
                <?php
                    }elseif($Buser['rcred'] == 'bank'){
                    ?>
                <div class="col-lg-12 col-md-12 col-sm-12 float-right stats">
                    <h3>لقد تم تقديم طلب للتحصيل بنفسك.</h3>
                </div>
                <?php
                    }
                    if(in_array('pages',explode(',',$Buser['cred']))){
                    ?>
                <div class="col-lg-12 col-md-12 col-sm-12 float-right stats">
                    <?php
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    echo form_open_multipart(base_url().'users/checkTicket',$atrr2);

                    echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>');
                    if(isset($error) && $error !== ''){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$error.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }elseif(isset($state11) && $state11 !== ''){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        '.$state11.'
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                        $p_id = array(
                            'type'=>'number',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'p_id',
                            'placeholder'=>'كود الطلب الـ XXXXX'
                        );
                        echo form_input($p_id);
                        ?>
                    <p class="a_rules">أدخل رقم الطلب #TW - XXXXX</p>
                    <?php
                    $t_id = array(
                            'type'=>'number',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'t_id',
                            'placeholder'=>'الرقم التسلسلي للتذكرة'
                        );
                        echo form_input($t_id);
                        ?>
                    <p class="a_rules">أدخل الرقم التسلسلي للتذكرة</p>
                    <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                            echo form_button($submit,'<span class="fa fa-credit-card"></span> تأكد'); ?>
                            <p class="a_rules">تأكد من وجود التذكرة.</p>
                           <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>
                    
                    <?php
                    echo form_close();
                    ?>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 float-right stats">
                    <?php
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    echo form_open_multipart(base_url().'users/used',$atrr2);

                    echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>');
                    if(isset($error) && $error !== ''){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$error.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }elseif(isset($state2) && $state2 !== ''){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        '.$state2.'
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                        $p_id = array(
                            'type'=>'number',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'p_id',
                            'placeholder'=>'كود الطلب الـ XXXXX'
                        );
                        echo form_input($p_id);
                        ?>
                    <p class="a_rules">أدخل رقم الطلب #TW - XXXXX</p>
                    <?php
                    $t_id = array(
                            'type'=>'number',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'t_id',
                            'placeholder'=>'الرقم التسلسلي للتذكرة'
                        );
                        echo form_input($t_id);
                        ?>
                    <p class="a_rules">أدخل الرقم التسلسلي للتذكرة</p>
                    <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                            echo form_button($submit,'<span class="fa fa-credit-card"></span> استخدام'); ?>
                            <p class="a_rules">استخدام التذكرة</p>
                           <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>
                    
                    <?php
                    echo form_close();
                    ?>
                </div>
                <?php
                    }
                    }}
                ?>
            </div>
        <?php } ?>
    </div>
</div>