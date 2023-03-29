<?php $this->load->view('admin/include/header.php'); ?>
<div class="container-fluid m_top">
        <?php 
    $atrr = array(
    'class' => 'col-lg-4 col-md-4 col-sm-12 login'
    );
    echo form_open(base_url().'wjhatnacadmin/loginCheck',$atrr);
    ?>
        <span class="fa fa-user"></span>
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">',
    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button></div>'); ?>
    <?php if ($this->uri->segment(3) == 'wrong' && $this->uri->segment(2) == 'login'){
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">لقد أدخلت بيانات خطأ<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button></div>';
          } ?>
    <h3>تسجيل الدخول إلى لوحة تحكم الموقع</h3>
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
    <br />
        <?php
        $button=array(
        'type'=>'submit',
        'class'=>'regbtn',
        'name'=>'login',
        'content'=>'
        <span class="fa fa-lock"></span>
        دخول
        '
        );
        echo form_button($button);
        ?>
    <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>
    <?php echo form_close(); ?>
</div>
<?php $this->load->view('admin/include/footer.php'); ?>