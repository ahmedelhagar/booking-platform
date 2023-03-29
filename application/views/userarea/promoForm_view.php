<?php $this->load->view('include/header.php'); ?>
<div class="container-fluid allUsers">
    <br />
    <?php 
            $page = $this->main_model->getAllDataCond('pages','id',$this->uri->segment(3),'u_id',$this->session->userdata('id'));
            if($page){
                $floatC = ' float-right';
                 $pageId = array(
                            'type'=>'hidden',
                            'name'=>'p_id',
                            'value'=>$this->uri->segment(3)
                        );
        ?>
        <div class="col-lg-4 col-md-4 col-sm-12 float-right pad-page">
            <div class="col-lg-12 col-md-12 col-sm-12 page">
                <div class="page-image"><img src="<?php echo base_url().'vendor/uploads/images/'.$this->main_model->vthumb($page[0]->logo); ?>"></div>
                <h6><a href="<?php echo base_url().'p/'.$page[0]->username; ?>"><?php echo $page[0]->p_name; ?> <span class="fa fa-caret-left"></span></a></h6>
                <div class="followers">
                    <?php if($this->session->userdata('id') == $page[0]->u_id){ ?>
                    <div class="follow float-right"><a href="<?php echo base_url().'users/addEvent/'.$page[0]->id; ?>"><span class="fa fa-plus"></span> أضف فعالية</a></div>
                    <div class="follow float-right"><a href="<?php echo base_url().'users/addPromo/'.$page[0]->id; ?>"><span class="fa fa-plus"></span> أضف عرض</a></div>
                    <div class="float-right container-fluid" style="margin-top:10px;">
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'users/edit/pages/'.$page[0]->id.'/page/'; ?>"><span class="fa fa-cog"></span> تعديل</a></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'users/delete/pages/'.$page[0]->id.'/?m=users/pages/'.$this->session->userdata('username'); ?>"><span class="fa fa-trash"></span> حذف</a></div>
                    </div>
                    <?php }else{ ?>
                    <div class="followers-num">452 متابع</div>
                    <div class="follow"><span class="fa fa-plus"></span> متابعة</div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
            }elseif(!$page && $this->uri->segment(2) !== 'edit' && $this->uri->segment(2) !== 'editCheck'){redirect(base_url().'user/'.$this->session->userdata('username'));}
        ?>
        <?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
            ?>
    <div class="col-lg-4 col-md-4 col-sm-12 float-right tickets">
        <a class="add-ticket" href="<?php echo base_url().'users/addTicket/'.$this->uri->segment(4); ?>">أضف تذكرة</a>
        <?php if($allTickets){foreach($allTickets as $ticket){ ?>
        <div class="col-lg-12 col-md-12 col-sm-12 float-right ticket">
            <h5><?php echo $ticket->title; ?></h5>
            <div class="col-lg-6 col-md-6 col-sm-12 text-center float-right tickets-data">
                <p>سعر التذكرة</p>
                <p><?php echo $ticket->price; ?> SR</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 text-center float-right tickets-data">
                <p>عدد التذاكر</p>
                <p><?php echo $ticket->num; ?></p>
            </div>
            <?php if($this->uri->segment(1) == 'users' && $this->session->userdata('id') == $user[0]->id){ ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right edit"><a href="<?php echo base_url().'users/edit/tickets/'.$ticket->id.'/ticket/'.$this->uri->segment(4); ?>"><span class="fa fa-cog"></span> تعديل</a></div>
                    <div class="col-lg-6 col-md-6 col-sm-12 px-0 py-0 float-right delete"><a href="<?php echo base_url().'users/delete/tickets/'.$ticket->id.'/?m=users/edit/items/'.$this->uri->segment(4).'/event/'; ?>"><span class="fa fa-trash"></span> حذف</a></div>
                    <?php } ?>
        </div>
        <?php }} ?>
    </div> 
        <?php
        } ?>
    <div class="col-lg-8 col-md-8 col-sm-12 s-pro<?php if(isset($floatC)){echo $floatC;}else{echo ' register';} ?>">
        <?php if($this->uri->segment(2) == 'addPromo' OR $this->uri->segment(2) == 'addPromoCheck'){ ?>
        <div class="col-lg-12 col-md-12 col-sm-12 i-line">
            <div class="col-lg-6 col-md-6 col-sm-12 if-line">
                <span class="fa fa-caret-left"></span>
                <h4>إضافة العرض</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 is-line">
                <span class="fa fa-caret-left"></span>
                <h4>إضافة تذاكر العرض</h4>
            </div>
        </div>
        <?php } ?>
        <div class="col-lg-12 col-md-12 col-sm-12 s-pro">
            <div class="col-lg-12 col-md-12 col-sm-12 s_block">
                <?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){ ?>
                <h4 class="pt-10">تعديل</h4>
                <?php }else{ ?>
                <h4 class="pt-10">إضافة عرض</h4>
                <?php } ?>
                <?php 
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                        $mCheck = 'editCheck/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5);
                    }else{
                        $mCheck = 'addPromoCheck';
                    }
                    echo form_open_multipart(base_url().'users/'.$mCheck.'/'.$this->uri->segment(3),$atrr2);

                    echo validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">',
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>');
                    if(isset($error) && $error !== ''){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$error.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }elseif($this->uri->segment(4) == 'done'){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم إضافة العرض وسيتم إعلامك عند قبولها.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }elseif($this->uri->segment(6) == 'done'){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم تعديل العرض بنجاح.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                ?>

                <p class="a_rules text-center">يجب إدخال الحقول التي تحتوي على <code>*</code>.</p>
                <label class="float-right mb-0">اسم العرض <code>*</code></label>

                <?php
                if(isset($pageId)){echo form_input($pageId);}
                        $title = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'title',
                            'placeholder'=>'اسم العرض'
                        );
                if($this->uri->segment(2) == 'addPromoCheck' && isset($p_title)){
                    $title['value'] = $p_title;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $title['value'] = $item[0]->title;
                }
                                echo form_input($title);
