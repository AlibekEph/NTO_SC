<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
if(!$user->is_auth){
	go_to_page(AUTH);
}
$title = "Главная";
include_once("header.php");
?>


<div ng-app="Index" ng-controller="IndexCtrl" class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Умная мусорка</h1>
          </div>
 
        </div>
      </div><!-- /.container-fluid -->
    </section>

  <div class="row">

    <div class="row ml-4 mr-3">
          <!-- /.col -->
             <div class="card card-success card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-square "></i>
                  Умная мусорка {{station.adress}}
                </h3>
              </div>
              <div class="card-body">
                <div class="row" style="align-items: center; justify-content: center;">
                  <a class="btn btn-app bg-info mr-1" style="height: 83px; min-width: 85px;">
                  <span class="badge bg-danger">{{station.paper.value}}%</span>
                  <i class="mt-2 fas fa-trash "></i> Бамага
                </a>
                  <a class="btn btn-app bg-success mr-1" style="height: 83px; min-width: 85px;">
                  <span class="badge bg-purple">{{station.glass.value}}%</span>
                  <i class="fas mt-2 fa-trash "></i> Стекло
                </a>
                  <a class="btn btn-app bg-warning mr-1" style="height: 83px; min-width: 85px;">
                  <span class="badge bg-info">{{station.plastic.value}}%</span>
                  <i class="fas mt-2 fa-trash "></i> Пластик
                </a>
              </div>
                              <div class="row" style="align-items: center; justify-content: center;">

                <div class="alert ml-1 alert-dismissible" ng-class="station.status_class()" style="width: 75%">
                  <h5><i class="icon fas " ng-class="station.status_icon_class()"></i> Статус</h5>
                  {{station.status.value}}
              </div>
            </div>
              </div>
              <!-- /.card -->
            </div>

   
         
    </div>
 <div class="col-md-6 ml-5 mt-2 mr-3">
            <!-- Widget: user widget style 1 -->
            <div class="card ml-4 card-widget widget-user shadow">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-success">
                <h3 class="widget-user-username"><?=$user->surname?> <?=$user->name?> <?=$user->patronymic?></h3>
                <h5 class="widget-user-desc"><?=$user->get_user_type()?></h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="./uploads/<?=$user->id?>/<?=$user->photo?>" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header"><?=$user->bonus?></h5>
                      <span class="description-text">Бонусы</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-8 ">
                    <div class="description-block">
                      <h5 class="description-header" style="font-size: 14px;"><?=$user->adress?></h5>
                      <span class="description-text">Адрес</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
                     </div>
          </div>

            <!-- /.widget-user -->
             <div class="ml-3 card mr-3">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Лог действий</h3>

                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>ФИО</th>
                      <th>Должность</th>
                      <th>Дата</th>
                      <th>Действие</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="log in logs track by $index">
                      <td>{{log.id}}</td>
                      <td>{{log.surname}} {{log.name}} {{log.patronymic}}</td>
                      <td>{{log.user_type}}</td>
                      <td>{{log.date}}</td>
                      <td>{{log.move}}</td>
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