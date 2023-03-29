<div class="container-fluid allUsers">
    <div class="col-lg-6 col-md-6 col-sm-12 float-right statics">
                <?php 
                        $allpri = 0;
                        $alltcks = 0;
                        $byadmin = 0;
                        $allorders = 0;
                        $allsold = 0;
                        $items = $this->main_model->getAllData('items');
                        if($items){
                        foreach($items as $item){
                            $i_tickets = (array) $this->main_model->getByData('p_tickets','i_id',$item->id);
                            foreach($i_tickets as $i_tick){
                                if(isset($i_tick->price)){
                                    $allpri += $i_tick->price*$i_tick->num;
                                    $alltcks += $i_tick->num;
                                    $allorders += 1;
                                    if($i_tick->admin == 1){
                                        $byadmin += $i_tick->num;
                                    }
                                    if($i_tick->state == 1){
                                        $allsold += 1;
                                    }
                                }
                            }
                        }} ?>
                <div class="col-lg-12 col-md-12 col-sm-12 stats">
                    <h3>SR <?php echo $allpri; ?></h3>
                    <p>إجمالي قيمة كل الطلبات</p>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 stats">
                    <h3><?php echo $alltcks; ?></h3>
                    <p>إجمالي عدد التذاكر المطلوبة</p>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 stats">
                    <h3><?php echo $byadmin; ?></h3>
                    <p>إجمالي عدد التذاكر المُباعة عن طريق الإدارة</p>
                </div>
                
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 float-right statics">
        <?php $usersnum = $this->main_model->getAllData('users','count');if(!$usersnum){$usersnum=0;} ?>
        <div class="col-lg-12 col-md-12 col-sm-12 stats">
                    <h3><?php echo $usersnum; ?></h3>
                    <p>عدد أعضاء الموقع</p>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 stats">
                    <h3><?php echo $allorders; ?></h3>
                    <p>إجمالي عدد الطلبيات</p>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 stats">
            <h3><?php echo $allsold; ?></h3>
            <p>إجمالي عدد الطلبيات المباعة</p>
        </div>
    </div>
</div>