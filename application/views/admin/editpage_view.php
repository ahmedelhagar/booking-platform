<div class="container-fluid text-center float-right" style="background:#fff;">
    <script src="<?php echo base_url().'vendor/js/ckeditor.js'; ?>"></script>
    <h3 class="text-center">تعديل</h3>
<?php 
                    $atrr2 = array(
                        'class' => 'col-lg-12 col-md-12 col-sm-12 float-right f-box',
                        'method' => 'post'
                    );
                        $mCheck = 'editPageCheck/'.$this->uri->segment(3);
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
                    }elseif($this->uri->segment(4) == 'done'){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم التعديل بنجاح.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
                    }
                ?>

                <p class="a_rules text-center">يجب إدخال الحقول التي تحتوي على <code>*</code>.</p>
                <label class="float-right mb-0">العنوان <code>*</code></label>

                <?php
                        $title = array(
                            'type'=>'text',
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'title',
                            'placeholder'=>'العنوان',
                            'value'=>$page[0]->title
                        );
                                echo form_input($title);
?>
                
                <label class="float-right mb-0">المحتوى<code>*</code></label>
<?php
                        $content = array(
                            'autocomplete'=>'off',
                            'class'=>'form-control text-right float-right',
                            'name'=>'content',
                            'placeholder'=>'اكتب هنا وصف كامل مع كل تفاصيل الفعالية.'
                        );
                                echo form_textarea($content,$page[0]->content);
?>
    <br />
                        <?php
                        $submit = array(
                            'type'=>'submit',
                            'autocomplete'=>'off',
                            'class'=>'regbtn a_Gigbtn',
                            'name'=>'submit'
                        );
                           echo form_button($submit,'<span class="fa fa-save"></span> حفظ');
?>

                        <p><img class="f-loader" src="<?php echo base_url(); ?>vendor/images/loader.gif" /></p>


                        <?php echo form_close(); ?>
</div>
<script>
        CKEDITOR.replace('content', {
            extraPlugins: 'bidi',
            // Setting default language direction to right-to-left.
            contentsLangDirection: 'rtl',
            height: 400,
        });

    </script>