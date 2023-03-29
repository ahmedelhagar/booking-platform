<div class="container-fluid allUsers">

<table class="table table-striped">
  <thead>
  <h3 class="text-center">جدول مبيعات/مشتريات <?php
  if($this->main_model->is_admin_logged_in() && $this->uri->segment(3) == 'all'){
}else{
  $userDa = $this->main_model->getByData('users','id',$this->uri->segment(3));
  echo $userDa[0]->first_name.' '.$userDa[0]->last_name;
}
  ?></h3>
    <tr>
      <th scope="col">TW - XXXX</th>
      <th scope="col">البائع</th>
      <th scope="col">المشتري</th>
      <th scope="col">عدد التذاكر</th>
      <th scope="col">الفعالية / العرض الترويجي</th>
      <th scope="col">الحالة</th>
      <th scope="col">التوقيت</th>
    </tr>
  </thead>
  <tbody>
  <?php if($records){foreach($records as $record){
      $seller = $this->main_model->getByData('users','id',$record->s_id);
      $buyerd = $this->main_model->getByData('users','id',$record->u_id);
      $itemd = $this->main_model->getByData('items','id',$record->i_id);
      ?>
    <tr>
      <th scope="row">TW - <?php echo $record->id; ?></th>
      <td><?php echo $seller[0]->first_name.' '.$seller[0]->last_name; ?></td>
      <td><?php echo $buyerd[0]->first_name.' '.$buyerd[0]->last_name; ?></td>
      <td><?php echo $record->num; ?></td>
      <td><a href="<?php
                echo base_url().'i/'.str_replace(' ','-',$itemd[0]->title).'/'.$itemd[0]->id.'/';
                ?>"><?php echo $itemd[0]->title; ?></a></td>
      <td><?php if($record->state){echo 'تم التحصيل';}else{echo 'لم يتم التحصيل';} ?></td>
      <td><?php echo $record->date; ?></td>
    </tr>
    <?php }}else{
        echo '<h3 class="text-center">لايوجد مبيعات/مشتريات</h3>';
    } ?>
  </tbody>
</table>
    <!-- Pagination -->
    <ul class="pagination justify-content-center pager"><?php echo $links; ?></ul>
</div>