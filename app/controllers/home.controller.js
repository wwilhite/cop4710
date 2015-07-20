(function() {
var app = angular.module('Home.Controller', []);
app.controller('HomeController', ['$rootScope', '$scope', 'authorized', 'User', 'University', 'Session', '$modal', '$location', 'filterFilter', '$window', 'Rso', 'Event',
  function($rootScope, $scope, authorized, User, University, Session, $modal, $location, filterFilter, $window, Rso, Event) {
    if(!authorized) {
      $location.url('/public');
    }

    $scope.university = {};
    $scope.map = false;
    $scope.events = [];
    $scope.filteredEvents = [];
    $scope.rso = {};
    $scope.rsos = [];
    $scope.noProfile = true;

    $scope.comment = {};

    $scope.addComment = function(comment, event) {
      comment.e_id = event.e_id;
      comment.s_id = $rootScope.userid;
      Event.comment.save(comment, function(response) {
          $scope.comment = {};
          event.comments.push(response);
      });
    };

    $scope.deleteComment = function(comment, event) {
      var indexOfComment = event.comments.indexOf(comment);
      Event.comment.remove({eventid: event.id}, function(response) {
          // splice event array where this id did exist!
          event.comments.splice(indexOfComment, 1);
      });
    };
    
    var updateMarkers = function(oldMarkers) {
      var i;

      // remove old markers
      if(oldMarkers) {
        for(i = 0; i < oldMarkers.length; i++) {
          oldMarkers[i].marker.setMap(null);
          oldMarkers[i].marker = false;
        }
      }
      var infoWindow = new google.maps.InfoWindow();

      var new_marker = function(event) {
        event.marker = new google.maps.Marker({
          position: new google.maps.LatLng(event.location_lat, event.location_lng),
          title: event.location_name,
          map: $scope.map
        });

        google.maps.event.addListener(event.marker, 'click', function() {
          infoWindow.setContent('<h4>' + event.marker.title + '</h4><p>' +  event.name + '</p>');
          infoWindow.open($scope.map, event.marker);
        });
      };

      for(i = 0; i < $scope.filteredEvents.length; i++) {
        new_marker($scope.filteredEvents[i]);
      }

      // go to the first marker
      if($scope.filteredEvents[0]) {
        google.maps.event.trigger($scope.filteredEvents[0].marker, 'click');
      }
    };

    $scope.rsos = User.rsos.query({s_id: $rootScope.userid}, function (response) {
      $scope.rsos = response;

      angular.forEach($scope.rsos, function(value, key) {
        value.filter = value.r_name;
      });

      // Setup default 'filter', this will grab all university and rso events
      $scope.rsos.unshift({r_name: 'University Events', filter: null, description: 'University Events'});
      $scope.rsos.unshift({r_name: 'All Events', filter: '', description: 'All Events & RSOs'});
      if($scope.rsos[2].id === null) {
        var index = $scope.rsos.indexOf($scope.rsos[2]);
        $scope.rsos.splice(index, 1);
      }
      $scope.rso.name = $scope.rsos[0]; // set deafult
    });

    University.resource.query({s_id: $rootScope.userid}, function(response) {
        $scope.noProfile = false;
        $scope.university = response[0];

        //var images = response.data.images;
        //$scope.slides = [];
        //for(var i = 0; i < images.length; i++) {
        //  $scope.slides.push(images[i]);
        //}


        //Rso.query(function (response) {
        //  $scope.rsorequests = response;
        //});
    });

    var mapOptions = {
      zoom: 15,
      center: new google.maps.LatLng(28.602432, -81.200264),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    $scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);

    // This retrieves ALL events that the user is authorized to view, it will be filtered based on the drop down selector
    User.events.query({s_id: Session.s_id}, function(response) {
        $scope.events = response;
      var i;
      for(i = 0; i < $scope.events.length; i++) {
        $scope.events[i].comments = Event.comment.query({e_id: $scope.events[i].e_id});
      }

      updateMarkers(null);
    });

    // events will be updated and filtered here
    $scope.$watch('rso.name', function(rso) {
      if(rso) {
        var oldMarkers = $scope.filteredEvents;
        $scope.filteredEvents = filterFilter($scope.events, function(value, index) {
          if(value.rso == rso.filter || rso.filter === '')
            return true;
          else if(value.rso != rso.filter && rso.filter === null && (value.visibility == 'student' || value.visibility == 'public'))
            return true;
          return false;
        });
        updateMarkers(oldMarkers);
      }
    });

    // when clicked on an event location pops up a window
    $scope.openInfoWindow = function(marker){
      $window.scrollTo(0,0);
      google.maps.event.trigger(marker, 'click');
    };

    // Used if a user wants to just view whatever events are near them
    $scope.getLocation = function() { 
      navigator.geolocation.getCurrentPosition(function(position) {
        var local_lat = position.coords.latitude;
        var local_lng = position.coords.longitude;
        var latLng = new google.maps.LatLng(local_lat, local_lng);
        var oldMarkers = $scope.filteredEvents;
        var i;
        $scope.filteredEvents = [];
        $scope.map.setCenter(latLng);

        var check_distance = function(event) {
          // 2000 meters radius of the users location
          if(2000 > google.maps.geometry.spherical.computeDistanceBetween($scope.map.center, new google.maps.LatLng(event.location_lat, event.location_lng))) {
            $scope.filteredEvents.push($scope.events[i]);
          }
        };

        for(i = 0; i < $scope.events.length; i++) {
          check_distance($scope.events[0]);
        }
        updateMarkers(oldMarkers);
        $scope.$apply();
      });
    };

    $scope.openCreateEvent = function() {
      var modalInstance = $modal.open({
        size: 'lg',
        templateUrl: 'partials/admin/createEvent.html',
        controller: function($scope, $modalInstance, Event) {
          $scope.event = {};
          tinymce.remove(); // destroy tinyMCE to recreate it on next render 
          $scope.types = [
            {type: 'Social', value: 'social'},
            {type: 'Fundraising', value: 'fundraising'},
            {type: 'Tech Talk', value: 'techtalk'}
          ];
          $scope.visibilities = [
            {visibility: 'Public', value: 'public'},
            {visibility: 'RSO Members Only', value: 'rso'},
            {visibility: 'University Students Only', value: 'student'}
          ];
          
          $scope.event.type = $scope.types[0];
          $scope.event.visibility = $scope.visibilities[0];
          // Used for ui.bootstrap widgets
          $scope.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();
            $scope.opened = true;
          };

          $scope.event.date = Date.now();
          $scope.event.time = new Date().getTime();
          
          // close modal window after completion
          $scope.close = function() {
            $modalInstance.close();
          };

          $scope.validation = false;
          $scope.create = function(rsop) {
            // Fix type and visibility
            var insert = rsop;
            insert.sid = $rootScope.userid;
            insert.visibility = rsop.visibility.value;
            insert.type = rsop.type.value;
            // time and date must be convereted
            var time = new Date(insert.time);
            var date = new Date(insert.date); 
            date.setUTCMonth(date.getUTCMonth() + 1);

            // manually configure this for mysql insertion
            var mysql_datetime = 
              date.getFullYear() + '-' + 
              ((date.getMonth() < 10) ? '0' + date.getMonth() : date.getMonth()) + '-' + 
              ((date.getDate() < 10) ? '0' + date.getDate() : date.getDate()) + ' ' +
              ((time.getHours() < 10) ? '0' + time.getHours() : time.getHours()) + ':' + 
              ((time.getMinutes() < 10) ? '0' + time.getMinutes() : time.getMinutes()) + ':00';

            insert.date = mysql_datetime;
            Event.resource.save(insert, function(response) {
              if(response.status == 200) {
                $scope.event = {};
                $scope.event.type = $scope.types[0];
                $scope.event.visibility = $scope.visibilities[0];
                $scope.createEventError = false;
                $scope.$parent.createEventSuccess = response.data.message;
                $modalInstance.close();
              } else {
                $scope.createEventError = response.data.message;
              }
            });
          };
        } 
      });
    };
  }
]);

app.directive('availableRsos', [function() {
  return {
    restrict: 'E',
    templateUrl: 'partials/student/availableRsos.html',
    controller: function($scope, User) {
      $scope.join = function(joinrso) {
        var rso = {
          rsoid: joinrso.name.id
        };
        User.rso.save(rso, function(response) {
          console.log(response);
          if(status == 200) {
            $scope.joinErrorMessage = false;
          }else{
            $scope.joinErrorMessage = response.data.message;
          }
        });
      };

      $scope.closeErrorMessage = function() {
        $scope.joinErrorMessage = false;
      };
    }
  };
}]);

app.directive('studentRsos', [function() {
  return {
    restrict: 'E',
    templateUrl: 'partials/student/studentRsos.html',
    controller: function($scope, filterFilter) {
      
    }
  };
}]);
})();