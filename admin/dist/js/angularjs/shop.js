var shop = angular.module("Shop",[]);
shop.controller('ShopCtrl',  function($scope, $http){
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


	$scope.items = [];

	$scope.open_success_buy = function(){
		let modal = document.querySelector("#modal-info2");
		modal.classList.add("show");
        modal.style.width = 100 + "%";
        modal.style.height = 100 + "%";
	}

	$scope.close_success_buy  = function(){
	 	let modal = document.querySelector("#modal-info2")
	    modal.classList.remove("show")
	    modal.style.width = 0
	    modal.style.height = 0	
	}

	$scope.open_error_buy = function(){
		let modal = document.querySelector("#modal-info3");
		modal.classList.add("show");
        modal.style.width = 100 + "%";
        modal.style.height = 100 + "%";
	}

	$scope.close_error_buy  = function(){
	 	let modal = document.querySelector("#modal-info3")
	    modal.classList.remove("show")
	    modal.style.width = 0
	    modal.style.height = 0	
	}


	$scope.update =function(){
		$http.get('api/shop.php?move=1').then(function success(result){
			let data = result.data;
			console.log(result)
			$scope.items = [];
			for (var i = data.length - 1; i >= 0; i--) {
				$scope.items.push(new Item(data[i]['id'], data[i]['title'], data[i]['photo'], data[i]['coast']));
			}
		});
	}

	$scope.buy = function(item){
		$http.get('api/shop.php?move=2&item_id='+item.id).then(function success(result){
			console.log(result);
			let data = result.data;
			if(data['status'] == 'success'){
				$scope.open_success_buy();
			}else{
				$scope.open_error_buy();
			}
		});
	}


$scope.update();

});