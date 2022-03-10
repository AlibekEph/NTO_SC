var control = angular.module('Control', []);
control.controller('ControlCtrl',  function($scope, $http){
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
		change_status(){
			$http.get('api/settings.php?move=2&station_id=1&status='+this.status.value).then(function success(result){console.log(result)});
			$scope.update();
		}
	}

	class Diagnostic{
		content={};
		id='';
		name='';
		surname='';
		patronymic='';
		date='';
		params = [
		{'name': 'Цветоопределяемость', 'value': 'color'},
		{'name': 'Заслонка', 'value' : 'zaslonka'},
		{'name' : 'Заполняемость', 'value': 'zapolnyaem'}];

		constructor(content,id,name,surname,patronymic,date){
			this.id = id;
			this.name=name;
			this.surname = surname;
			this.patronymic = patronymic;
			this.date = date;
			this.content = content;
			console.log(content);
		}

	}

	$scope.station = new Station(0,0,0,'');
	$scope.diagnostics = [];

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

			$http.get('api/settings.php?move=3').then(function success(result){
				let data = result.data;
				for (var i = 0; i < data.length; i++) {
					$scope.diagnostics.push(new Diagnostic(data[i].content, data[i].id, data[i].name, data[i].surname, data[i].patronymic, data[i].date));
				}
			});

	}


	$scope.update();
});