?>
                <p class="a_rules">أدخل عنواناً واضحاً باللغة العربية يصف العرض التي تريد أن تضيفها. لا تدخل رموزاً أو كلمات مثل "حصرياً"، "لأول مرة"، "لفترة محدود".. الخ.</p>


                <label class="float-right mb-0">وصف العرض <code>*</code></label>
                <?php
                        $content = array(
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'content',
                            'placeholder'=>'اكتب هنا وصف كامل مع كل تفاصيل العرض.'
                        );
                if($this->uri->segment(2) == 'addPromoCheck' && isset($p_content)){
                    $content['value'] = $p_content;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $content['value'] = $item[0]->content;
                }
                                echo form_textarea($content);
?>
                <p class="a_rules">أدخل وصف الفعالية بدقة يتضمن جميع المعلومات والشروط.</p>

                <label class="float-right mb-0">اختر تصنيف العرض الأساسي<code>*</code></label>
                <select class="float-right" id="mtag" name="mtag">
                    <option value="0">-- غير مُصنف --</option>
                    <?php if($mtags){foreach($mtags as $mtag){ ?>
                    <option value="<?php echo $mtag->id; ?>"><?php echo $mtag->tag; ?></option>
                    <?php }} ?>
                </select>
                <div id="parent">
                <?php if($msubtag){foreach($msubtag as $k_mtag => $a_stag){ ?>
                    <div class="s-tags" id="<?php echo $k_mtag; ?>">
                        <label class="float-right mb-0">اختر تصنيف العرض الفرعي<code>*</code></label>
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
                    <label class="float-right mb-0">اختر صور العرض <code>*</code></label>
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

                    <label class="float-right mb-0">بداية العرض <code>*</code></label>
                <?php
                        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            $s_date = explode(' ',$item[0]->s_date);
                            $itemSdate = $s_date[0];
                            $itemHdate = explode(':',$s_date[1])[0];
                            $itemMdate = explode(':',$s_date[1])[1];
                            $e_date = explode(' ',$item[0]->e_date);
                            $itemEdate = $s_date[0];
                            $itemEHdate = explode(':',$e_date[1])[0];
                            $itemEMdate = explode(':',$e_date[1])[1];
                        }
                    ?>
                        <div class="form-group from">
                            <input class="col-lg-12 col-md-12 col-sm-12 date" id="datepicker" type="text" name="from" placeholder="التاريخ" value="<?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                                echo $itemSdate;
                            } ?>">
                            <?php
                                $fmin = array(
                                            'type'=>'number',
                                            'min' => '0',
                                            'max' => '60',
                                            'autocomplete'=>'off',
                                            'placeholder'=>'الدقيقة',
                                            'class'=>'col-lg-4 col-md-4 col-sm-4 fhours text-right float-right',
                                            'name'=>'fmin'
                                        );
                            if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                                $fmin['value'] = $itemMdate;
                            }
                                echo form_input($fmin);
                        ?>
                            <?php
                                $fhours = array(
                                            'type'=>'number',
                                            'min' => '0',
                                            'max' => '12',
                                            'autocomplete'=>'off',
                                            'placeholder'=>'الساعة',
                                            'class'=>'col-lg-4 col-md-4 col-sm-4 fhours text-right float-right',
                                            'name'=>'fhours'
                                        );
                            if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                                $fhours['value'] = $itemHdate;
                            }
                                echo form_input($fhours);
                        ?>
                        <select class="col-lg-4 col-md-4 col-sm-4 float-right" name="fm">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                        </div>
                        <p class="a_rules">تاريخ وساعة البداية.</p>
                    
                    <label class="float-right mb-0">انتهاء العرض <code>*</code></label>
                        <div class="form-group from">
                            <input class="col-lg-12 col-md-12 col-sm-12 date" id="datepicker2" type="text" name="to" placeholder="التاريخ" value="<?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                                echo $itemEdate;
                            } ?>">
                            <?php
                                $tmin = array(
                                            'type'=>'number',
                                            'min' => '0',
                                            'max' => '60',
                                            'autocomplete'=>'off',
                                            'placeholder'=>'الدقيقة',
                                            'class'=>'col-lg-4 col-md-4 col-sm-4 fhours text-right float-right',
                                            'name'=>'tmin'
                                        );
                            if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                                $tmin['value'] = $itemEMdate;
                            }
                                echo form_input($tmin);
                        ?>
                            <?php
                                $thours = array(
                                            'type'=>'number',
                                            'min' => '0',
                                            'max' => '12',
                                            'autocomplete'=>'off',
                                            'placeholder'=>'الساعة',
                                            'class'=>'col-lg-4 col-md-4 col-sm-4 fhours text-right float-right',
                                            'name'=>'thours'
                                        );
                            if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                                $thours['value'] = $itemEHdate;
                            }
                                echo form_input($thours);
                        ?>
                        <select class="col-lg-4 col-md-4 col-sm-4 float-right" name="tm">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                        </div>
                        <p class="a_rules">تاريخ وساعة انهاء العرض.</p>

                        <label class="float-right mb-0">كلمات مفتاحية <code>*</code></label>

                        <?php
                        $tags = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'tags'
                        );
        if($this->uri->segment(2) == 'addPromoCheck' && isset($p_tags)){
                    $tags['value'] = $p_tags;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $tags['value'] = $item[0]->tags;
                }
                                echo form_input($tags);
