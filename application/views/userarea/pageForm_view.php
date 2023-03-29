<?php $this->load->view('include/header.php'); ?>
<div class="container-fluid allUsers addpage">
    <br />
    
    <div class="col-lg-8 col-md-8 col-sm-12 s-pro register">
        <div class="col-lg-12 col-md-12 col-sm-12 s-pro">
            <div class="col-lg-12 col-md-12 col-sm-12 s_block">
                <?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){ ?>
                <h4 class="pt-10">تعديل</h4>
                <?php }else{ ?>
                <h4 class="pt-10">إضافة صفحة</h4>
                <?php } ?>
                <?php 
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                        $mCheck = 'editCheck/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5);
                    }else{
                        $mCheck = 'addPageCheck';
                    }
                    echo form_open_multipart(base_url().'users/'.$mCheck.'/',$atrr2);

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
                        تم إضافة الصفحة بنجاح.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }elseif($this->uri->segment(6) == 'done'){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم تعديل الصفحة بنجاح.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';}
                ?>

                <p class="a_rules text-center">يجب إدخال الحقول التي تحتوي على <code>*</code>.</p>
                <label class="float-right mb-0">اسم الصفحة <code>*</code></label>

                <?php
                        $title = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'title',
                            'placeholder'=>'اسم الصفحة'
                        );
                if($this->uri->segment(2) == 'addPageCheck' && isset($p_title)){
                    $title['value'] = $p_title;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $title['value'] = $item[0]->p_name;
                }
                                echo form_input($title);
?>
                <p class="a_rules">أدخل عنواناً واضحاً باللغة العربية يصف الصفحة التي تريد أن تضيفها. لا تدخل رموزاً أو كلمات مثل "حصرياً"، "لأول مرة"، "لفترة محدود".. الخ.</p>
                
                <label class="float-right mb-0">رابط الصفحة</label><br />
                <?php
                $u_name = array(
                'type'=>'text',
                'autocomplete'=>'off',
                'class'=>'form-control',
                'name'=>'username',
                'id'=>'user-nm',
                'placeholder'=>'رابط الصفحة'
                );
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $u_name['value'] = $item[0]->username;
                }
                    echo form_input($u_name);
                ?>
                <label class="usernm"><?php echo base_url().'p/'; ?><span id="u-nm"><?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){echo $item[0]->username;}else{echo 'username';} ?></span></label><br />

                <label class="float-right mb-0">وصف الصفحة <code>*</code></label>
                <?php
                        $content = array(
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'content',
                            'placeholder'=>'اكتب هنا وصف كامل مع كل تفاصيل الصفحة.'
                        );
                if($this->uri->segment(2) == 'addPageCheck' && isset($p_content)){
                    $content['value'] = $p_content;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $content['value'] = $item[0]->p_desc;
                }
                                echo form_textarea($content);
?>
                <p class="a_rules">أدخل وصف الصفحة بدقة يتضمن جميع المعلومات والشروط . يمنع وضع البريد الالكتروني، رقم الهاتف أو أي معلومات اتصال أخرى.</p>

                <label class="float-right mb-0">اختر تصنيف الصفحة الأساسي<code>*</code></label>
                <select class="float-right" id="mtag" name="mtag">
                    <option value="0">-- غير مُصنف --</option>
                    <?php if($mtags){foreach($mtags as $mtag){ ?>
                    <option value="<?php echo $mtag->id; ?>"><?php echo $mtag->tag; ?></option>
                    <?php }} ?>
                </select>
                <div id="parent">
                <?php if($msubtag){foreach($msubtag as $k_mtag => $a_stag){ ?>
                    <div class="s-tags" id="<?php echo $k_mtag; ?>">
                        <label class="float-right mb-0">اختر تصنيف الصفحة الفرعي<code>*</code></label>
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
                    <label class="float-right mb-0">اختر صورة الصفحة <code>*</code></label>
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
                            <label id="p_img_label1" for="p_img1"><div class="pc-img"><img src="<?php echo base_url().'vendor/uploads/images/'.$item[0]->logo; ?>"></div></label>
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
                            'name'=>'tags',
                            'placeholder'=>'الكلمات المفتاحية'
                        );
        if($this->uri->segment(2) == 'addPageCheck' && isset($p_tags)){
                    $tags['value'] = $p_tags;
                }
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $tags['value'] = $item[0]->tags;
                        }
                                echo form_input($tags);
?>
                        <p class="a_rules">مثال: حفلة, مؤتمر...</p>
                
                <label class="float-right mb-0">صفحة الـ Facebook</label>

                        <?php
                        $fb = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'fb',
                            'placeholder'=>'Facebook'
                        );
        if($this->uri->segment(2) == 'addPageCheck' && isset($p_fb)){
                    $fb['value'] = $p_fb;
                }
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $fb['value'] = $item[0]->fb;
                        }
                                echo form_input($fb);
?>
                        <p class="a_rules">غير ضروري.</p>
                
                <label class="float-right mb-0">رابط Instagram</label>

                        <?php
                        $instagram = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'instagram',
                            'placeholder'=>'instagram'
                        );
        if($this->uri->segment(2) == 'addPageCheck' && isset($p_instagram)){
                    $instagram['value'] = $p_instagram;
                }
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $instagram['value'] = $item[0]->instagram;
                        }
                                echo form_input($instagram);
?>
                        <p class="a_rules">غير ضروري.</p>
                
                <label class="float-right mb-0">رابط Twitter</label>

                        <?php
                        $twitter = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'twitter',
                            'placeholder'=>'twitter'
                        );
        if($this->uri->segment(2) == 'addPageCheck' && isset($p_twitter)){
                    $twitter['value'] = $p_twitter;
                }
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $twitter['value'] = $item[0]->twitter;
                        }
                                echo form_input($twitter);
?>
                        <p class="a_rules">غير ضروري.</p>
                
                <label class="float-right mb-0">رابط قناة الـ Youtube</label>

                        <?php
                        $youtube = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'yt',
                            'placeholder'=>'Youtube'
                        );
        if($this->uri->segment(2) == 'addPageCheck' && isset($p_youtube)){
                    $youtube['value'] = $p_youtube;
                }
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $youtube['value'] = $item[0]->yt;
                        }
                                echo form_input($youtube);
?>
                        <p class="a_rules">غير ضروري.</p>
                
                <label class="float-right mb-0">رابط الموقع الإلكتروني</label>

                        <?php
                        $website = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'website',
                            'placeholder'=>'https://domain.com/'
                        );
        if($this->uri->segment(2) == 'addPageCheck' && isset($p_website)){
                    $website['value'] = $p_website;
                }
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $website['value'] = $item[0]->website;
                        }
                                echo form_input($website);
?>
                        <p class="a_rules">غير ضروري.</p>
                
                        <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                       if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            echo form_button($submit,'<span class="fa fa-cogs"></span> تعديل صفحة');
                         }else{echo form_button($submit,'<span class="fa fa-plus"></span> أضف صفحة');};
?>

                        <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>


                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php $this->load->view('include/footer.php'); ?>
