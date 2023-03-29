<?php $this->load->view('admin/include/header.php'); ?>
<script src="<?php echo base_url().'vendor/js/ckeditor.js'; ?>"></script>
<div class="container-fluid allUsers">
    <br />
    <div class="container-fluid float-right">
    <?php
        if($mtags){ ?>
        <div class="col-lg-3 col-md-3 col-sm-12 float-right tags-block">
        <h3 class="tags-bti" id="b1">أقسام الفعاليات</h3>
        <?php foreach($mtags as $main){
            $sub = $this->main_model->getByData('tags','c_tag',$main->id);
    ?>
        <div class="col-lg-12 col-md-12 col-sm-12 float-right tags-blocks b1">
            <h3><?php echo $main->tag; ?> <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/tags/'.$main->id.'/?m=wjhatnacadmin/addTag'; ?>"><span class="fa fa-trash"></span> حذف</a></h3>
            <ul>
                <?php if($sub){foreach($sub as $subtag){ ?>
                <li><?php echo $subtag->tag; ?> <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/tags/'.$subtag->id.'/?m=wjhatnacadmin/addTag'; ?>"><span class="fa fa-trash"></span> حذف</a></li>
                <?php }} ?>
            </ul>
        </div>
    <?php
        }}
    ?>
    </div>
    <?php   if($ftags){ ?>
        <div class="col-lg-3 col-md-3 col-sm-12 float-right tags-block">
        <h3 class="tags-bti" id="b2">أقسام العروض</h3>
        <?php foreach($ftags as $subtag){
            $sub2 = $this->main_model->getByData('tags','c_tag',$subtag->id);
    ?>
        <div class="col-lg-12 col-md-12 col-sm-12 float-right tags-blocks b2">
            <h3><?php echo $subtag->tag; ?> <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/tags/'.$subtag->id.'/?m=wjhatnacadmin/addTag'; ?>"><span class="fa fa-trash"></span> حذف</a></h3>
            <ul>
                <?php if($sub2){foreach($sub2 as $subtag2){ ?>
                <li><?php echo $subtag2->tag; ?> <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/tags/'.$subtag2->id.'/?m=wjhatnacadmin/addTag'; ?>"><span class="fa fa-trash"></span> حذف</a></li>
                <?php }} ?>
            </ul>
        </div>
    <?php
        }}
    ?>
    </div>
    <?php   if($blog){ ?>
        <div class="col-lg-3 col-md-3 col-sm-12 float-right tags-block">
        <h3 class="tags-bti" id="b5">أقسام المدونة</h3>
        <?php foreach($blog as $subtag){
            $sub2 = $this->main_model->getByData('tags','c_tag',$subtag->id);
    ?>
        <div class="col-lg-12 col-md-12 col-sm-12 float-right tags-blocks b5">
            <h3><?php echo $subtag->tag; ?> <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/tags/'.$subtag->id.'/?m=wjhatnacadmin/addTag'; ?>"><span class="fa fa-trash"></span> حذف</a></h3>
            <ul>
                <?php if($sub2){foreach($sub2 as $subtag2){ ?>
                <li><?php echo $subtag2->tag; ?> <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/tags/'.$subtag2->id.'/?m=wjhatnacadmin/addTag'; ?>"><span class="fa fa-trash"></span> حذف</a></li>
                <?php }} ?>
            </ul>
        </div>
    <?php
        }}
    ?>
    </div>
    <?php   if($pages){ ?>
        <div class="col-lg-3 col-md-3 col-sm-12 float-right tags-block">
        <h3 class="tags-bti" id="b3">أقسام الصفحات</h3>
        <?php foreach($pages as $page){
            $sub3 = $this->main_model->getByData('tags','c_tag',$page->id);
    ?>
        <div class="col-lg-12 col-md-12 col-sm-12 float-right tags-blocks b3">
            <h3><?php echo $page->tag; ?> <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/tags/'.$page->id.'/?m=wjhatnacadmin/addTag'; ?>"><span class="fa fa-trash"></span> حذف</a></h3>
            <ul>
                <?php if($sub3){foreach($sub3 as $subtag3){ ?>
                <li><?php echo $subtag3->tag; ?> <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/tags/'.$subtag3->id.'/?m=wjhatnacadmin/addTag'; ?>"><span class="fa fa-trash"></span> حذف</a></li>
                <?php }} ?>
            </ul>
        </div>
    <?php
        }}
    ?>
    </div>
    </div>
    <div class="container-fluid float-right">
    <div class="col-lg-8 col-md-8 col-sm-12 s-pro register">
        <div class="col-lg-12 col-md-12 col-sm-12 s-pro">
            <div class="col-lg-12 col-md-12 col-sm-12 s_block">
                <h4 class="pt-10">إضافة تصنيف</h4>
                <?php 
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    echo form_open_multipart(base_url().'wjhatnacadmin/addTagCheck/',$atrr2);

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
                        تم إضافة التصنيف بنجاح.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                ?>
                
                <p class="a_rules text-center">يجب إدخال الحقول التي تحتوي على <code>*</code>.</p>
                <div class="col-lg-12 col-md-12 col-sm-12 float-right">
                    <div class="col-lg-3 col-md-3 col-sm-12 float-right r-type2 evpro-active" id="0">
                        <p>أقسام</p>
                        <p>الفعاليات</p>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 float-right r-type2" id="2">
                        <p>أقسام</p>
                        <p>العروض</p>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 float-right r-type2" id="5">
                        <p>أقسام</p>
                        <p>المدونة</p>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 float-right r-type2" id="3">
                        <p>أقسام</p>
                        <p>الصفحات</p>
                    </div>
                    <?php
                    $hidden = array(
                    'type'=>'hidden',
                    'name'=>'cat',
                    'value'=>'0'
                    );
                        echo form_input($hidden);
                    ?>
                </div>
                <div id="events">
                    <label class="float-right mb-0">تحت تصنيف <code>*</code></label>
                    <select class="float-right" name="events">
                        <?php if($mtags){foreach($mtags as $mtag){ ?>
                        <option value="<?php echo $mtag->id; ?>"><?php echo $mtag->tag; ?></option>
                        <?php }}else{ ?>
                        <option value="0">لايوجد</option>
                        <?php } ?>
                    </select>
                </div>
                <div id="fest">
                    <label class="float-right mb-0">تحت تصنيف <code>*</code></label>
                    <select class="float-right" name="fest">
                        <?php if($ftags){foreach($ftags as $ftag){ ?>
                        <option value="<?php echo $ftag->id; ?>"><?php echo $ftag->tag; ?></option>
                        <?php }}else{ ?>
                        <option value="0">لايوجد</option>
                        <?php } ?>
                    </select>
                </div>
                <div id="blog">
                    <label class="float-right mb-0">تحت تصنيف <code>*</code></label>
                    <select class="float-right" name="blog">
                        <?php if($blog){foreach($blog as $ftag){ ?>
                        <option value="<?php echo $ftag->id; ?>"><?php echo $ftag->tag; ?></option>
                        <?php }}else{ ?>
                        <option value="0">لايوجد</option>
                        <?php } ?>
                    </select>
                </div>
                <div id="pages">
                    <label class="float-right mb-0">تحت تصنيف <code>*</code></label>
                    <select class="float-right" name="pages">
                        <?php if($pages){foreach($pages as $page){ ?>
                        <option value="<?php echo $page->id; ?>"><?php echo $page->tag; ?></option>
                        <?php }}else{ ?>
                        <option value="0">لايوجد</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 float-right">
                    <div class="col-lg-6 col-md-6 col-sm-12 float-right r-type type-active" id="0">
                        <p>تصنيف</p>
                        <p>أساسي</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 float-right r-type" id="1">
                        <p>تصنيف</p>
                        <p>فرعي</p>
                    </div>
                </div>
                <?php
                    $hidden = array(
                    'type'=>'hidden',
                    'name'=>'type',
                    'value'=>'0'
                    );
                        echo form_input($hidden);
                    ?>
                <div id="c_name">
                    <label class="float-right mb-0">تحت تصنيف <code>*</code></label>
                    <select class="float-right" name="events">
                        <?php if($mtags){foreach($mtags as $mtag){ ?>
                        <option value="<?php echo $mtag->id; ?>"><?php echo $mtag->tag; ?></option>
                        <?php }}else{ ?>
                        <option value="0">لايوجد</option>
                        <?php } ?>
                    </select>
                </div>
                <label class="float-right mb-0">اسم التصنيف <code>*</code></label>
                <?php 
                    $tag = array(
                        'type' => 'text',
                        'autocomplete'=>'off',
                        'class'=>'form-control text-right float-right',
                        'name'=>'tag',
                        'placeholder'=>'اسم التصنيف'
                    );
                echo form_input($tag);
                ?>
                        <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                                echo form_button($submit,'<span class="fa fa-plus"></span> أضف التصنيف');
?>

                        <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>


                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            </div>
        </div>
    <script>
        CKEDITOR.replace('content', {
            extraPlugins: 'bidi',
            // Setting default language direction to right-to-left.
            contentsLangDirection: 'rtl',
            height: 270,
        });

    </script>
    <?php $this->load->view('admin/include/footer.php'); ?>
