var index = angular.module('Index',[]);
index.controller('IndexCtrl',  function($scope, $http){
	class Station{
		paper=0;
		plastic=0;
		glass=0;
		status='';
		adress='';
		is_connected=false;
		constructor(paper, plastic, glass,status,is_connected=false){
			this.paper = paper;
			this.plastic=plastic;
			this.glass = glass;
			this.status = status;
			this.is_connected=false;
		}
		set_data(paper, plastic, glass,status,is_connected=false){
			this.paper = paper;
			this.plastic=plastic;
			this.glass = glass;
			this.status = status;
			this.is_connected=false;
		}
		set_adress(adress){
			this.adress=adress
		}
		status_class(){
			if(this.status.value.includes('Работает')){
				return 'alert-success';
			}
			if(this.status.value.includes('На тех обслуживании')){
				return 'alert-warning';
			}
			if(this.status.value.includes('Временно не работает')){
				return 'alert-danger';
			}

		}
		status_icon_class(){
			if(this.status.value.includes('Работает')){
				return 'fa-check';
			}
			if(this.status.value.includes('На тех обслуживании')){
				return 'fa-clock';
			}
			if(this.status.value.includes('Временно не работает')){
				return 'fa-minus-circle';
			}

		}
	}
		$scope.station = new Station(0,0,0,'');
		$scope.logs = [];

	$scope.update = function(){

			$http.get('api/settings.php?move=1&station_id=1').then(function success(result){
				console.log(result);
				let data = result.data[0];
				let adress = result.data[1];
				if($scope.station.is_connected){
					$scope.station.set_data(data['1'],data['2'],data['3'],data['4'],true);
				}else{
					$scope.station = new Station(data['1'],data['2'],data['3'],data['4'],true);
					$scope.station.set_adress(adress);
				}
			});

			$http.get('api/admin_api.php?move=1').then(function success(result){
				let data = result.data;
				$scope.logs = data;
			});
	}


	$scope.update();
	let timerId = setInterval(() => $scope.update(), 5000);

});