?>
                        <p class="a_rules">مثال: حفلة, مؤتمر...</p>
                <label class="float-right mb-0">العنوان بالتفصيل <code>*</code></label>

                        <?php
                        $g_location = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'placeholder'=>'العنوان بالتفصيل',
                            'class'=>'search_addr form-control text-right float-right',
                            'name'=>'g_location',
                            'id'=>'search_ByState'
                        );
        if($this->uri->segment(2) == 'addEventCheck' && isset($p_g_location)){
                    $g_location['value'] = $p_g_location;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $g_location['value'] = $item[0]->g_location;
                }
                                echo form_input($g_location);
?>
                <p class="a_rules">اختر العنوان من نتائج هذا الحقل أو يُمكنك الإختيار من الخريطة.</p>
                <!-- search input box -->
                <button class="search-map get_map" type="submit">
                    ابحث
                </button>
                <!-- display google map -->
                <div id="geomap"></div>

                <!-- display selected location information -->
                <input type="hidden" class="search_latitude" name="search_latitude" size="30" value="<?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    echo $item[0]->search_latitude;
                }?>">
                <input type="hidden" class="search_longitude" name="search_longitude" size="30" value="<?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    echo $item[0]->search_longitude;
                }?>">
                
                                <label class="float-right mb-0">المدينة <code>*</code></label>

                        <?php
                        $location = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'placeholder'=>'المدينة',
                            'class'=>'form-control text-right float-right',
                            'name'=>'location'
                        );
        if($this->uri->segment(2) == 'addEventCheck' && isset($p_location)){
                    $location['value'] = $p_location;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $location['value'] = $item[0]->location;
                }
                                echo form_input($location);
?>
                        <p class="a_rules">اكتب المدينة.</p>
                
    <?php
        if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){

        }else{
            ?>
                <?php
                    }
                ?>
                
                        <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                         if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                echo form_button($submit,'<span class="fa fa-cogs"></span> تعديل العرض');
                 }else{echo form_button($submit,'<span class="fa fa-plus"></span> أضف عرض');} 
?>

                        <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>


                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php $this->load->view('include/footer.php'); ?>
