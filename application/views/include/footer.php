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
        
        <?php
        if ($this->uri->segment(1)) {
            // We are not on the homepage
        ?>
        <script src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <?php
        }
        ?>
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
            var autocomplete;
            autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
                types: ['geocode'],
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var near_place = autocomplete.getPlace();
                /*document.getElementById('loc_lat').value = near_place.geometry.location.lat();
                document.getElementById('loc_long').value = near_place.geometry.location.lng();

                document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
                document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();*/
                //alert($('input[name=g_location]').val());
                document.getElementsByTagName('button')[0].click();
            });
            <?php
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
            ?>
            //Using the value
            $('select[name="mtag"]').find('option[value="<?php echo $item[0]->mtag; ?>"]').attr("selected",true);
            $('#<?php echo $item[0]->mtag; ?>').fadeIn();
            //Using the value
            $('select[name="subtag_"]').find('option[value="<?php echo $item[0]->subtag; ?>"]').attr("selected",true);
            <?php if($this->uri->segment(3) == 'items'){ ?>
            //Using the value
            $('select[name="fm"]').find('option[value="<?php echo explode(' ',$item[0]->s_date)[2]; ?>"]').attr("selected",true);
            $('select[name="tm"]').find('option[value="<?php echo explode(' ',$item[0]->e_date)[2]; ?>"]').attr("selected",true);
            <?php }} ?>
            
        });
        $(document).on('change', '#'+searchInput, function () {
            document.getElementById('latitude_input').value = '';
            document.getElementById('longitude_input').value = '';

            document.getElementById('latitude_view').innerHTML = '';
            document.getElementById('longitude_view').innerHTML = '';
        }); 
        </script>
        <script type="text/javascript">
        var geocoder;
        var map;
        var marker;

        /*
         * Google Map with marker
         */
        function initialize() {
            var initialLat = $('.search_latitude').val();
            var initialLong = $('.search_longitude').val();
            <?php
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
            ?>
                initialLat = initialLat?initialLat:<?php echo $item[0]->search_latitude; ?>;
                initialLong = initialLong?initialLong:<?php echo $item[0]->search_longitude; ?>;
            <?php
                }else{
            ?>
                initialLat = initialLat?initialLat:24.774265;
                initialLong = initialLong?initialLong:46.738586;
            <?php } ?>

            var latlng = new google.maps.LatLng(initialLat, initialLong);
            var options = {
                zoom: 10,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("geomap"), options);

            geocoder = new google.maps.Geocoder();

            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: latlng
            });

            google.maps.event.addListener(marker, "dragend", function () {
                var point = marker.getPosition();
                map.panTo(point);
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        marker.setPosition(results[0].geometry.location);
                        $('.search_addr').val(results[0].formatted_address);
                        $('.search_latitude').val(marker.getPosition().lat());
                        $('.search_longitude').val(marker.getPosition().lng());
                    }
                });
            });

        }

        $(document).ready(function () {
            //load google map
            initialize();
            /*
             * Point location on google map
             */
            $('.get_map').click(function (e) {
                var address = $('#search_ByState').val();
                geocoder.geocode({'address': address}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        marker.setPosition(results[0].geometry.location);
                        $('.search_addr').val(results[0].formatted_address);
                        $('.search_latitude').val(marker.getPosition().lat());
                        $('.search_longitude').val(marker.getPosition().lng());
                        document.getElementById("home-form").submit();
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
                e.preventDefault();
            });

            //Add listener to marker for reverse geocoding
            google.maps.event.addListener(marker, 'drag', function () {
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('.search_addr').val(results[0].formatted_address);
                            $('.search_latitude').val(marker.getPosition().lat());
                            $('.search_longitude').val(marker.getPosition().lng());
                        }
                    }
                });
            });
        geocoder.geocode({
            'address': request.term,
            componentRestrictions: {country: "KSA"}
        })
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
                   function follow(id){
                 // your code go here
                $.ajax({
                    url:"<?php echo base_url('users/follow/'); ?>",
                    type:"POST",
                    dataType: "json",
                    async: true,
                    data: {
                        'id' : id,
                        'request' : 'follow',
                    },
                    success:function(response){
                        if(response.done == 1){
                            $('#follow-btn').html('<span class="fa fa-trash"></span> إلغاء متابعة');
                            $('#f-num').html(response.num);
                        }else if (response.done == 0){
                            window.location = '<?php echo base_url(); ?>'+'pages/login';
                        }else if (response.done == 2){
                            $('#follow-btn').html('<span class="fa fa-plus"></span> متابعة');
                            $('#f-num').html(response.num);
                        }
                        }
                });
            }       
</script>
<?php if($this->main_model->is_logged_in()){ ?>

          <script type="text/javascript">
          function seen(id){
                 // your code go here
                $.ajax({
                    url:"<?php echo base_url('users/fetchalerts/'); ?>",
                    type:"POST",
                    dataType: "json",
                    async: true,
                    data: {
                        'id' : id,
                        'request' : 'seen',
                    },
                    success:function(response){
                        if(response.done == 1){
                            $('.al-num').html('');
                        }
                        }
                });
            }

              setInterval(function(){
                 $.ajax({
                    url:"<?php echo base_url('users/fetchalerts/'); ?>",
                    type:"POST",
                    dataType: "json",
                    async: true,
                    data: {
                        'id' : <?php echo $this->session->userdata('id'); ?>,
                        'request' : 'unseen',
                    },
                    success:function(response){
                            if(response.done == 1){
                                $('.al-num').html('<div class="alerts-nums">'+response.nums+'</div>');
                                var allAlerts = '';
                                for (var i=0; i<response.alerts.length; i++) {
                                    allAlerts += '<div class="d_item"><p><b>'+response.alerts[i].title+'</b></p>'+response.alerts[i].description+'</div>';
                                }
                                $('.allalerts').html(allAlerts);
                            }
                        }
                });
                }, 20000);
          </script>
<?php } ?>
<?php
        if ($this->uri->segment(1)) {
            // We are not on the homepage
        ?>
        <script type="text/javascript" src="<?php echo base_url().'vendor/js/home.js'; ?>"></script>
<?php } ?>
  </body>
</html>