<?php 
include($_SERVER['DOCUMENT_ROOT'] . "/functions.php");
if(!$user->is_auth ){
	go_to_page(AUTH);
}
$title = "Магазин";
include_once("header.php");
?>


<div ng-app="Shop" ng-controller="ShopCtrl" class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Товары</h1>
          </div>
 
        </div>
      </div><!-- /.container-fluid -->
    </section>

  
            <!-- /.widget-user -->
             <div class="ml-3 card mr-3">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Список товаров</h3>

                
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
                      <th>Действие</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="item in items track by $index">
                      <td>{{item.id}}</td>
                      <td><img  src="sources/products/{{item.id}}/{{item.photo}}" class="img-circle elevation-2" alt="User Image" style="height: 36px;"></td>
                      <td>{{item.title}} </td>
                      <td>{{item.coast}}</td>
                      <td>
                        <div class="col-4 text-center"><button ng-click="buy(item)" class="btn">Купить</button></div>
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
          <h4 class="modal-title">Вы успешно приобрели товар</h4>
          <button ng-click="close_success_buy()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  </div>


  <div class="modal" id="modal-info3" style="padding-right: 16px; display: block;width: 0;height: 0;" aria-modal="true" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title">У вас недостаточно денег на балансе</h4>
          <button ng-click="close_error_buy()" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  </div>

<?php
include_once("footer.php");

?>