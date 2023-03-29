<div class="container allUsers">
<?php echo $error;?>

<?php echo form_open_multipart('users/do_upload');?>

<?php
                        $p_img1 = array(
                            'type'=>'file',
                            'class'=>'form-control',
                            'name'=>'userfile',
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

<br /><br />

<input type="submit" class="btn btn-success" value="إرسال" />

</form>
</div>