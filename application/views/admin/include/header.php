<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- font aweasome -->
  <link href="<?php echo base_url(); ?>vendor/fontaweasome/css/all.css" rel="stylesheet">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url().'vendor/css/home.css'; ?>">
      <link rel="shortcut icon" href="<?php echo base_url().'vendor/images/icon.ico'; ?>" type="image/x-icon">
      
    <title><?php echo $title; ?></title>
  </head>
  <body>
      <div class="rnav-overlay"></div>
      
      <!--Start Header-->
      <header>
      <!--Start Top Nav-->
      <nav class="top-nav">
          <div class="logo-icon">
              <span class="fa fa-bars"></span>
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
                  <span class="fa fa-search"></span>
                  <span class="s-dialog mobilev-disappear">البحث</span>
              </div>
              
              <div class="l-blink custom-button">
                 <a href="#">
                  <span class="fa fa-plus"></span> فعالية
                 </a>
              </div>
              <?php if(!$this->main_model->is_admin_logged_in()){ ?>
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
          <div class="close-rnav"><span class="fa fa-times"></span></div>
          <div class="container-fluid">
              <?php if(!$this->main_model->is_admin_logged_in()){ ?>
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
              <div class="l-blink">
                  <a href="<?php echo base_url().'pages/logout'; ?>">
                  تسجيل الخروج
                  </a>
              </div>
                <?php }; ?>
          </div>
          <h5><a href="<?php echo base_url().'wjhatnacadmin/allUsers'; ?>"><span class="fa fa-users"></span> الأعضاء والصلاحيات</a></h5>
          <h5><a href="<?php echo base_url().'wjhatnacadmin/addTag'; ?>"><span class="fa fa-tags"></span> التصنيفات</a></h5>
          <h5><a href="<?php echo base_url().'wjhatnacadmin/events'; ?>"><span class="fa fa-table"></span> النشر</a></h5>
          <h5><a href="<?php echo base_url().'wjhatnacadmin/apps'; ?>"><span class="fa fa-link"></span> إعدادات و روابط</a></h5>
          <h5><a href="<?php echo base_url().'blog'; ?>"><span class="fa fa-file"></span> المدونة</a></h5>
          <h5><a href="<?php echo base_url().'wjhatnacadmin/tickets'; ?>"><span class="fa fa-ticket"></span> التذاكر والدفع</a></h5>
          <h5><a href="<?php echo base_url().'wjhatnacadmin/editPage/1'; ?>"><span class="fa fa-ticket"></span> شرح استخدام الموقع</a></h5>
          <h5><a href="<?php echo base_url().'wjhatnacadmin/editPage/2'; ?>"><span class="fa fa-ticket"></span> الأسئلة الشائعة</a></h5>
          <h5><a href="<?php echo base_url().'wjhatnacadmin/editPage/3'; ?>"><span class="fa fa-ticket"></span> من نحن</a></h5>
      </nav>
      </header>
      <!--End Header-->
      
        <!-- Start Content -->
      <div class="container-fluid">