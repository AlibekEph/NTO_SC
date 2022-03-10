<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
if(!$user->is_auth || !is_admin()){
	go_to_page(AUTH);
}
$title = "Пользователи";
include_once("header.php");
?>


<div ng-app="Users" ng-controller="UsersCtrl" class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Пользователи</h1>
          </div>
 
        </div>
      </div><!-- /.container-fluid -->
    </section>

  
            <!-- /.widget-user -->
             <div class="ml-3 card mr-3">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Список пользователей</h3>

                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Фото</th>
                      <th>ФИО</th>
                      <th>Должность</th>
                      <th>Адрес</th>
                      <th>Баланс</th>
                      <th>Действие</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="user in users track by $index">
                      <td>{{user.id}}</td>
                      <td><img  src="uploads/{{user.id}}/{{user.photo}}" class="img-circle elevation-2" alt="User Image" style="height: 36px;"></td>
                      <td>{{user.surname}} {{user.name}} {{user.patronymic}}</td>
                      <td>{{user.user_type}}</td>
                      <td>{{user.adress}}</td>
                      <td>{{user.balance}}</td>
                      <td>
                        <div class="col-4 text-center"><button ng-click="open_minus_balance(user)" class="btn"><i class="fas fa-minus-circle"></i></button></div>
</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
              <!-- /.card-body -->
            </div>


  <div class="modal" id="modal-info2" style="padding-right: 16px; display: block;width: 0;height: 0;" aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title">Списать бонусы</h4>
          <button ng-click="close_minus_balance()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div >
          <input ng-model="minus_count" type="text" class="form-control">
          <button ng-click="write_off_bonus()" class="btn btn-block btn-lg btn-success mt-4" type="button">Списать</button>
        </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  </div>

<?php
include_once("footer.php");

?>