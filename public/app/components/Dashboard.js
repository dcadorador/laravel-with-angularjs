(function(){
  "use strict";

    angular.module('Dashboard', [])

    .factory('ReportRepository', ReportRepository)
    .factory('AutologinLogRepository', AutologinLogRepository)
    .factory('IPNRepository', IPNRepository)
    .factory('ManualCancellationRepository', ManualCancellationRepository)
    .factory('MemberiumCancellationRepository', MemberiumCancellationRepository)
    .factory('SyncLogRepository', SyncLogRepository)
    .factory('UpsellLogRepository', UpsellLogRepository)

    .directive('reports', Reports)
    .directive('autologinLogs', AutologinLogs)
    .directive('ipnLogs', IpnLogs)
    .directive('manualCancellations', ManualCancellationLogs)
    .directive('memberiumCancellations', MemberiumCancellationLogs)
    .directive('syncLogs', SyncLogs)
    .directive('upsellLogs', UpsellLogs)

    function Reports(BASE) {

        return {
            restrict: 'EA',
            controller: ReportsController,
            templateUrl: BASE.API_URL + 'app/components/templates/report/index.html',
            link: function (scope, element, attributes) {  

            }
        }

    }

    function ReportsController($scope, ReportRepository, $timeout, blockUi) {

        $scope.isLoaded = false;

        $scope.data = function(){

            blockUi.open('.m-wrapper', {
                overlayColor: '#000000',
                type: 'loader',
                message: 'Loading...'
            });

            var params = {
                report_date: $('#report_date_range').val()
            };
            
            ReportRepository.get(params).then(function(response){

                $scope.obj = response.data.success.data;

                $scope.isLoaded = true;
                blockUi.close('.m-wrapper');

            });
            
        }

        $timeout(function(){

            $('#m_dashboard_daterangepicker').daterangepicker({
                  opens: 'left',
                  startDate: moment(),
                  endDate: moment(),
                  //minDate: '01/01/2012',
                  //maxDate: '12/31/2014',
                  dateLimit: {
                      days: 60
                  },
                  showDropdowns: true,
                  showWeekNumbers: true,
                  timePicker: false,
                  timePickerIncrement: 1,
                  timePicker12Hour: true,
                  ranges: {
                      'Today': [moment(), moment()],
                      'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                      'Last 7 Days': [moment().subtract('days', 6), moment()],
                      'Last 30 Days': [moment().subtract('days', 29), moment()],
                      'This Month': [moment().startOf('month'), moment().endOf('month')],
                      'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                  },
                  buttonClasses: ['btn'],
                  applyClass: 'green',
                  cancelClass: 'default',
                  format: 'MM/DD/YYYY',
                  separator: ' to ',
                  locale: {
                      applyLabel: 'Apply',
                      fromLabel: 'From',
                      toLabel: 'To',
                      customRangeLabel: 'Custom Range',
                      daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                      monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                      firstDay: 1
                  }
                },
                function (start, end) {
                    $('#m_dashboard_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#report_date_range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                    $scope.data();
                }
            );
              //Set the initial state of the picker label
            $('#m_dashboard_daterangepicker span').html(moment().format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#report_date_range').val(moment().format('YYYY-MM-DD') + ' - ' + moment().format('YYYY-MM-DD'));
            $scope.data();
        });

    }

    function IpnLogs(BASE) {

        return {
            restrict: 'EA',
            controller: IpnLogsController,
            templateUrl: BASE.API_URL + 'app/components/templates/ipn/index.html',
            link: function (scope, element, attributes) {  

            }
        }

    }

    function IpnLogsController($scope, IPNRepository, $timeout, blockUi) {

        $scope.isLoaded = false;

        $scope.doSearch = function(){
            $scope.data();
        }

        $scope.pagination = {
            totalItems: 0,
            currentPage: 1,
            itemsPerPage: 25,
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
                report_date: $('#report_date_range').val()
            };
            
            IPNRepository.get(params).then(function(response){

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

            $('#m_dashboard_daterangepicker').daterangepicker({
                  opens: 'left',
                  startDate: moment(),
                  endDate: moment(),
                  //minDate: '01/01/2012',
                  //maxDate: '12/31/2014',
                  dateLimit: {
                      days: 60
                  },
                  showDropdowns: true,
                  showWeekNumbers: true,
                  timePicker: false,
                  timePickerIncrement: 1,
                  timePicker12Hour: true,
                  ranges: {
                      'Today': [moment(), moment()],
                      'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                      'Last 7 Days': [moment().subtract('days', 6), moment()],
                      'Last 30 Days': [moment().subtract('days', 29), moment()],
                      'This Month': [moment().startOf('month'), moment().endOf('month')],
                      'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                  },
                  buttonClasses: ['btn'],
                  applyClass: 'green',
                  cancelClass: 'default',
                  format: 'MM/DD/YYYY',
                  separator: ' to ',
                  locale: {
                      applyLabel: 'Apply',
                      fromLabel: 'From',
                      toLabel: 'To',
                      customRangeLabel: 'Custom Range',
                      daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                      monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                      firstDay: 1
                  }
                },
                function (start, end) {
                    $('#m_dashboard_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#report_date_range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                    $scope.data();
                }
            );
              //Set the initial state of the picker label
            $('#m_dashboard_daterangepicker span').html(moment().format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#report_date_range').val(moment().format('YYYY-MM-DD') + ' - ' + moment().format('YYYY-MM-DD'));
            $scope.data();
        });

    }    


    function AutologinLogs(BASE) {

        return {
            restrict: 'EA',
            controller: AutologinLogsController,
            templateUrl: BASE.API_URL + 'app/components/templates/autologin/index.html',
            link: function (scope, element, attributes) {  

            }
        }

    }

    function AutologinLogsController($scope, AutologinLogRepository, $timeout, blockUi) {

        $scope.isLoaded = false;

        $scope.doSearch = function(){
            $scope.data();
        }

        $scope.pagination = {
            totalItems: 0,
            currentPage: 1,
            itemsPerPage: 25,
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
            
            AutologinLogRepository.get(params).then(function(response){

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

            $('#m_dashboard_daterangepicker').daterangepicker({
                  opens: 'left',
                  startDate: moment(),
                  endDate: moment(),
                  //minDate: '01/01/2012',
                  //maxDate: '12/31/2014',
                  dateLimit: {
                      days: 60
                  },
                  showDropdowns: true,
                  showWeekNumbers: true,
                  timePicker: false,
                  timePickerIncrement: 1,
                  timePicker12Hour: true,
                  ranges: {
                      'Today': [moment(), moment()],
                      'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                      'Last 7 Days': [moment().subtract('days', 6), moment()],
                      'Last 30 Days': [moment().subtract('days', 29), moment()],
                      'This Month': [moment().startOf('month'), moment().endOf('month')],
                      'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                  },
                  buttonClasses: ['btn'],
                  applyClass: 'green',
                  cancelClass: 'default',
                  format: 'MM/DD/YYYY',
                  separator: ' to ',
                  locale: {
                      applyLabel: 'Apply',
                      fromLabel: 'From',
                      toLabel: 'To',
                      customRangeLabel: 'Custom Range',
                      daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                      monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                      firstDay: 1
                  }
                },
                function (start, end) {
                    $('#m_dashboard_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#report_date_range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                    $scope.data();
                }
            );
              //Set the initial state of the picker label
            $('#m_dashboard_daterangepicker span').html(moment().format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#report_date_range').val(moment().format('YYYY-MM-DD') + ' - ' + moment().format('YYYY-MM-DD'));
            $scope.data();
        });

    }

    function ManualCancellationLogs(BASE) {

        return {
            restrict: 'EA',
            controller: ManualCancellationLogsController,
            templateUrl: BASE.API_URL + 'app/components/templates/manual_cancellation/index.html',
            link: function (scope, element, attributes) {  

            }
        }

    }

    function ManualCancellationLogsController($scope, ManualCancellationRepository, $timeout, blockUi) {

        $scope.isLoaded = false;

        $scope.doSearch = function(){
            $scope.data();
        }

        $scope.pagination = {
            totalItems: 0,
            currentPage: 1,
            itemsPerPage: 25,
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
            
            ManualCancellationRepository.get(params).then(function(response){

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

    }   


    function MemberiumCancellationLogs(BASE) {

        return {
            restrict: 'EA',
            controller: MemberiumCancellationLogsController,
            templateUrl: BASE.API_URL + 'app/components/templates/memberium_cancellation/index.html',
            link: function (scope, element, attributes) {  

            }
        }

    }

    function MemberiumCancellationLogsController($scope, MemberiumCancellationRepository, $timeout, blockUi) {

        $scope.isLoaded = false;

        $scope.doSearch = function(){
            $scope.data();
        }

        $scope.pagination = {
            totalItems: 0,
            currentPage: 1,
            itemsPerPage: 25,
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
            
            MemberiumCancellationRepository.get(params).then(function(response){

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

    }  


    function SyncLogs(BASE) {

        return {
            restrict: 'EA',
            controller: SyncLogsController,
            templateUrl: BASE.API_URL + 'app/components/templates/sync_log/index.html',
            link: function (scope, element, attributes) {  

            }
        }

    }

    function SyncLogsController($scope, SyncLogRepository, $timeout, blockUi) {

        $scope.isLoaded = false;

        $scope.doSearch = function(){
            $scope.data();
        }

        $scope.pagination = {
            totalItems: 0,
            currentPage: 1,
            itemsPerPage: 25,
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
            
            SyncLogRepository.get(params).then(function(response){

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

    }  



    function UpsellLogs(BASE) {

        return {
            restrict: 'EA',
            controller: UpsellLogsController,
            templateUrl: BASE.API_URL + 'app/components/templates/upsell_log/index.html',
            link: function (scope, element, attributes) {  

            }
        }

    }

    function UpsellLogsController($scope, UpsellLogRepository, $timeout, blockUi) {

        $scope.isLoaded = false;

        $scope.doSearch = function(){
            $scope.data();
        }

        $scope.pagination = {
            totalItems: 0,
            currentPage: 1,
            itemsPerPage: 25,
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
            
            UpsellLogRepository.get(params).then(function(response){

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

    } 



    function ReportRepository(BASE, $http) {

        let url = BASE.API_URL + BASE.API_VERSION + '/reports';

        let repo = {};

        repo.get = function(params){
            return $http.get(url, {params});
        }

        return repo;        
    }

    function AutologinLogRepository(BASE, $http) {
      

        let url = BASE.API_URL + BASE.API_VERSION + '/autologin-logs';

        let repo = {};

        repo.get = function(params){
            return $http.get(url, {params});
        }

        return repo;        
    }

    function IPNRepository(BASE, $http) {

        let url = BASE.API_URL + BASE.API_VERSION + '/ipn-logs';

        let repo = {};

        repo.get = function(params){
            return $http.get(url, {params});
        }

        return repo;        
    }

    function ManualCancellationRepository(BASE, $http) {

        let url = BASE.API_URL + BASE.API_VERSION + '/manual-cancellation-logs';

        let repo = {};

        repo.get = function(params){
            return $http.get(url, {params});
        }

        return repo;        
    }    

    function MemberiumCancellationRepository(BASE, $http) {

        let url = BASE.API_URL + BASE.API_VERSION + '/memberium-cancellation-logs';

        let repo = {};

        repo.get = function(params){
            return $http.get(url, {params});
        }

        return repo;        
    } 
    
    function SyncLogRepository(BASE, $http) {

        let url = BASE.API_URL + BASE.API_VERSION + '/sync-logs';

        let repo = {};

        repo.get = function(params){
            return $http.get(url, {params});
        }

        return repo;        
    }

    function UpsellLogRepository(BASE, $http) {

        let url = BASE.API_URL + BASE.API_VERSION + '/upsell-logs';

        let repo = {};

        repo.get = function(params){
            return $http.get(url, {params});
        }

        return repo;        
    }
    

})();