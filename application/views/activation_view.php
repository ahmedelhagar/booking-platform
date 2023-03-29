<?php $this->load->view('include/header.php'); ?>
<div class="container-fluid m_top">
    <?php
      if($this->main_model->is_logged_in()){
                    // Access User Data Securly
                $userData = (array) $this->main_model->is_logged_in(1)[0];
                $userId = $userData['id'];
                $userFirstname = $userData['first_name'];
                $userLastname = $userData['last_name'];
                $userUsername = $userData['username'];
                $userEmail = $userData['email'];
                $userCountry = $userData['country'];
                $userMobile = $userData['mobile'];
                $userAddress = $userData['address'];
                $userIp = $userData['ip'];
                $userBalance = $userData['balance'];
                $userDate = $userData['date'];
                $userState = $userData['state'];
                $userAll_balance = $userData['all_balance'];
                $userL_logout = $userData['l_logout'];
            }
    if(isset($userState) && $this->uri->segment(2) == 'reactivate' && $userState == 0 && $this->uri->segment(3) == ''){
        $fullTime1 =$time;
        $fullTime2 =$this->main_model->dateTime('current');
        $differ = $this->main_model->dateTime('diff',$fullTime1,$fullTime2);
        if($differ['years'] > 0 OR $differ['months'] > 0 OR $differ['days'] > 0 OR $differ['hours'] > 0 OR $differ['minutes'] > 10){
            // Delete Previous Code
        $this->main_model->deleteData('users_activation','code',$code);
        $random_code=$this->main_model->random_number();
            $this->main_model->insertData('users_activation',array(
                'u_id' => $userId,
                'code' => $random_code,
                'time' => $this->main_model->dateTime('current')
            ));
            // Here I`ll Send the message.
            // Multiple recipients
            $to = $userEmail; // note the comma

            // Subject
            $subject = 'تأكيد حسابك في موقع مكسب';

            // Message
            $message = '
            <html><head>
                <style type="text/css">
                @font-face {
            font-family: "Droid Arabic Kufi";
            src: url("'.base_url().'vendor/fonts/Droid Arabic Kufi.ttf");
            }
                    body{
                    font-family: "Droid Arabic Kufi",sans-serif;
                    }
                </style>
            </head><body><div style="
                width: 90%;
                margin: auto;
                padding: 25px;
                border-bottom: 1px solid #ddd;
                text-align: left;
                height: 30px;
                font-size: 18px;
            ">
            <img src="'.base_url().'vendor/images/logo.png" style="
                width: 140px;
                margin: auto;
                display: block;
            ">

                <div style="
                float: right;
                width: 100%;
                text-align: right;
                direction: rtl;
                clear: both;
            ">
                <h4>
                أهلاً '.$userUsername.'
                <br />
                شكراً على تسجيلك في موقع مكسب يجب عليك تأكيد حسابك من الرابط التالي:
                </h4>
                <h5 style="
                padding: 10px;
                background: #ddd;
                text-align: center;
                border: 1px solid #b5b5b5;
            "><a href="'.base_url().'activate/'.$random_code.'" target="_blank">'.base_url().'activate/'.$random_code.'</a></h5>
            </div>
            </div><style>
            h3#msg_ti {
                text-align: center;
                font-size: 30px;
                background: #292929;
                color: #fff;
                font-family: tahoma;
            }
            </style>
            </body></html>
            ';

            // To send HTML mail, the Content-type header must be set
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

            // Additional headers
            $headers[] = 'To: '.$userUsername.' <'.$userEmail.'>';
            $headers[] = 'From: منصة مكسب <admin@brnameg.com>';
            $headers[] = 'Cc: admin@brnameg.com';
            $headers[] = 'Bcc: admin@brnameg.com';

            // Mail it
            mail($to, $subject, $message, implode("\r\n", $headers));
            // Redirect to profile
            redirect(base_url().'activate/reactivate/sent');
        }else{
            //Timer Wrong
        ?>
    <br />
    <div class="alert alert-primary" role="alert">
      يجب عليك الإنتظار مدة 10 دقائق بين التسجيل وطلب الإرسال مرة أخرى <a href="<?php echo base_url().'user/'.$this->session->userdata('username'); ?>" class="alert-link">لوحة التحكم في حسابك</a>.
    </div>
    <?php
        }
    }elseif(isset($userState) && $this->uri->segment(2) == 'reactivate' && $userState == 0 && $this->uri->segment(3) == 'sent'){
        ?>
    <br />
    <div class="alert alert-success" role="alert">
      لقد تم بالفعل إرسال كود التفعيل مرة أخرى <a href="<?php echo base_url().'user/'.$this->session->userdata('username'); ?>" class="alert-link">لوحة التحكم في حسابك</a>.
    </div>
    <?php
    }
    else{
        if(isset($state) && $state==1){//Activated ?>
    <br />
    <div class="alert alert-success" role="alert">
      لقد تم تفعيل حسابك بنجاح هل تريد <a href="<?php echo base_url(); ?>" class="alert-link">الصفحة الرئيسية</a>.
    </div>
    <?php
        }else{ //Not Activated
    ?>
    <br />
    <div class="alert alert-danger" role="alert">
      يبدو أنك أدخلت كود خاطئ أو أن هذا الحساب تم تفعيله من قبل هل تريد <a href="<?php echo base_url(); ?>" class="alert-link">الصفحة الرئيسية</a>.
    </div>
    <?php
        }
    }
    ?>
</div>
<?php $this->load->view('include/footer.php'); ?>