<div class="container-fluid float-right" style="background: #f1f1f1;">
<?php if($this->main_model->is_admin_logged_in()){ ?>
<br />
    <h3 class="text-center"><a class="btn btn-success" href="<?php echo base_url().'wjhatnacadmin/addBlog'; ?>"><span class="fa fa-plus"></span> أضف تدوينة</a></h3>
<?php } ?>
<?php if($recordsLimited){foreach($recordsLimited as $recordli){
    $data['mtag'] = $this->main_model->getAllDataCond('tags','state',5,'id',$recordli->mtag);
    $data['subtag'] = $this->main_model->getAllDataCond('tags','state',5,'id',$recordli->subtag);
    ?>
<div class="col-lg-6 col-md-6 col-sm-12 float-right l-blog-con">
    <div class="col-lg-12 col-md-12 col-sm-12 float-right blog-post">
        <div class="bp-img col-lg-12 col-md-12 col-sm-12">
            <img src="<?php echo base_url().'vendor/uploads/images/'.$this->main_model->vthumb($recordli->image); ?>">
        </div>
        <div class="bp-details col-lg-12 col-md-12 col-sm-12">
        <a href="<?php
                echo base_url().'pages/post/'.str_replace(' ','-',$recordli->title).'/'.$recordli->id.'/';
                ?>">
            <h4><?php echo $recordli->title; ?></h4>
            <div class="dets"><?php
                        if(strlen(strip_tags($recordli->content)) <= 100){
                            echo strip_tags($recordli->content);}
                        else{echo substr(strip_tags($recordli->content),0,100).'...';}
                            ?></div>
        </a>
            <span class="info">تمت الإضافة منذ <?php 
                    $differ = $this->main_model->dateTime('diff',$recordli->date,$this->main_model->dateTime('current'));
                    $this->main_model->differ($differ);
                    ?> بواسطة WjhatnaAdmin <?php echo $data['mtag'][0]->tag.' '.$data['subtag'][0]->tag; ?></span>
                    <?php if($this->main_model->is_admin_logged_in()){ ?>
                    <h3>
                        <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/items/'.$recordli->id.'/?m=blog'; ?>"><span class="fa fa-trash"></span> حذف</a>
                        <span class="edit"><a href="<?php echo base_url().'wjhatnacadmin/edit/items/'.$recordli->id.'/blog/'; ?>"><span class="fa fa-cog"></span> تعديل</a></span>
                    </h3>
                    <?php } ?>
        </div>
    </div>
</div>
<?php }}else{
            ?>
            <h4 class="text-center float-right">لا يوجد تدوينات.</h4>
            <?php
        } ?>
<div class="container-fluid blog-con">
    <div class="col-lg-8 col-md-8 col-sm-12 float-right">
        <div class="container">
        <?php if($records){foreach($records as $record){
            $data['mtag'] = $this->main_model->getAllDataCond('tags','state',5,'id',$record->mtag);
            $data['subtag'] = $this->main_model->getAllDataCond('tags','state',5,'id',$record->subtag);
            ?>
            <div class="blog-post">
                <div class="bp-img col-lg-3 col-md-3 col-sm-12">
                    <img src="<?php echo base_url().'vendor/uploads/images/'.$this->main_model->vthumb($record->image); ?>">
                </div>
                <div class="bp-details col-lg-9 col-md-9 col-sm-12">
                <a href="<?php
                echo base_url().'pages/post/'.str_replace(' ','-',$record->title).'/'.$record->id.'/';
                ?>">
                    <h4><?php echo $record->title; ?></h4>
                    <div class="dets"><?php
                        if(strlen(strip_tags($record->content)) <= 100){
                            echo strip_tags($record->content);}
                        else{echo substr(strip_tags($record->content),0,100).'...';}
                            ?></div>
                </a>
                    <span class="info">تمت الإضافة منذ <?php 
                    $differ = $this->main_model->dateTime('diff',$record->date,$this->main_model->dateTime('current'));
                    $this->main_model->differ($differ);
                    ?> بواسطة WjhatnaAdmin <?php echo $data['mtag'][0]->tag.' '.$data['subtag'][0]->tag; ?></span>
                    <?php if($this->main_model->is_admin_logged_in()){ ?>
                    <h3>
                        <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/items/'.$record->id.'/?m=wjhatnacadmin/addBlog'; ?>"><span class="fa fa-trash"></span> حذف</a>
                    </h3>
                    <?php } ?>
                </div>
                <?php if($this->main_model->is_admin_logged_in()){ ?>
                    <span class="edit"><a href="<?php echo base_url().'wjhatnacadmin/edit/items/'.$recordli->id.'/blog/'; ?>"><span class="fa fa-cog"></span> تعديل</a></span>
                <?php } ?>
            </div>
        <?php }}else{
            ?>
            <h4 class="text-center float-right">لا يوجد تدوينات.</h4>
            <?php
        } ?>
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
    <!-- Pagination -->
      <ul class="pagination justify-content-center pager"><?php echo $links; ?></ul>
</div>
</div>