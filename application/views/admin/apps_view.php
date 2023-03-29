<div class="container-fluid allUsers">
    <br />
    <div class="col-lg-8 col-md-8 col-sm-12 s-pro register">
        <div class="col-lg-12 col-md-12 col-sm-12 s-pro">
            <div class="col-lg-12 col-md-12 col-sm-12 s_block">
                <h4 class="pt-10">الإعدادات</h4>
                <?php 
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    echo form_open_multipart(base_url().'wjhatnacadmin/appsCheck/',$atrr2);

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
                        تم التعديل بنجاح.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                ?>
                <p class="a_rules text-center">يجب إدخال الحقول التي تحتوي على أو أدخل علامة #.</p>
                <label class="float-right mb-0">رابط Facebook</label>
                <?php 
                    $facebook = array(
                        'type' => 'text',
                        'autocomplete'=>'off',
                        'class'=>'form-control text-right float-right',
                        'name'=>'facebook',
                        'value'=> $settings['facebook'],
                        'placeholder'=>'رابط Facebook'
                    );
                echo form_input($facebook);
                ?>
                <label class="float-right mb-0">رابط Twitter</label>
                <?php 
                    $twitter = array(
                        'type' => 'text',
                        'autocomplete'=>'off',
                        'class'=>'form-control text-right float-right',
                        'name'=>'twitter',
                        'value'=> $settings['twitter'],
                        'placeholder'=>'رابط Twitter'
                    );
                echo form_input($twitter);
                ?>
                <label class="float-right mb-0">رابط Instagram</label>
                <?php 
                    $instagram = array(
                        'type' => 'text',
                        'autocomplete'=>'off',
                        'class'=>'form-control text-right float-right',
                        'name'=>'instagram',
                        'value'=> $settings['instagram'],
                        'placeholder'=>'رابط Instagram'
                    );
                echo form_input($instagram);
                ?>
                <label class="float-right mb-0">رابط تطبيق App Store</label>
                <?php 
                    $appstore = array(
                        'type' => 'text',
                        'autocomplete'=>'off',
                        'class'=>'form-control text-right float-right',
                        'name'=>'appstore',
                        'value'=> $settings['appstore'],
                        'placeholder'=>'رابط تطبيق App Store - Apple'
                    );
                echo form_input($appstore);
                ?>
                <label class="float-right mb-0">رابط تطبيق Playstore</label>
                <?php 
                    $playstore = array(
                        'type' => 'text',
                        'autocomplete'=>'off',
                        'class'=>'form-control text-right float-right',
                        'name'=>'playstore',
                        'value'=> $settings['playstore'],
                        'placeholder'=>'رابط تطبيق Play Store - Google'
                    );
                echo form_input($playstore);
                ?>
                <label class="float-right mb-0">رقم الهاتف للتواصل عند الشراء</label>
                <?php 
                    $mobile = array(
                        'type' => 'text',
                        'autocomplete'=>'off',
                        'class'=>'form-control text-right float-right',
                        'name'=>'mobile',
                        'value'=> $settings['mobile'],
                        'placeholder'=>'رقم الهاتف للتواصل عند الشراء'
                    );
                echo form_input($mobile);
                ?>
                <label class="float-right mb-0">بريد للتواصل عند الشراء</label>
                <?php 
                    $email = array(
                        'type' => 'text',
                        'autocomplete'=>'off',
                        'class'=>'form-control text-right float-right',
                        'name'=>'email',
                        'value'=> $settings['email'],
                        'placeholder'=>'بريد للتواصل عند الشراء'
                    );
                echo form_input($email);
                ?>
                        <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                                echo form_button($submit,'<span class="fa fa-save"></span> تعديل');
?>

                        <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>


                        <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>