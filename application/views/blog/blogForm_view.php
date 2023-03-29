<?php $this->load->view('admin/include/header.php'); ?>
<script src="<?php echo base_url(); ?>vendor/js/ckeditor.js"></script>
<div class="container allUsers" style="background: #fff;">
        <div class="col-lg-12 col-md-12 col-sm-12 s-pro">
            <div class="col-lg-12 col-md-12 col-sm-12 s_block">
                <h4 class="pt-10">إضافة تدوينة</h4>
                <?php 
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                        $mCheck = 'editCheck/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5);
                    }else{
                        $mCheck = 'addBlogCheck';
                    }
                    echo form_open_multipart(base_url().'wjhatnacadmin/'.$mCheck.'/',$atrr2);

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
                        تم إضافة التدوينة.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }elseif($this->uri->segment(6) == 'done'){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم تعديل التدوينة بنجاح.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                ?>

                <p class="a_rules text-center">يجب إدخال الحقول التي تحتوي على <code>*</code>.</p>
                <label class="float-right mb-0">اسم التدوينة <code>*</code></label>

                <?php
                if($this->uri->segment(3) !== '' && isset($pageId)){echo form_input($pageId);}
                        $title = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'title',
                            'placeholder'=>'اسم التدوينة'
                        );
                        if($this->uri->segment(2) == 'addBlogCheck' && isset($p_title)){
                            $title['value'] = $p_title;
                        }
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $title['value'] = $item[0]->title;
                        }
                                echo form_input($title);
?>
                <p class="a_rules">أدخل عنواناً واضحاً باللغة العربية يصف التدوينة التي تريد أن تضيفها. لا تدخل رموزاً.</p>


                <label class="float-right mb-0">وصف التدوينة <code>*</code></label>
                <?php
                        $content = array(
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'content',
                            'id'=>'editor',
                            'placeholder'=>'اكتب هنا وصف كامل مع كل تفاصيل التدوينة.'
                        );
                        if($this->uri->segment(2) == 'addBlogCheck' && isset($p_content)){
                            $content['value'] = $p_content;
                        }
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $content['value'] = $item[0]->content;
                        }
                                echo form_textarea($content);
?>
                <p class="a_rules">أدخل التدوينة بدقة يتضمن جميع المعلومات والصور.</p>
                <label class="float-right mb-0">اختر تصنيف التدوينة الأساسي<code>*</code></label>
                <select class="float-right" id="mtag" name="mtag">
                    <option value="0">-- غير مُصنف --</option>
                    <?php if($mtags){foreach($mtags as $mtag){ ?>
                    <option value="<?php echo $mtag->id; ?>"><?php echo $mtag->tag; ?></option>
                    <?php }} ?>
                </select>
                <div id="parent">
                <?php if($msubtag){foreach($msubtag as $k_mtag => $a_stag){ ?>
                    <div class="s-tags" id="<?php echo $k_mtag; ?>">
                        <label class="float-right mb-0">اختر تصنيف التدوينة الفرعي<code>*</code></label>
                        <select class="float-right" name="subtag_" id="subtag_<?php echo $k_mtag; ?>">
                            <?php if($a_stag){foreach($a_stag as $_stag){ ?>
                                <option value="<?php echo $_stag->id; ?>"><?php echo $_stag->tag; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                <?php }} ?>
                    </div>
                <?php
                                $subtag = array(
                                            'type'=>'hidden',
                                            'name'=>'subtag'
                                        );
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $subtag['value'] = $item[0]->subtag;
                        }
                                echo form_input($subtag);
                        ?>
                    <label class="float-right mb-0">اختر صورة التدوينة <code>*</code></label>
                    <?php
                        $p_img1 = array(
                            'type'=>'file',
                            'class'=>'form-control',
                            'name'=>'img1',
                            'id'=>'p_img1'
                        );
                                echo '<div class="col-lg-12 col-md-12 col-sm-12 float-right">'.form_input($p_img1).'</div>';
                    ?>


                    <div class="pc-imgholder" id="dropContainer1">
                        <?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){ ?>
                            <label id="p_img_label1" for="p_img1"><div class="pc-img"><img src="<?php echo base_url().'vendor/uploads/images/'.$item[0]->image; ?>"></div></label>
                        <?php
                        }else{
                        ?>
                        <label id="p_img_label1" for="p_img1">+ <span class="fa fa-image"></span></label>
                        <?php } ?>
                    </div>
                    <p class="a_rules">الإمتدادات المسموحة JPG,PNG,JPEG.<?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){echo '... اتركها كما هي أو فارغة إذا أردت عدم تغيير الصورة.';}?></p>

                        <label class="float-right mb-0">كلمات مفتاحية <code>*</code></label>

                        <?php
                        $tags = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'tags'
                        );
                        if($this->uri->segment(2) == 'addBlogCheck' && isset($p_tags)){
                            $tags['value'] = $p_tags;
                        }
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $tags['value'] = $item[0]->tags;
                        }
                                echo form_input($tags);
?>
                        <p class="a_rules">مثال: حفلة, مؤتمر...</p>
                
                        <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            echo form_button($submit,'<span class="fa fa-cogs"></span> تعديل التدوينة');
                             }else{echo form_button($submit,'<span class="fa fa-plus"></span> أضف التدوينة');} 
?>

                        <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>


                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            CKEDITOR.replace( 'content' , {
            extraPlugins: 'bidi',
            // Setting default language direction to right-to-left.
            contentsLangDirection: 'rtl',
                height: 270,
            });
        </script>
    <?php $this->load->view('admin/include/footer.php'); ?>
