<div class="container-fluid float-right" style="background: #f1f1f1;">
<div class="container-fluid blog-con">
    <div class="col-lg-8 col-md-8 col-sm-12 float-right">
        <div class="container blog-post-page">
            <h4><?php echo $post[0]->title; ?></h4>
            <div class="bp-img col-lg-12 col-md-12 col-sm-12">
                <img src="<?php echo base_url().'vendor/uploads/images/'.$this->main_model->vthumb($post[0]->image); ?>">
            </div>
            <br />
            <div class="dets"><?php echo $post[0]->content; ?></div>
            <br />
        <div id="disqus_thread"></div>
        <script>

        /**
        *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
        *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
        /*
        var disqus_config = function () {
        this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
        this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        */
        (function() { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://wjhtn.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 float-right">
        <div class="discov">
            <h5>اكتشف.</h5>
            <h5>خطط.</h5>
            <h5>استمتع.</h5>
                <div class="_1st-getit">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>vendor/images/gplay.png" class="getit-btn">
                        </a>
                        <a href="#">
                            <img src="<?php echo base_url(); ?>vendor/images/appstore.png" class="getit-btn">
                        </a>
                </div>
        </div>
    </div>
</div>
</div>