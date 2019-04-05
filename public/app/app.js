
angular.module('app', ['ui.bootstrap', 'ngCookies', 'Dashboard', 'User', 'Product', 'SystemSetting', 'Domain', 'Order', 'ui.router', 'ngAnimate'])

.config(function($interpolateProvider, $httpProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
})

.constant('BASE', {

//	'API_URL': window.location.protocol + '//doggydan.local',
    
	 'API_URL': window.location.protocol + '//systems.theonlinedogtrainer.com/',
    
	'ASSETS_URL': 'assets/',
    
	'API_VERSION': 'api/v1',
    
})

.run(['$rootScope', 'BASE', '$state', function ($rootScope, BASE, $state) {


}])

.service('blockUi', [function () {

    this.open = function(element, options){
        mApp.block(element, options);
    }

    this.close = function(element){
        mApp.unblock(element);        
    }

}])



.directive('labelStatus', ['$compile' ,function ($compile) {
  return {
    restrict: 'A',
    scope: {
      status: '@'
    },
    link: function (scope, iElement, iAttrs) {

      function refreshElement() {

        var template = '';

        if (scope.status == 'rfnd') {
          template = '<span class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-accent m-btn--gradient-to-success">Refund</span>';
        }else if (scope.status == 'pending') {
          template = '<span class="label label-default">Pending</span>';
        }else if (scope.status == 'Completed') {
          template = '<span class="btn btn-sm m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom">Completed</span>';
        }else if (scope.status == 'Skipped') {
          template = '<span class="btn btn-sm m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">Skipped</span>';
        }else if (scope.status == 'cncl') {
          template = '<span class="btn m-btn m-btn--pill m-btn--air m-btn--gradient-from-focus m-btn--gradient-to-danger">Cancel</span>';
        }else if (scope.status == 'rejected') {
          template = '<span class="label bg-red-soft bg-font-red-soft">Rejected</span>';
        }else if (scope.status == 'ended') {
          template = '<span class="label label-info">Ended</span>';
        }else if (scope.status == 'disabled') {
          template = '<span class="label label-warning">Disabled</span>';
        }else if (scope.status == 'approved') {
          template = '<span class="label label-success">Approved</span>';
        }else if (scope.status == 'declined') {
          template = '<span class="label label-default">Declined</span>';
        }else if (scope.status == 'in_review') {
          template = '<span class="label label-warning">In Review</span>';
        }else if (scope.status == 'penalized') {
          template = '<span class="label label-danger">Penalized</span>';
        }else if (scope.status == 'continued') {
          template = '<span class="label label-success">Continued</span>';
        }else if (scope.status == 'processed') {
          template = '<span class="label label-success">Processed</span>';
        }else if(scope.status == 'on-processed'){
          template = '<span class="label label-success">On-processed</span>';
        }else if (scope.status == 'cancelled') {
          template = '<span class="label bg-yellow-haze bg-font-yellow-haze">Cancelled</span>';
        }

        var content = $compile(template)(scope);
        iElement.replaceWith(content);
      }

      scope.$watch(scope.status, function(){
        refreshElement();
      });
    }
  };
}])
