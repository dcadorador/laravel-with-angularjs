(function(){
  "use strict";

    angular.module('Domain', [])

    .factory('DomainRepository', DomainRepository)

    .directive('domains', Domains)

    function Domains(BASE) {

        return {
            restrict: 'EA',
            controller: DomainsController,
            templateUrl: BASE.API_URL + 'app/components/templates/domain/index.html',
            link: function (scope, element, attributes) {  

            }
        }

    }

    function DomainsController($scope, DomainRepository, $timeout, blockUi, $uibModal, BASE) {

        $scope.isLoaded = false;

        $scope.doSearch = function(){
            $scope.data();
        }

        $scope.pagination = {
            totalItems: 0,
            currentPage: 1,
            itemsPerPage: 10,
            maxSize: 5,
            search: '',
            objects: [],
        }

        $scope.setPage = function (pageNo) {
            $scope.pagination.currentPage = pageNo;
        };

        $scope.pageChanged = function() {
            $scope.data();
        };


        $scope.data = function(){

            blockUi.open('.m-wrapper', {
                overlayColor: '#000000',
                type: 'loader',
                message: 'Loading...'
            });

            let params = {
                page: $scope.pagination.currentPage,
                rows: $scope.pagination.itemsPerPage,
                search: $scope.pagination.search,
            };
            
            DomainRepository.get(params).then(function(response){

                let res  = response.data.success;
                $scope.pagination.objects = res.data.data;
                $scope.pagination.totalItems = res.data.total;
                $scope.isLoaded = true;
                blockUi.close('.m-wrapper');

            });
            
        }

        $scope.setItemsPerPage = function(num) {
            $scope.pagination.itemsPerPage = num;
            $scope.pagination.currentPage = 1; //reset to first paghe
            $scope.data();
        }        

        $timeout(function(){
            $scope.data();
        });


        $scope.add = function(){

            $uibModal.open({
              animation: true,
              templateUrl: BASE.API_URL + 'app/components/templates/domain/add-form.html',
              backdrop: 'static',
              controller: function($uibModalInstance, $scope, blockUi, $timeout, DomainRepository, BASE){
                  
                  $scope.isLoaded = false;
                  blockUi.open('.modal-body', {
                        overlayColor: '#000000',
                        type: 'loader',
                        message: 'Loading...'
                    });

                  $timeout(function(){
                      $scope.isLoaded = true;
                      blockUi.close('.modal-body');

                  });

                  $scope.submit = function(){

                      $scope.isLoaded = false;
                      blockUi.open('.modal-body', 'Loading...');

                      DomainRepository.store($scope.domain).then(function (e) {

                          $scope.isLoaded = true;
                          blockUi.close('.modal-body');

                          swal("Success!", e.data.success.message, "success");

                          $scope.cancel();
                          $scope.data();
                          

                      }, function (resp) {

                          $scope.isLoaded = true;
                          blockUi.close('.modal-body');


                          let html = '<ul class="list-group">';

                          if (resp.data.errors) {

                              let errors = resp.data.errors;                                

                              angular.forEach(errors, function(index, val){
                                  html += '<li class="list-group-item">' + index[0] + '<span class="badge badge-default"> <i class="fa fa-close"></i> </span></li>';
                              })

                          }else if (resp.data.error) {

                              html += '<li class="list-group-item">' + resp.data.error.message + '<span class="badge badge-default"> <i class="fa fa-close"></i> </span></li>';
                          }                            

                          html += '</ul>';

                          swal({ 
                              title:"Failed!", 
                              html: html,
                              type: "error" 
                          });                            

                      });

                  }

                  $scope.cancel = function () {
                      $uibModalInstance.dismiss('close');
                  }
              },
              size: 'md'
            });
        }

        $scope.edit = function(obj){

            $uibModal.open({
              animation: true,
              templateUrl: BASE.API_URL + 'app/components/templates/domain/edit-form.html',
              backdrop: 'static',
              controller: function($uibModalInstance, $scope, blockUi, $timeout, DomainRepository, BASE){

                  $scope.domain = obj;
                  
                  $scope.isLoaded = false;

                  blockUi.open('.modal-body', {
                      overlayColor: '#000000',
                      type: 'loader',
                      message: 'Loading...'
                  });

                  $timeout(function(){
                      $scope.isLoaded = true;
                      blockUi.close('.modal-body');
                  });

                  $scope.submit = function(){

                      $scope.isLoaded = false;
                      blockUi.open('.modal-body', {
                          overlayColor: '#000000',
                          type: 'loader',
                          message: 'Loading...'
                      });

                      DomainRepository.update(obj.id, $scope.domain).then(function (e) {

                          $scope.isLoaded = true;
                          blockUi.close('.modal-body');

                          swal("Success!", e.data.success.message, "success");

                          $scope.cancel();
                          $scope.data();

                      }, function (resp) {

                          $scope.isLoaded = true;
                          blockUi.close('.modal-body');

                          let html = '<ul class="list-group">';

                          if (resp.data.errors) {

                              let errors = resp.data.errors;                                

                              angular.forEach(errors, function(index, val){
                                  html += '<li class="list-group-item">' + index[0] + '<span class="badge badge-default"> <i class="fa fa-close"></i> </span></li>';
                              })

                          }else if (resp.data.error) {

                              html += '<li class="list-group-item">' + resp.data.error.message + '<span class="badge badge-default"> <i class="fa fa-close"></i> </span></li>';
                          }                            

                          html += '</ul>';

                          swal({ 
                              title:"Failed!", 
                              html: html,
                              type: "error" 
                          });                            
                           

                      });

                  }

                  $scope.cancel = function () {
                      $uibModalInstance.dismiss('close');
                  }
              },
              size: 'md'
            });
        }

        $scope.destroy = function(obj){
          
          swal({
            title:"Are you sure?",text:"You won't be able to revert this!",
            type:"warning",
            showCancelButton:!0,
            confirmButtonText:"<span><i class='flaticon-paper-plane'></i><span>Yes Delete it!</span></span>",
            confirmButtonClass:"btn btn-success m-btn m-btn--pill m-btn--air m-btn--icon",
            cancelButtonText:"<span><i class='la la-thumbs-down'></i><span>No, thanks</span></span>",
            cancelButtonClass:"btn btn-secondary m-btn m-btn--pill m-btn--icon",
            reverseButtons:!0
          }).then(function(e){

            if (e.value) {

              DomainRepository.destroy(obj.id).then(function(e){
                  $scope.data();
                  swal("Domain Deleted!", "Domain has been successfully deleted.", "success");

              },function(e){

                  swal("Error!", "Deletion of this domain has been failed.", "error");
              })

            }else{
              swal("Cancelled", "Deletion of this domain has been cancelled", "error");
            }

          })

        }

    }


    function DomainRepository(BASE, $http) {

        let url = BASE.API_URL + BASE.API_VERSION + '/domain';

        let repo = {};

        repo.all = function(){
            return $http.get(url + '/all');
        }

        repo.get = function(params){
            return $http.get(url, {params});
        }

        repo.store = function(params){
            return $http.post(url, params);
        }

        repo.update = function(id, params){
            return $http.patch(url + '/' + id, params);
        }

        repo.destroy = function(id){
            return $http.delete(url + '/' + id);
        }

        return repo;        
    }


})();