<div class="container-fluid m_top">
    <div class="col-lg-12 col-md-12 col-sm-12 register-sb">
        <div class="col-lg-12 col-md-12 col-sm-12 register-s">
            <h3>تعليمات</h3>
            <ul>
                <li>لن تستطيع التسجيل ببريد إلكتروني في أكثر من حساب.</li>
                <li>يجب أن يكون البريد الإلكتروني صحيح ليتم تأكيد الحساب من خلاله.</li>
                <li>لا تضع معلومات مزيفة حتى لايتم غلق حسابك.</li>
            </ul>
        </div>
    </div>
    <?php 
    $atrr = array(
    'class' => 'col-lg-6 col-md-6 col-sm-12 register'
    );
    echo form_open(base_url().'pages/registerCheck',$atrr);
    ?>
        <span class="fa fa-user-plus"></span><h3 class="acc-k">أريد تسجيل حساب</h3><br />
    <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">',
    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button></div>'); ?>
    <div class="col-lg-12 col-md-12 col-sm-12 float-right">
        <div class="col-lg-12 col-md-12 col-sm-12 r-type type-active" id="0">
            <p>حساب</p>
            <p>عادي</p>
        </div>
        <?php
        $hidden = array(
        'type'=>'hidden',
        'name'=>'type',
        'value'=>'0'
        );
            echo form_input($hidden);
        ?>
    </div>
    <h5><code>جميع الحقول مطلوبة.</code></h5>
    <div id="c_name">
        <label>اسم الشركة/المؤسسة</label><br />
        <?php
        $c_name = array(
        'type'=>'text',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'c_name',
        'placeholder'=>'اسم الشركة'
        );
            echo form_input($c_name);
        ?>
    </div>
        <label>اسم المستخدم</label><br />
        <?php
        $u_name = array(
        'type'=>'text',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'username',
        'id'=>'user-nm',
        'placeholder'=>'اسم المستخدم'
        );
            echo form_input($u_name);
        ?>
        <label class="usernm"><?php echo base_url().'user/'; ?><span id="u-nm">username</span></label><br />
        <label>البريد الالكتروني</label><br />
        <?php
        $email = array(
        'type'=>'email',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'email',
        'placeholder'=>'البريد الإلكتروني'
        );
            echo form_input($email);
        ?>
        <label>كلمة السر</label><br />
        <?php
        $password = array(
        'type'=>'password',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'password',
        'placeholder'=>'**********'
        );
            echo form_input($password);
        ?>
        <label>تأكيد كلمة السر</label><br />
        <?php
        $passwordConf = array(
        'type'=>'password',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'passwordConf',
        'placeholder'=>'**********'
        );
            echo form_input($passwordConf);
        ?>
     <label>الدولة</label><br />
        <?php
        $ipadd = $this->input->ip_address();
        $c_code = $this->main_model->ip_info($ipadd, "Country Code");
        if($c_code == ''){$c_code='EG';}
        foreach($countries as $country){
            $counts[$country->code] = $country->country;
            echo '<input type="hidden" id="'.$country->code.'" value="'.$country->tel.'">';
        }
        echo form_dropdown(array('name'=>'country','id'=>'country'),$counts,$c_code); ?>
        <br />
    
        <label>رقم الهاتف</label><br />
    <div class="col-auto">
      <label class="sr-only float-right" for="te">00000</label>
      <div class="input-group mb-2">
        <?php
        $mobile = array(
        'type'=>'text',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'mobile',
        'id'=>'tel',
        'placeholder'=>'رقم الهاتف'
        );
            echo form_input($mobile);
        ?>
          <div class="input-group-prepend">
          <div class="input-group-text"><span id="telnum">
              <?php
                  $telnum = $this->main_model->getByData('countries','code',$c_code);
                  echo $telnum[0]->tel;
              ?>
              </span>+</div>
        </div>
      </div>
    </div>
    
       
        <label>العنوان</label><br />
        <?php
        $address = array(
        'type'=>'text',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'address',
        'placeholder'=>'عنوانك'
        );
            echo form_input($address);
        ?>
        <br/>
             <div class="g-recaptcha" data-sitekey="6LetSawZAAAAAPeSTE4QHu_jSIhJnjKLbRUtW8mx" data-callback="onSubmit" data-size="visible" id="recaptcha"></div>
            <br/>
        <br />
        <label>بتسجيلك في الموقع فأنت توافق على <a href="#">شروط الإستخدام</a> و <a href="#">سياسة الخصوصية</a>.</label><br /><br />
            <?php
                $button=array(
                'type'=>'submit',
                'class'=>'regbtn',
                'name'=>'register',
                'content'=>'
                <span class="fa fa-plus"></span>
                تسجيل
                '
                );
                echo form_button($button);
            ?>
             
            <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>
        <div class="fb-btn">
            <!-- Display login button / Facebook profile information -->
        <?php if(!empty($authURL)){ ?>
            <a href="<?php echo $authURL; ?>"><span class="fab fa-facebook"></span> الدخول بواسطة حساب الـ Facebook</a>
        <?php } ?>
        </div>
        <p>
        <a href="<?php echo base_url(); ?>login/">دخول</a> |
        <a href="<?php echo base_url().'restPassword'; ?>">هل فقدت كلمة السر؟!</a>
        </p>
    <?php echo form_close(); ?>
</div>
<script src="https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit&hl=ar" async defer></script>

<script type="text/javascript">
    var recaptchaCallback = function () {
    console.log('recaptcha is ready'); // showing
    grecaptcha.render("recaptcha", {
        sitekey: '6LetSawZAAAAAPeSTE4QHu_jSIhJnjKLbRUtW8mx',
        callback: function () {
            console.log('recaptcha callback');
        }
    });
    }
</script>