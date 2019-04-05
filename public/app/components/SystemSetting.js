(function(){
  "use strict";

    angular.module('SystemSetting', [])

    .factory('SystemSettingRepository', SystemSettingRepository)

    .directive('systemSettings', SystemSettings)


    function SystemSettings(BASE) {

        return {
            restrict: 'EA',
            controller: SystemSettingsController,
            templateUrl: BASE.API_URL + 'app/components/templates/system_setting/index.html',
            link: function (scope, element, attributes) {  

            }
        }

    }

    function SystemSettingsController($scope, SystemSettingRepository, $timeout, blockUi, $uibModal, BASE) {

        $scope.isLoaded = false;

        $scope.pagination = {
            objects: [],
        }


        $scope.data = function(){

            blockUi.open('.m-wrapper', {
                overlayColor: '#000000',
                type: 'loader',
                message: 'Loading...'
            });

            let params = {};
            
            SystemSettingRepository.get(params).then(function(response){

                let res  = response.data.success;
                $scope.pagination.objects = res.data.data;
                $scope.isLoaded = true;
                blockUi.close('.m-wrapper');
                
                // blockUi.close('.m-wrapper');

            });
            
        }
     
        $timeout(function(){
            $scope.data();
        });

        $scope.reset = function(){
          $scope.data();
        }

        $scope.submit = function(){
          swal({
            title:"Are you sure?",
            text:"You will update your system setting!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonText:"<span><i class='flaticon-paper-plane'></i><span>Yes Update it!</span></span>",
            confirmButtonClass:"btn btn-success m-btn m-btn--pill m-btn--air m-btn--icon",
            cancelButtonText:"<span><i class='la la-thumbs-down'></i><span>No, thanks</span></span>",
            cancelButtonClass:"btn btn-secondary m-btn m-btn--pill m-btn--icon",
            reverseButtons:!0
          }).then(function(e){

            if (e.value) {

              SystemSettingRepository.update(0, $scope.pagination.objects).then(function(e){
                  $scope.data();
                  swal("System Settings Updated!", "System Settings has been successfully updated.", "success");

              },function(e){

                  swal("Error!", "System Settings update has been failed.", "error");
              })

            }else{
              swal("Cancelled", "System Settings update has been cancelled", "error");
            }

          })
        }

    }


    function SystemSettingRepository(BASE, $http) {

        let url = BASE.API_URL + BASE.API_VERSION + '/system-settings';

        let repo = {};

        repo.get = function(params){
            return $http.get(url, {params});
        }

        repo.update = function(id, params){
            return $http.patch(url + '/' + id, params);
        }

        return repo;        
    }

})();