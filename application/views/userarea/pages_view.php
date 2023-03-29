<?php $this->load->view('include/header.php'); ?>
<div class="container-fluid allUsers">
    <br />
    <?php 
        if($pages){
            foreach($pages as $page){
        ?>
    <div class="col-lg-4 col-md-4 col-sm-12 float-right pad-page">
        <div class="col-lg-12 col-md-12 col-sm-12 page">
            <div class="page-image"><img src="<?php echo base_url().'vendor/uploads/images/'.$this->main_model->vthumb($page->logo); ?>"></div>
            <h6><a href="<?php echo base_url().'p/'.$page->username; ?>"><?php echo $page->p_name; ?> <span class="fa fa-caret-left"></span></a></h6>
            <div class="followers">
                <?php if($this->session->userdata('id') == $page->u_id){ ?>
                <div class="follow float-right"><a href="<?php echo base_url().'users/addEvent/'.$page->id; ?>"><span class="fa fa-plus"></span> أضف فعالية</a></div>
                <div class="follow float-right"><a href="<?php echo base_url().'users/addPromo/'.$page->id; ?>"><span class="fa fa-plus"></span> أضف عرض</a></div>
                <div class="float-right container-fluid" style="margin-top:10px;">
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'users/edit/pages/'.$page->id.'/page/'; ?>"><span class="fa fa-cog"></span> تعديل</a></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'users/delete/pages/'.$page->id.'/?m=users/pages/'.$this->session->userdata('username'); ?>"><span class="fa fa-trash"></span> حذف</a></div>
                </div>
                <?php }else{ $followers = $this->main_model->getFullRequest('followers','p_id = '.$page->id,'count');
                if($followers == null){
                    $followers = 0;
                }
                ?>
                <div class="followers-num"><span id="f-num"><?php echo $followers; ?></span> متابع</div>
                <?php
                    if($this->main_model->is_logged_in()){
                    $followed = $this->main_model->getFullRequest('followers','f_id = '.$this->session->userdata('id').' AND p_id = '.$page->id);
                    if(!$followed){
                ?>
                <div id="follow-btn" onclick="return follow('<?php echo $page->id; ?>')" class="follow"><span class="fa fa-plus"></span> متابعة</div>
                <?php }else{ ?>
                <div id="follow-btn" onclick="return follow('<?php echo $page->id; ?>')" class="follow"><span class="fa fa-trash"></span> إلغاء متابعة</div>
                <?php }}else{ ?>
                <div id="follow-btn" onclick="return follow('<?php echo $page->id; ?>')" class="follow"><span class="fa fa-plus"></span> متابعة</div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
        }
        ?>
    <!-- Pagination -->
      <ul class="pagination justify-content-center pager"><?php echo $links; ?></ul>
    <?php
    }else{echo '<h3>لايوجد صفحات لعرضها.</h3>';}
    ?>
</div>
<?php $this->load->view('include/footer.php'); ?>