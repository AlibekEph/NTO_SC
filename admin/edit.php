<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
if(!$user->is_auth || $user->root_type != '1'){
	go_to_page(AUTH);
}
$station = new Station();
include_once("header.php");
?>
  <div ng-app="Edit" ng-controller="EditCtrl" class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Панель управления</h1>
          </div>
 
        </div>
      </div><!-- /.container-fluid -->
    </section>


  	 <div class="row ml-3">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Установка температуры</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Температура</label>
                    <input type="text" class="form-control" value="<?=$station->settings[SETTINGS_TEMP['id']]['content']?>" placeholder="36.6">
                  </div>
                 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" class="btn btn-primary">Сохранить</button>
                </div>
              </form>
            </div>
          </div>
        </div>
 

       <div class="card ml-3 mr-3">
              <div class="card-header">
                <h3 class="card-title">Пользователи</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Имя</th>
                    <th>Уровень прав</th>
                    <th>Логин</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                     <?php 
                    foreach (get_users() as $log) {
                    ?>
                  <tr>
                    <td><?=$log['name']?></td>
                    <td><?=$log['root_type'] == '1' ? 'Администратор' : 'Пользователь'?></td>
                    <td><?=$log['login']?></td>
                    
                  </tr>
                  <?php 

}
                  ?>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

             

      </div>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
     $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>

<?php
include_once("footer.php");

?>