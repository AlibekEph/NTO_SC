<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
if(!$user->is_auth){
	go_to_page(AUTH);
}
$title = "Личный кабинет";
include_once("header.php");
?>


<div ng-app="Cabinet" ng-controller="CabinetCtrl" class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Личный кабинет</h1>
          </div>
 
        </div>
      </div><!-- /.container-fluid -->
    </section>

  
            <!-- /.widget-user -->
             <div class="ml-3 card mr-3">
             <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">{{user.surname}} {{user.name}} {{user.patronymic}}</h3>
              </div>
              <div class="card-body">
                <label for="exampleInputBorder">ID: {{user.id}} </label>
                <br>
                <label for="exampleInputBorder">Адрес: {{user.adress}} </label>
                <br>
                <label for="exampleInputBorder">Баланс: {{user.balance}} </label>

              </div>
              <!-- /.card-body -->
            </div>
              <!-- /.card-body -->
            </div>

         <div class="ml-3 card mr-3">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Список ваших товаров</h3>

                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Фото</th>
                      <th>Название</th>
                      <th>Цена</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="item in items track by $index">
                      <td>{{item.id}}</td>
                      <td><img  src="sources/products/{{item.id}}/{{item.photo}}" class="img-circle elevation-2" alt="User Image" style="height: 36px;"></td>
                      <td>{{item.title}} </td>
                      <td>{{item.coast}}</td>
                      
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
              <!-- /.card-body -->
            </div>
  


  </div>

<?php
include_once("footer.php");

?>