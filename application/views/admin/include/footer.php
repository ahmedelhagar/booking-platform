<?php $ettings = (array) $this->main_model->getByData('settings','id',1)[0]; ?>
</div>
      <!-- End Content -->  
      <!-- Start Footer -->
      <footer>
          <!-- Footer Block -->
          <div class="col-lg-4 col-md-4 col-sm-12 footer-block">
          <!-- Text Logo -->
              <div class="text-logo">
                  <a href="#">
                      <img src="<?php echo base_url().'vendor/images/logo.png'; ?>" alt="وجهتنا">
                  </a>
              </div>
              <div class="do-more">
                  نفذ أكثر مما تحب.
              </div>
              <span class="copy-r">© 2020 وجهتنا</span>
          </div>
          <!-- Footer Block -->
          <div class="col-lg-2 col-md-2 col-sm-12 footer-block">
              <h5>العملاء</h5>
              <ul class="f-links">
                  <?php if($this->main_model->is_logged_in()){ ?>
                  <li><a href="<?php echo base_url().'users/events/'.$this->session->userdata('username'); ?>">الفعاليات</a></li>
                  <li><a href="<?php echo base_url().'users/tickets/'; ?>">التذاكر</a></li>
                  <?php } ?>
                  <li><a href="<?php echo base_url().'pages/spage/1/'; ?>">شرح استخدام الموقع</a></li>
                  <li><a href="<?php echo base_url().'pages/spage/2/'; ?>">الأسئلة الشائعة</a></li>
              </ul>
          </div>
          <!-- Footer Block -->
          <div class="col-lg-2 col-md-2 col-sm-12 footer-block">
              <h5>الشركاء</h5>
              <ul class="f-links">
                  <li><a href="<?php echo base_url().'pages/promote'; ?>">انشر فعاليتك</a></li>
                  <li><a href="<?php echo base_url().'pages/promote'; ?>">مساعدة</a></li>
              </ul>
          </div>
          <!-- Footer Block -->
          <div class="col-lg-2 col-md-2 col-sm-12 footer-block">
              <h5>الشركة</h5>
              <ul class="f-links">
                  <li><a href="<?php echo base_url().'pages/spage/3/'; ?>">من نحن</a></li>
                  <li><a href="<?php echo base_url().'blog'; ?>">المدونة</a></li>
              </ul>
          </div>
          <!-- Footer Block -->
          <div class="col-lg-2 col-md-2 col-sm-12 footer-block">
              <h5>تواصل معنا</h5>
              <ul class="f-links">
                  <li><a href="<?php echo $ettings['instagram']; ?>">انستجرام</a></li>
                  <li><a href="<?php echo $ettings['twitter']; ?>">تويتر</a></li>
                  <li><a href="<?php echo $ettings['facebook']; ?>">فيس بوك</a></li>
              </ul>
          </div>
      </footer>
      <!-- End Footer -->

      <!-- Bootstrap core JavaScript -->
        
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCTdTFQ2EaR0HyvG-mo97zTkVZLpGZQv7c"></script>
        <!-- Google maps Script -->
        <script type="text/javascript">
        
        $(document).ready(function () {
                $('.logo-icon').click(function() {
                $('.r-nav').fadeToggle();
                $('.rnav-overlay').fadeToggle();
                $('html').toggleClass('scroll-off');
            });
            $('.rnav-overlay').click(function() {
                $('.r-nav').fadeToggle();
                $('.rnav-overlay').fadeToggle();
                $('html').toggleClass('scroll-off');
            });

            $('.close-rnav').click(function() {
                $('.r-nav').fadeToggle();
                $('.rnav-overlay').fadeToggle();
                $('html').toggleClass('scroll-off');
            });
        })
            var searchInput = 'search_ByState';

        $(document).ready(function () {
            
            <?php
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
            ?>
            //Using the value
            $('select[name="mtag"]').find('option[value="<?php echo $item[0]->mtag; ?>"]').attr("selected",true);
            $('#<?php echo $item[0]->mtag; ?>').fadeIn();
            //Using the value
            $('select[name="subtag_"]').find('option[value="<?php echo $item[0]->subtag; ?>"]').attr("selected",true);
            <?php } ?>
            
            var autocomplete;
            autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
                types: ['geocode'],
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var near_place = autocomplete.getPlace();
                document.getElementById('loc_lat').value = near_place.geometry.location.lat();
                document.getElementById('loc_long').value = near_place.geometry.location.lng();

                document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
                document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
            });
        });
        $(document).on('change', '#'+searchInput, function () {
            document.getElementById('latitude_input').value = '';
            document.getElementById('longitude_input').value = '';

            document.getElementById('latitude_view').innerHTML = '';
            document.getElementById('longitude_view').innerHTML = '';
        });
        </script>
        <script type="text/javascript">
    if (window.location.hash && window.location.hash == '#_=_') {
        if (window.history && history.pushState) {
            window.history.pushState("", document.title, window.location.pathname);
        } else {
            // Prevent scrolling by storing the page's current scroll offset
            var scroll = {
                top: document.body.scrollTop,
                left: document.body.scrollLeft
            };
            window.location.hash = '';
            // Restore the scroll offset, should be flicker free
            document.body.scrollTop = scroll.top;
            document.body.scrollLeft = scroll.left;
        }
    }
</script>
        <script type="text/javascript" src="<?php echo base_url().'vendor/js/home.js'; ?>"></script>
  </body>
</html>