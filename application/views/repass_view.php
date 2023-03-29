<?php $this->load->view('include/header.php'); ?>
<div class="container-fluid m_top">
        <?php 
    $atrr = array(
    'class' => 'col-lg-4 col-md-4 col-sm-12 login'
    );
    echo form_open(base_url().'pages/repassCheck',$atrr);
    ?>
        <span class="fa fa-user"></span>
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">',
    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button></div>'); ?>
    <?php if ($this->uri->segment(3) == 'wrong' && $this->uri->segment(2) == 'restPassword'){
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">لقد أدخلت بريد غير مسجل<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button></div>';
          }elseif ($this->uri->segment(3) == 'done' && $this->uri->segment(2) == 'restPassword'){
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">لقد تم إرسال بريد لحسابك لإستعادة كلمة السر<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button></div>';
          } ?>
        <?php
        $email = array(
        'type'=>'email',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'email',
        'placeholder'=>'البريد الإلكتروني',
        'value' => $user->email
        );
            echo form_input($email);
        ?>
    <?php
        $password = array(
        'type'=>'password',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'password',
        'placeholder'=>'كلمة السر الجديدة',
        );
            echo form_input($password);
        ?>
    <?php
        $passwordConf = array(
        'type'=>'password',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'passwordConf',
        'placeholder'=>'إعادة كلمة السر',
        );
            echo form_input($passwordConf);
        ?>
    <br />
        <?php
        $button=array(
        'type'=>'submit',
        'class'=>'regbtn',
        'name'=>'login',
        'content'=>'
        <span class="fa fa-lock"></span>
        تغيير
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
        <a href="<?php echo base_url().'register'; ?>">تسجيل</a> |
        <a href="<?php echo base_url().'login'; ?>">دخول</a>
        </p>
    <?php echo form_close(); ?>
</div>
<?php $this->load->view('include/footer.php'); ?>