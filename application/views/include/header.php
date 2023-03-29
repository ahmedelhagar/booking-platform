<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <?php
        if ($this->uri->segment(1)) {
            // We are not on the homepage
        ?>
  <!-- font aweasome -->
  <link href="<?php echo base_url(); ?>vendor/fontaweasome/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <?php } ?>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url().'vendor/css/home.css'; ?>">
      <link rel="shortcut icon" href="<?php echo base_url().'vendor/images/icon.ico'; ?>" type="image/x-icon">
      <?php if($this->uri->segment(1) == ''){ ?>
      <meta name="description" content="منصة إلكترونية تقدم لكم الجديد دائما في عالم الفعاليات المهرجانات 
والعروض الخاصة للمطاعم والمقاهي استكشف خطط واستمتع واحجز التذاكر .">
        <meta name="keywords" content="فعاليات,مهرجانات,مسرحيات,عروض,كوبون,مطاعم,مقاهي,تذاكر">
        <meta name="author" content="Wjhatna">
      <?php }elseif($this->uri->segment(2) == 'post' && isset($post)){ ?>
        <meta name="description" content="<?php echo substr(strip_tags($post[0]->content),0,100); ?>">
        <meta name="keywords" content="<?php echo $post[0]->tags; ?>">
        <meta name="author" content="Wjhatna">
      <?php }elseif($this->uri->segment(1) == 'i' && isset($item)){ ?>
        <meta name="description" content="<?php echo substr(strip_tags($item[0]->content),0,100); ?>">
        <meta name="keywords" content="<?php echo $item[0]->tags; ?>">
        <meta name="author" content="Wjhatna">
      <?php } ?>
    <title><?php echo $title; ?></title>
  </head>
  <body>
      <div class="rnav-overlay"></div>
      
      <!--Start Header-->
      <header>
      <!--Start Top Nav-->
      <nav class="top-nav">
          <div class="logo-icon">
          <svg class="svg-icon" viewBox="0 0 20 20">
							<path fill="none" d="M3.314,4.8h13.372c0.41,0,0.743-0.333,0.743-0.743c0-0.41-0.333-0.743-0.743-0.743H3.314
								c-0.41,0-0.743,0.333-0.743,0.743C2.571,4.467,2.904,4.8,3.314,4.8z M16.686,15.2H3.314c-0.41,0-0.743,0.333-0.743,0.743
								s0.333,0.743,0.743,0.743h13.372c0.41,0,0.743-0.333,0.743-0.743S17.096,15.2,16.686,15.2z M16.686,9.257H3.314
								c-0.41,0-0.743,0.333-0.743,0.743s0.333,0.743,0.743,0.743h13.372c0.41,0,0.743-0.333,0.743-0.743S17.096,9.257,16.686,9.257z"></path>
						</svg>
          </div>
          <!-- Start Logo -->
          <div class="logo">
              <!-- Text Logo -->
              <div class="text-logo">
                  <a href="<?php echo base_url(); ?>">
                      <img src="<?php echo base_url().'vendor/images/logo.png'; ?>" alt="وجهتنا">
                  </a>
              </div>
          </div>
          <!-- End Logo -->
          
          <!-- Nav Icons -->
          <div class="nav-blinks">
              <div class="r-blink mobilev-disappear"><a href="<?php echo base_url().'pages/discover'; ?>">استكشف</a></div>
              <div class="r-blink search-btn">
                  <a href="<?php echo base_url().'pages/search'; ?>">
                  <svg class="svg-icon" viewBox="0 0 20 20">
							<path fill="none" d="M19.129,18.164l-4.518-4.52c1.152-1.373,1.852-3.143,1.852-5.077c0-4.361-3.535-7.896-7.896-7.896
								c-4.361,0-7.896,3.535-7.896,7.896s3.535,7.896,7.896,7.896c1.934,0,3.705-0.698,5.078-1.853l4.52,4.519
								c0.266,0.268,0.699,0.268,0.965,0C19.396,18.863,19.396,18.431,19.129,18.164z M8.567,15.028c-3.568,0-6.461-2.893-6.461-6.461
								s2.893-6.461,6.461-6.461c3.568,0,6.46,2.893,6.46,6.461S12.135,15.028,8.567,15.028z"></path>
						</svg>
                      <span class="s-dialog mobilev-disappear">البحث</span>
                  </a>
              </div>
              <div class="l-blink custom-button">
                 <a href="<?php echo base_url().'pages/promote'; ?>">
                  + فعالية
                 </a>
              </div>
              <?php if(!$this->main_model->is_logged_in()){ ?>
              <div class="l-blink mobilev-disappear">
                  <a href="<?php echo base_url().'pages/register'; ?>">
                  تسجيل
                  </a>
              </div>
              <div class="l-blink mobilev-disappear">
                  <a href="<?php echo base_url().'pages/login'; ?>">
                  دخول
                  </a>
              </div>
              <?php }else{ ?>
              <div class="l-blink mobilev-disappear">
                  <a href="<?php echo base_url().'pages/logout'; ?>">
                  تسجيل الخروج
                  </a>
              </div>
              <div class="r-blink nav-item dropdown tags notf" style="float: left;">
                  <?php $nums = $this->main_model->getFullRequest('alerts','statue = 0 AND u_id = '.$this->session->userdata('id'),'count'); ?>
                  <a class="nav-link dropdown-toggle" onClick="<?php echo 'return seen('.$this->session->userdata('id').')'; ?>" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="fa fa-bell"></span>
                      <div class="al-num">
                      <?php
                          if($nums){
                        ?>
                          <div class="alerts-nums"><?php echo $nums; ?></div>
                      <?php
                        } ?>
                          </div>
                  </a>
               <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                   <?php
              $alerts = $this->main_model->getFullRequest('alerts','(u_id = '.$this->session->userdata('id').') ORDER BY id DESC');
                       if($alerts){
                   ?>
                  <div class="allalerts">
                      <?php foreach($alerts as $alert){ ?>
                      <div class="d_item">
                          <p><b><?php echo $alert->title; ?></b></p>
                          <?php echo $alert->description; ?>
                       </div>
                      <?php } ?>
                   </div>
                   <?php }else{echo 'لايوجد اشعارات لعرضها.';} ?>
                </div>
              </div>
                <?php }; ?>
          </div>
      </nav>
      <!--End Top Nav-->
          
      <!-- Right Nav -->
      <nav class="r-nav">
        <!-- Text Logo -->
              <div class="text-logo">
                  <a href="#">
                      <img src="<?php echo base_url().'vendor/images/logo.png'; ?>" alt="وجهتنا">
                  </a>
              </div>
          <div class="close-rnav">
              <svg class="svg-icon" viewBox="0 0 20 20">
							<path fill="none" d="M11.469,10l7.08-7.08c0.406-0.406,0.406-1.064,0-1.469c-0.406-0.406-1.063-0.406-1.469,0L10,8.53l-7.081-7.08
							c-0.406-0.406-1.064-0.406-1.469,0c-0.406,0.406-0.406,1.063,0,1.469L8.531,10L1.45,17.081c-0.406,0.406-0.406,1.064,0,1.469
							c0.203,0.203,0.469,0.304,0.735,0.304c0.266,0,0.531-0.101,0.735-0.304L10,11.469l7.08,7.081c0.203,0.203,0.469,0.304,0.735,0.304
							c0.267,0,0.532-0.101,0.735-0.304c0.406-0.406,0.406-1.064,0-1.469L11.469,10z"></path>
                        </svg>
                    </div>
          <div class="container-fluid">
              <?php if(!$this->main_model->is_logged_in()){ ?>
              <div class="l-blink">
                  <a href="<?php echo base_url().'pages/register'; ?>">
                  تسجيل
                  </a>
              </div>
              <div class="l-blink">
                  <a href="<?php echo base_url().'pages/login'; ?>">
                  دخول
                  </a>
              </div>
              <?php }else{ ?>
              <div class="user-image">
                    <a href="<?php echo base_url().'user/'.$this->session->userdata('username'); ?>"><img src="<?php if($this->session->userdata('picture') !== ''){echo $this->session->userdata('picture');}else{echo base_url().'vendor/images/user.png';}; ?>"></a>
                </div>
              <h6 class="container-fluid text-center"><a href="<?php echo base_url().'user/'.$this->session->userdata('username'); ?>"><?php echo $this->session->userdata('username'); ?></a></h6>
              <div class="l-blink">
                  <a href="<?php echo base_url().'pages/logout'; ?>">
                  تسجيل الخروج
                  </a>
              </div>
              <h5><a href="<?php echo base_url().'users/settings'; ?>"><span class="fa fa-cogs"></span> اعدادات حسابك</a></h5>
              <h5><a href="<?php echo base_url().'users/tickets'; ?>">تحميل التذاكر/ التحصيل</a></h5>
                <?php }; ?>
              <h5><a href="<?php echo base_url().'pages/discover'; ?>">استكشف</a></h5>
          </div>
      </nav>
      </header>
      <!--End Header-->
      
        <!-- Start Content -->
      <div class="container-fluid">
          <?php
              if($this->main_model->is_logged_in()){
                  $userD = $this->main_model->getByData('users','id',$this->session->userdata('id'))[0];
                  if($userD->type && $userD->img1 == ''){
              ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>هام للموافقة على حسابك!</strong> يجب عليك رفع نسخة من الرخصة التجارية سارية المفعول من <a href="<?php echo base_url().'users/lisence'; ?>">هنا</a>.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php
                  }
              }
          ?>