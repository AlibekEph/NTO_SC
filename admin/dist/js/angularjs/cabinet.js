var cabinet = angular.module('Cabinet', []);
cabinet.controller('CabinetCtrl', function($scope, $http) {
	class User{
		name='';
		surname='';
		patronymic='';
		balance='';
		adress=''
		id='';

		constructor(id,name,surname,patronymic,adress,balance){
			this.id = id;
			this.name=name;
			this.surname=surname;
			this.patronymic=patronymic;
			this.adress=adress;
			this.balance=balance;

		}
	}

	class Item{
		title='';
		photo='';
		coast='';
		id='';
		constructor(id, title,photo,coast){
			this.id = id;
			this.coast = coast;
			this.photo = photo;
			this.title = title;
		}
	}

	$scope.user = new User('','','','','','');
	$scope.items = [];


	$scope.update = function(){
		$http.get('api/cabinet.php?move=1').then(function success(result){
			let data = result.data;
			let user = data['user_data'];
			let products = data['products'];
			$scope.items = [];
			$scope.user = new User(user.id, user.name, user.surname, user.patronymic, user.adress, user.balance);
			for (var i = products.length - 1; i >= 0; i--) {
				$scope.items.push(new Item(products[i]['id'], products[i]['title'], products[i]['photo'], products[i]['coast']));
			}

		});
	}
	$scope.update();

});