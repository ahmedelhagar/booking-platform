<?php $this->load->view('include/header.php'); ?>
<div class="container-fluid m_top">
    <?php
        $result = $this->main_model->is_logged_in(strip_tags($this->session->userdata('username')));
    if($result){
        $currentUser = (array) $result[0]; /*To Get Current user*/
        // Check if activated
        if($currentUser['state'] == 0){
            //Not Activated
            if($this->session->userdata('username') == $currentUser['username']){
                echo '
                <div class="alert alert-danger" role="alert">
                  حسابك غير مُفعل يمكن أن تجد رسالة التفعيل في الرسائل الغير مرغوبة أو 
                  <b><a href="'.base_url().'activate/reactivate/"> أرسل كود تفعيل جديد</a></b>
                </div>
                ';
            }else{
                redirect(base_url().'user/');/*Not Found*/
            }
        }
    }else{
        redirect(base_url().'user/');/*Not Found*/
    }
      if($this->main_model->is_logged_in()){
                    // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
                $userOauth_provider = $userData['oauth_provider'];
                $userFirstname = $userData['first_name'];
                $userLastname = $userData['last_name'];
                $userUsername = $userData['username'];
                $userC_name = $userData['c_name'];
                $userEmail = $userData['email'];
                $userCountry = $userData['country'];
                $userMobile = $userData['mobile'];
                $userAddress = $userData['address'];
                $userIp = $userData['ip'];
                $userDate = $userData['date'];
                $userState = $userData['state'];
                $userType = $userData['type'];
                $userImage = $userData['picture'];
                $userL_logout = $userData['l_logout'];
            }
      ?>
    <div class="col-lg-12 col-md-12 col-sm-12 s-pro text-center">
        <div class="container-fluid">
            <!--Item-->
            <div class="col-lg-3 col-md-3 col-sm-12 s-pro">
                <div class="col-lg-12 col-md-12 col-sm-12 s_block settl">
                    <h4>إعدادات</h4>
                    <div class="a-link al-active"><a href="<?php echo base_url().'users/settings/'; ?>"><span class="fa fa-user"></span> الملف الشخصي</a></div>
                </div>
            </div>
            <!--Item-->
            <div class="col-lg-9 col-md-9 col-sm-12 s-pro">
                <div class="col-lg-12 col-md-12 col-sm-12 s_block">
                    <?php 
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    echo form_open_multipart(base_url().'users/settingsCheck/',$atrr2);

                    echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>');
                    if($error !== ''){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$error.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                    if(isset($state) && $state == 1){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم تعديل البيانات بنجاح
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                ?>
    <div class="col-lg-12 col-md-12 col-sm-12 float-right">
        <div class="col-lg-4 col-md-4 col-sm-12 float-right r-type<?php if($userType == 0){echo ' type-active';} ?>" id="0">
            <p>حساب</p>
            <p>عادي</p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 float-right r-type<?php if($userType == 1){echo ' type-active';} ?>" id="1">
            <p>حساب</p>
            <p>مُنظمين فعاليات</p>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 float-right r-type<?php if($userType == 2){echo ' type-active';} ?>" id="2">
            <p>حساب</p>
            <p>عروض تجارية</p>
        </div>
        <?php
        $hidden = array(
        'type'=>'hidden',
        'name'=>'type',
        'value'=>$userType
        );
            echo form_input($hidden);
        ?>
    </div>
       <div id="c_name"<?php if($userType == 2 OR $userType == 1){echo ' style="display: block;"';} ?>>
        <label>اسم الشركة/المؤسسة</label><br />
        <?php
        $c_name = array(
        'type'=>'text',
        'autocomplete'=>'off',
        'class'=>'form-control',
        'name'=>'c_name',
        'placeholder'=>'اسم الشركة',
        'value'=>$userC_name
        );
            echo form_input($c_name);
        ?>
    </div>
                    
    <?php if($userData['oauth_provider'] !== 'facebook'){ ?>
    <label class="float-right mb-0">اسمك الأول</label>
<?php
                        $firstName = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'firstname',
                            'placeholder'=>'اسمك الأول'
                        );
                    $firstName['value']=$userFirstname;
                                echo form_input($firstName);
?>
    <label class="float-right mb-0">اسمك الأخير</label>
<?php
                        $lastName = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'lastname',
                            'placeholder'=>'اسمك الأخير أو العائلة'
                        );
                    $lastName['value']=$userLastname;
                                echo form_input($lastName);
?>
    <label class="float-right mb-0">صورة ملفك الشخصي</label><br />
        
<?php
                        $image = array(
                            'type'=>'file',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'userfile',
                            'id'=>'userfile'
                        );
                                echo form_input($image).'<label for="userfile" />';
                                ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 float-right file-img">
                                <img id="blah" class="user" src="<?php 
                                      if($userImage==''){
                                      echo base_url().'vendor/images/user.png';
                                      }elseif($userOauth_provider == 'facebook'){
                                          echo $userImage;
                                      }else{
                                          echo base_url().'vendor/uploads/images/'.$userImage;
                                      }
                                         ?>" alt="<?php echo $userFirstname.' '.$userLastname; ?>" />
                                </div>
                                <?php
                                echo '<div class="col-lg-9 col-md-9 col-sm-12 float-right txxx"><span class="fa fa-upload"></span> <span class="selected-files">اختر صورة</span></div></label><br />';
?>
    <input type="hidden" value="<?php 
                                      if($userImage==''){
                                      echo base_url().'vendor/images/user.png';
                                      }else{
                                          echo base_url().'vendor/uploads/images/'.$userImage;
                                      }
                                         ?>" id="img-name">
                    <?php }else{ ?>
                    <div class="container-fluid float-right text-center pxy-10 alert alert-warning alert-dismissible fade show" role="alert">
                        إذا أردت تغيير اسمك أو صورتك الشخصية ... قم بتغييرهم في حسابك على الـ Facebook.
                    </div>
                    <?php } ?>

    <label class="float-right mb-0">الدولة</label><br />
        <?php
        $ipadd = $this->input->ip_address();
        $c_code = $this->main_model->ip_info($ipadd, "Country Code");
        if($c_code == ''){$c_code='EG';}
        foreach($countries as $country){
            $counts[$country->code] = $country->country;
            echo '<input type="hidden" id="'.$country->code.'" value="'.$country->tel.'">';
        }
        echo form_dropdown(array('name'=>'country','id'=>'country','class'=>'form-control'),$counts,$userCountry); ?>


    <label class="float-right mb-0">رقم هاتفك</label>
    <div class="col-auto">
      <label class="sr-only float-right" for="te">00000</label>
      <div class="input-group mb-2">
<?php
                        $mobile = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'mobile',
                            'placeholder'=>'رقم هاتفك'
                        );
                    $mobile['value']=$userMobile;
                                echo form_input($mobile);
?>
                    <div class="input-group-prepend">
          <div class="input-group-text"><span id="telnum">
              <?php
                  $telnum = $this->main_model->getByData('countries','code',$userCountry);
                  echo $telnum[0]->tel;
              ?>
              </span>+</div>
        </div>
      </div>
    </div>
                    
    <label class="float-right mb-0">عنوانك</label>
<?php
                        $address = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'address',
                            'placeholder'=>'عنوانك'
                        );
                    $address['value']=$userAddress;
                                echo form_input($address);
?>

<?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn',
                            'name'=>'submit'
                        );
                                echo form_button($submit,'<span class="fa fa-save"></span> حفظ');
?>

<p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('include/footer.php'); ?>