<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
if(!$user->is_auth || !is_admin()){
	go_to_page(AUTH);
}
$title = "Управление";
include_once("header.php");
?>


<div ng-app="Control" ng-controller="ControlCtrl" class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Упарвление</h1>
          </div>
 
        </div>
      </div><!-- /.container-fluid -->
    </section>
      <div ng-if="station.vandal.value == '1'" class="ml-3 mr-3 alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-users"></i> Опасность!</h5>
           Внимание! Кто-то тресет урны.
        </div>
          <div ng-if="station.tempInt > 26.0 " class="ml-3 mr-3 alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-fire"></i> Опасность!</h5>
           Внимание! Возможен пожар.
        </div>
            <!-- /.widget-user -->
             <div class="ml-3 card mr-3">
             <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Умная мусорка {{station.adress}}</h3>
              </div>
              <div class="card-body">
                <label for="exampleInputBorder">Текущий статус: {{station.status.value}} <code class="ml-3">обновлено {{station.status.date}}</code></label>
                <br>
                <label for="exampleInputBorder">Текущая температура: {{station.temp.value}} <code class="ml-3">обновлено {{station.temp.date}}</code></label>
                <br>
                <label for="exampleInputBorder">Отсек 1: {{station.otsek1.value}} <code class="ml-3">обновлено {{station.otsek1.date}}</code></label>
                <br>
                <label for="exampleInputBorder">Отсек 2: {{station.otsek2.value}} <code class="ml-3">обновлено {{station.otsek2.date}}</code></label>
                <br>
                <label for="exampleInputBorder">Отсек 3: {{station.otsek3.value}} <code class="ml-3">обновлено {{station.otsek3.date}}</code></label>
                <br>
                <label for="exampleInputBorder">Вода: {{station.voda.value}} <code class="ml-3">обновлено {{station.voda.date}}</code></label>
                <br>
                <label for="exampleInputBorder">Дисплей: {{station.display.value}} <code class="ml-3">обновлено {{station.display.date}}</code></label>
                <div class="form-group">
                        <label>Статус</label>
                        <select ng-model="station.status.value" ng-change="station.change_status()" class="form-control">
                          <option value="Работает">Работает</option>
                          <option value="На тех обслуживании">На тех обслуживании</option>
                          <option value="Временно не работает">Временно не работает</option>
                        </select>
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
              <!-- /.card-body -->
            </div>

          <div class="ml-3 card mr-3">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Диагностики</h3>

                
              </div>
              <!-- /.card-header -->
              <div ng-repeat="dignostic in diagnostics" class="card-body table-responsive p-0 mt-3" style="
              border-radius: 0.25rem;
              height: 250px;
              margin: auto;
              width: 95%;
              box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
              border: #28a745 solid 2px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Параметр</th>
                      <th>ID</th>
                      <th>Стекло</th>
                      <th>Бумага</th>
                      <th>Пластик</th>
                      <th>Дата</th>
                      <th>ФИО сотрудника</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td>{{dignostic.id}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>{{dignostic.date}}</td>
                      <td>{{dignostic.surname}} {{dignostic.name}} {{dignostic.patronymic}}</td>
                    </tr>
                    <tr ng-repeat="param in dignostic.params">
                      <td>{{param.name}}</td>
                      <td></td>
                      <td><i class="fa " ng-class="dignostic.content.glass[param.value] == '1' ? 'fa-plus-circle' : 'fa-minus-circle'" aria-hidden="true"></i></td>
                      <td><i class="fa " ng-class="dignostic.content.paper[param.value] == '1' ? 'fa-plus-circle' : 'fa-minus-circle'" aria-hidden="true"></i></td>
                      <td><i class="fa " ng-class="dignostic.content.plastic[param.value] == '1' ? 'fa-plus-circle' : 'fa-minus-circle'" aria-hidden="true"></i></td>
                      <td></td>
                      <td></td>
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