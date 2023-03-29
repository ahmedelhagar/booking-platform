<?php $this->load->view('include/header.php'); ?>
<div class="container-fluid allUsers">
    <br />
    
    <div class="col-lg-8 col-md-8 col-sm-12 s-pro register">
        <div class="col-lg-12 col-md-12 col-sm-12 i-line2">
            <div class="col-lg-6 col-md-6 col-sm-12 is-line2">
                <span class="fa fa-caret-left"></span>
                <h4>إضافة الفعالية</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 if-line2">
                <span class="fa fa-caret-left"></span>
                <h4>إضافة تذاكر الفعالية</h4>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 t-item">
            <img src="<?php echo base_url().'vendor/uploads/images/'.$this->main_model->vthumb($item2['image']); ?>">
            <h6><?php echo $item2['title']; ?></h6>
            <div class="t-content">
                <?php echo substr(strip_tags($item2['content']),0,350).'...'; ?>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 s-pro">
            <div class="col-lg-12 col-md-12 col-sm-12 s_block">
                <?php if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){ ?>
                <h4 class="pt-10">تعديل</h4>
                <?php }else{ ?>
                <h4 class="pt-10">إضافة تذكرة</h4>
                <?php } ?>
                <?php 
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                    if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                        $mCheck = 'editCheck/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6);
                    }else{
                        $mCheck = 'addTicketCheck/'.$this->uri->segment(3);
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
                    }elseif($this->uri->segment(4) == 'done'){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم إضافة التذكرة للفعالية.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }elseif($this->uri->segment(6) == 'done'){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم تعديل التذكرة بنجاح.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';}
                ?>

                <p class="a_rules text-center">يجب إدخال الحقول التي تحتوي على <code>*</code>.</p>
                <label class="float-right mb-0">اسم التذكرة <code>*</code></label>

                <?php
                        $title = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'title',
                            'placeholder'=>'اسم التذكرة'
                        );
                if($this->uri->segment(2) == 'addTicketCheck' && isset($p_title)){
                    $title['value'] = $p_title;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $title['value'] = $item[0]->title;
                }
                                echo form_input($title);
?>
                <p class="a_rules">أدخل عنواناً واضحاً باللغة العربية يصف التذكرة التي تريد أن تضيفها. لا تدخل رموزاً أو كلمات مثل "حصرياً"، "لأول مرة"، "لفترة محدود".. الخ.</p>
                
                <label class="float-right mb-0">سعر التذكرة بالريال السعودي<code>*</code></label>

                <?php
                        $price = array(
                            'type'=>'number',
                            'min'=>'0',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'price',
                            'placeholder'=>'سعر التذكرة'
                        );
                if($this->uri->segment(2) == 'addTicketCheck' && isset($p_price)){
                    $price['value'] = $p_price;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $price['value'] = $item[0]->price;
                }
                                echo form_input($price);
?>
                <p class="a_rules">أدخل سعر التذكرة بالريال السعودي</p>
                
                <label class="float-right mb-0">عدد التذاكر المتاحة <code>*</code></label>

                <?php
                        $num = array(
                            'type'=>'number',
                            'min'=>'1',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'num',
                            'placeholder'=>'عدد التذاكر المتاحة'
                        );
                if($this->uri->segment(2) == 'addTicketCheck' && isset($p_num)){
                    $num['value'] = $p_num;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $num['value'] = $item[0]->num;
                }
                                echo form_input($num);
?>
                <p class="a_rules">أدخل عدد التذاكر المتاحة</p>
                
            <label class="float-right mb-0">قيمة التخفيض <code>غير ضروري</code></label>

                <?php
                        $discount = array(
                            'type'=>'number',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'discount',
                            'placeholder'=>'قيمة التخفيض'
                        );
                if($this->uri->segment(2) == 'addTicketCheck' && isset($p_discount)){
                    $discount['value'] = $p_discount;
                }
                if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                    $discount['value'] = $item[0]->discount;
                }
                                echo form_input($discount);
?>
                <p class="a_rules">أدخل قيمة التخفيض بالريال السعودي</p>
                

                        <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                           if($this->uri->segment(2) == 'edit' OR $this->uri->segment(2) == 'editCheck'){
                            echo form_button($submit,'<span class="fa fa-cogs"></span> تعديل التذكرة');
                         }else{echo form_button($submit,'<span class="fa fa-plus"></span> أضف تذكرة');};
?>

                        <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>


                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php $this->load->view('include/footer.php'); ?>
