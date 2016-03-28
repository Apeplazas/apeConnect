var myAppModule = angular.module('gaTest', ['ngAnalytics']);
myAppModule.run(['ngAnalyticsService', function (ngAnalyticsService) {
    ngAnalyticsService.setClientId('721579387656-1e8fhcu8kpu8c6easfq0698b6dd7hfbf.apps.googleusercontent.com');
}]);
myAppModule.controller('MainCtrl', function ($scope) {
  $scope.extraChart = {
    reportType: 'ga',
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:date',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      ids: 'ga:92888823'
    },
    chart: {
      container: 'chart-container-3',
      type: 'LINE',
      options: {
        width: '100%'
      }
    }
  };

  $scope.chartTwo = {
    reportType: 'ga',
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:date',
      'start-date': '7daysAgo',
      'end-date': 'yesterday',
      ids: 'ga:92888823'
    },
    chart: {
      container: 'chart-container-1',
      type: 'LINE',
      options: {
        width: '100%',
        bgcolor: '#282C34'
      }
    }
  };

  $scope.chartThree = {
  reportType: 'ga',
  query: {
    metrics: 'ga:sessions',
    dimensions: 'ga:city',
    'start-date': '7daysAgo',
    'end-date': 'yesterday',
    ids: 'ga:92888823',
    'sort': '-ga:sessions',
  },
  chart: {
    container: 'chart-container-2',
    type: 'PIE',
    options: {
      width: '100%',
      is3D: true,
      title: 'Visitas por ciudad'
      }
    }
  };
    $scope.$on('$gaReportSuccess', function (e, report, element) {
        console.log(report, element);
    });
});
