<div class="container-fluid allUsers">
    <h3>كل الأعضاء</h3>
    <form action="<?php echo base_url().'wjhatnacadmin/userSearch'; ?>" method="get" class="users-search">
      <input name="search_user" type="text" placeholder="اكتب اسم المستخدم">
      <input class="bt btn-success" type="submit" value="بحث">
    </form>
    <div class="container-fluid float-right">
                <br/>
                <a href="<?php echo base_url().'users/sells/all'; ?>" type="button" class="btn btn-primary">
                  مبيعات ومشتريات كل الأعضاء
                </a><br/><br/><a href="<?php echo base_url().'wjhatnacadmin/allUsers'; ?>" type="button" class="btn btn-primary">
                  كل الأعضاء
                </a></div>
    <?php foreach($records as $user){
    $creds = explode(',',$user->cred);
    ?>
    <div class="col-lg-3 col-md-3 col-sm-12 float-right user-cpad">
        <div class="col-lg-12 col-md-12 col-sm-12 float-right user-card">
            <a href="<?php echo base_url().'user/'.$user->username; ?>"><img src="<?php if($user->picture !== '' && $user->oauth_provider == 'facebook'){echo $user->picture;}elseif($user->picture == ''){echo base_url().'vendor/images/user.png';}else{echo base_url().'vendor/uploads/images/'.$user->picture;}; ?>"></a>
            <div class="user-ctitle">
                <a href="<?php echo base_url().'user/'.$user->username; ?>"><?php echo $user->username; ?></a>
                <span class="user-cemail"><?php echo $user->email; ?></span>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 float-right user-credentials">
                <a href="<?php echo base_url().'wjhatnacadmin/creds/'.$user->id.'/0'; ?>">
                    <div class="col-lg-12 col-md-12 col-sm-12 float-right user-type<?php
                if($user->cred == NULL OR $user->cred == 'events,tickets,pages' OR $user->cred == 'events,tickets,pages,bank' OR $user->cred == 'events,tickets,pages,promos' OR $user->cred == 'events,tickets,pages,promos,bank'){
                    echo ' available-type';
                }
            ?>">
                        عادي
                    </div>
                </a>
                <a href="<?php echo base_url().'wjhatnacadmin/creds/'.$user->id.'/1'; ?>">
                    <div class="col-lg-12 col-md-12 col-sm-12 float-right user-type<?php
            if($user->cred == NULL && $user->type == 1){
                    echo ' alerts-border';
                }elseif($user->cred == NULL && $user->type == 2){
                    echo ' alerts-border';
                }
             if($user->cred == 'events,tickets,pages' OR $user->cred == 'events,tickets,pages,promos' OR $user->cred == 'events,tickets,pages,bank' OR $user->cred == 'events,tickets,pages,promos,bank'){
                    echo ' available-type';
                }
            ?>">
                        منظم فعاليات
                    </div>
                </a>
                <a href="<?php echo base_url().'wjhatnacadmin/creds/'.$user->id.'/2'; ?>">
                    <div class="col-lg-12 col-md-12 col-sm-12 float-right user-type<?php
            if($user->cred == NULL && $user->type == 2){
                    echo ' alerts-border';
                }elseif($user->cred == 'events,tickets,pages' && $user->type == 2){
                    echo ' alerts-border';
                }
             if($user->cred == 'events,tickets,pages,promos' OR $user->cred == 'events,tickets,pages,promos,bank'){
                    echo ' available-type';
                }
            ?>">
                        صاحب عروض تجارية
                    </div>
                </a>
                <a href="<?php echo base_url().'wjhatnacadmin/creds/'.$user->id.'/3'; ?>">
                    <div class="col-lg-12 col-md-12 col-sm-12 float-right user-type<?php
            if($user->rcred == 'bank'){
                    echo ' alerts-border';
                }
             if(in_array('bank',$creds)){
                    echo ' available-type';
                }
            ?>">
                        التحصيل لنفسي
                    </div>
                </a>
                <a class="del-link" href="<?php echo base_url().'wjhatnacadmin/delete/users/'.$user->id.'/?m=wjhatnacadmin/allUsers'; ?>"><span class="fa fa-trash"></span> حذف</a>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $user->id; ?>">
                  بيانات العضو
                </button>
                <!-- Button trigger modal -->
                <div class="container-fluid float-right">
                <br/>
                <a href="<?php echo base_url().'users/sells/'.$user->id; ?>" type="button" class="btn btn-primary">
                  مبيعاته ومشترياته
                </a></div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal<?php echo $user->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <h5>رقم العضو : <?php echo $user->id; ?></h5>
                        <h5>اسم المستخدم : <?php echo $user->username; ?></h5>
                        <h5>الاسم الأول : <?php echo $user->first_name; ?></h5>
                        <h5>الاسم الأخير : <?php echo $user->last_name; ?></h5>
                        <h5>البريد : <?php echo $user->email; ?></h5>
                         <?php $country = (array) $this->main_model->getByData('countries','code',$user->country)[0]; ?>
                        <h5>الهاتف : <?php echo $country['tel'].$user->mobile.'+'; ?></h5>
                        <h5>العنوان : <?php echo $user->address; ?></h5>
                        <h5>اسم المنشأة : <?php echo $user->c_name; ?></h5>
                          <?php if($user->img1){ ?>
                          <h5>صورة الرخصة : <a target="_blank" href="<?php echo base_url().'vendor/uploads/images/'.$user->img1; ?>">هنا</a></h5>
                          <?php } ?>
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- Pagination -->
      <ul class="pagination justify-content-center pager"><?php echo $links; ?></ul>
</div>