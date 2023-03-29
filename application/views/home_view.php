<?php $ettings = (array) $this->main_model->getByData('settings','id',1)[0]; ?>
          <!-- First Block -->
          <div class="col-lg-12 col-md-12 col-sm-12 float-right block">
              <!-- Block Text -->
              <div class="col-lg-6 col-md-6 col-sm-12 _1st-block-text">
                  <h3>هل تنوي الخروج؟</h3>
                  <div class="_1st-desc">
                      <p>اكتشف ... خطط ... استمتع</p>
                      <p>واحجز التذاكر.</p>
                  </div>
                  <div class="_1st-getit">
                      <a href="<?php echo $ettings['playstore']; ?>">
                          <img src="<?php echo base_url(); ?>vendor/images/gplay.png" class="getit-btn">
                      </a>
                      <a href="<?php echo $ettings['appstore']; ?>">
                          <img src="<?php echo base_url(); ?>vendor/images/appstore.png" class="getit-btn">
                      </a>
                  </div>
              </div>
              <!-- Block Image -->
              <div class="col-lg-6 col-md-6 col-sm-12 float-right _1st-block-msgs">
                  <img src="<?php echo base_url(); ?>vendor/images/msgs.png" class="msgs">
              </div>
              <!-- Wave Block -->
              <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                  <path fill="#d35400" fill-opacity="1" d="M0,128L12,138.7C24,149,48,171,72,160C96,149,120,107,144,112C168,117,192,171,216,202.7C240,235,264,245,288,240C312,235,336,213,360,202.7C384,192,408,192,432,176C456,160,480,128,504,112C528,96,552,96,576,112C600,128,624,160,648,165.3C672,171,696,149,720,122.7C744,96,768,64,792,85.3C816,107,840,181,864,181.3C888,181,912,107,936,96C960,85,984,139,1008,176C1032,213,1056,235,1080,245.3C1104,256,1128,256,1152,256C1176,256,1200,256,1224,256C1248,256,1272,256,1296,256C1320,256,1344,256,1368,261.3C1392,267,1416,277,1428,282.7L1440,288L1440,320L1428,320C1416,320,1392,320,1368,320C1344,320,1320,320,1296,320C1272,320,1248,320,1224,320C1200,320,1176,320,1152,320C1128,320,1104,320,1080,320C1056,320,1032,320,1008,320C984,320,960,320,936,320C912,320,888,320,864,320C840,320,816,320,792,320C768,320,744,320,720,320C696,320,672,320,648,320C624,320,600,320,576,320C552,320,528,320,504,320C480,320,456,320,432,320C408,320,384,320,360,320C336,320,312,320,288,320C264,320,240,320,216,320C192,320,168,320,144,320C120,320,96,320,72,320C48,320,24,320,12,320L0,320Z"></path>
                </svg>
          </div>
          <!-- Second Block -->
          <div class="col-lg-12 col-md-12 col-sm-12 float-right block colored-block">
              <div class="cb-text">الفعاليات والعروض الترويجية</div>
              <?php
                    $atrr2 = array(
                        'method' => 'post',
                        'id' => 'home-form'
                    );
                    echo form_open_multipart(base_url().'pages/discover/',$atrr2);

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
                    } ?>
              <div class="form-group" style="position: relative;">
            <input style="height: 70px;" placeholder="اكتب اسم مدينة" type="text" class="form-control input-lg home_search_for search_for" name="search_for" id="search_ByState" required="">
              <i class="home_search_for-i"><svg class="svg-icon" viewBox="0 0 20 20">
							<path fill="none" d="M19.129,18.164l-4.518-4.52c1.152-1.373,1.852-3.143,1.852-5.077c0-4.361-3.535-7.896-7.896-7.896
								c-4.361,0-7.896,3.535-7.896,7.896s3.535,7.896,7.896,7.896c1.934,0,3.705-0.698,5.078-1.853l4.52,4.519
								c0.266,0.268,0.699,0.268,0.965,0C19.396,18.863,19.396,18.431,19.129,18.164z M8.567,15.028c-3.568,0-6.461-2.893-6.461-6.461
								s2.893-6.461,6.461-6.461c3.568,0,6.46,2.893,6.46,6.461S12.135,15.028,8.567,15.028z"></path>
						</svg></i>
                  <!-- search input box -->
                <button class="search-map get_map" style="display:none;" type="submit">
                    ابحث
                </button>
                <!-- display google map -->
                <div id="geomap" style="display:none;"></div>

                <!-- display selected location information -->
                <input type="hidden" class="search_latitude" id="search_latitude" name="search_latitude" size="30" value="">
                <input type="hidden" class="search_longitude" id="search_longitude" name="search_longitude" size="30" value="">
              </div>
              <?php echo form_close(); ?>
              <!-- Wave Block -->
              <svg class="_ticketing-wave_ql3k7z _ticketing-wave-start_ql3k7z" width="100%" height="100%" viewBox="0 0 1680 215" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <defs>
                <rect id="path-1" x="0" y="0" width="1680" height="215"></rect>
              </defs>
              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="wave">
                  <mask id="mask-2" fill="white">
                    <use xlink:href="#path-1"></use>
                  </mask>
                  <g id="Rectangle-path"></g>
                  <path d="M2845.16,110.207 C2668.53,-733.583 2265.71,-105.374 1421.99,71.6296 C578.275,248.633 -386.757,-93.0009 -210.125,750.789 C-33.4932,1594.58 793.558,2135.06 1637.14,1958.27 C2480.86,1781.27 3021.79,953.998 2845.16,110.207 Z" id="Shape" fill="#292929" fill-rule="nonzero" mask="url(#mask-2)"></path>
                </g>
              </g>
            </svg>
          </div>
          <!-- Third Block -->
          <div class="col-lg-12 col-md-12 col-sm-12 float-right block colored-block" style="background:#292929;">
              <div class="col-lg-4 col-md-4 col-sm-12 float-right ticketing">
                  <img src="<?php echo base_url(); ?>vendor/images/tickets.png" class="tickets">
              </div>
              <div class="col-lg-8 col-md-8 col-sm-12 float-right ticketing-desc">
                  <div class="tick-dtitle">
                      غيرنا مفهوم التذاكر
                  </div>
                  <div class="tick-desc">
                      قامت وجهتنا بتغيير الاهتمام من الوكلاء إلى أصحاب الفعاليات أنفسهم بحيث يُصبح لديكم اتصال بالمهتمين بكم.
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 float-right m-link">
                      <a class="tell-more" href="<?php echo base_url().'pages/promote'; ?>">المزيد</a>
                  </div>
              </div>
              <!--Wave Block-->
              <svg class="_ticketing-wave_ql3k7z _ticketing-wave-bottom_ql3k7z" width="100%" height="100%" viewBox="0 0 1680 165" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <defs>
                <rect id="path-1" x="0" y="0" width="1680" height="165"></rect>
              </defs>
              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="wave">
                  <mask id="mask-2" fill="white">
                    <use xlink:href="#path-1"></use>
                  </mask>
                  <g id="Rectangle-path"></g>
                  <path d="M-199.649,511.727 C-249.733,-194.316 209.436,210.474 915.372,159.35 C1621.31,108.225 2306.52,-379.754 2356.61,326.288 C2406.69,1032.33 1875.09,1646.07 1169.31,1697.33 C463.378,1748.45 -149.565,1217.77 -199.649,511.727 Z" id="Shape" fill="#FFFFFF" fill-rule="nonzero" mask="url(#mask-2)"></path>
                </g>
              </g>
            </svg>
          </div>
