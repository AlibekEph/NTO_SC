var users = angular.module('Users', []);
users.controller('UsersCtrl',  function($scope, $http){
		class User{
			surname='';
			name='';
			patronymic='';
			adress='';
			photo='';
			user_type='';
			id='';
			balance='';
			constructor(id, surname, name,patronymic,balance,adress, user_type, photo){
				this.name = name;
				this.surname = surname;
				this.patronymic= patronymic;
				this.adress = adress;
				this.balance=balance;
				this.id = id;
				this.photo = photo;
				this.user_type = user_type;
			}

			minus_bonus(count){
				$http.get('api/bot/objects/user.php?move=3&user_id='+this.id+"&minus_count="+count);
				this.balance = parseInt(this.balance) - parseInt(count);

			}
		}
	$scope.users = [];
	$scope.minus_user='';
	$scope.minus_count = '0';
	$scope.open_minus_balance = function(user){
		$scope.minus_user = user;
		let modal = document.querySelector("#modal-info2");
		modal.classList.add("show");
        modal.style.width = 100 + "%";
        modal.style.height = 100 + "%";
	}

	$scope.close_minus_balance = function(){
			 let modal = document.querySelector("#modal-info2")
    modal.classList.remove("show")
    modal.style.width = 0
    modal.style.height = 0	
	}

	$scope.write_off_bonus = function(){
		if(parseInt($scope.minus_count) <= 0 ){
			return false;
		}
		$scope.minus_user.minus_bonus($scope.minus_count);
		$scope.close_minus_balance();
	}

$scope.update = function(){
	$http.get('api/admin_api.php?move=2').then(function success(result){
		let data = result.data;
		$scope.users = [];
		for (var i = data.length - 1; i >= 0; i--) {
			$scope.users.push(new User(data[i].id, data[i].surname, data[i].name, data[i].patronymic, data[i].balance, data[i].adress, data[i].user_type, data[i].photo));
		}
	});
}
$scope.update();
	let timerId = setInterval(() => $scope.update(), 5000);


});