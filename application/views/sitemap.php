<?php header('Content-type: text/xml'); ?>
<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= base_url();?></loc> 
        <priority>1.0</priority>
    </url>
    <?php if($records){foreach($records as $url) { ?>
    <url>
        <loc>
        <?php 
                          $url_l = str_replace(' ','-',$url->title).'/'.$url->id.'/';
                          if($url->type == 5){
                            echo base_url().'pages/post/'.$url_l;
                          }else{
                            echo base_url().'i/'.$url_l;
                          }
                          ?>
        </loc>
        <priority>0.5</priority>
    </url>
    <?php }} ?>
</urlset>