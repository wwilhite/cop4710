<div class="row" ng-show="createEventSuccess">
  <div class="col-sm-12">
    <div class="alert alert-success">
      {{ createEventSuccess }}
      <button class="close" ng-click="createEventSuccess = false">&times;</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <h1 style="margin-top: 12px;">Welcome, {{ firstname }}</h1> 
      </div>
    </div>
    <div class="row" ng-show="rsoSuccess">
      <div class="col-sm-12">
        <div class="alert alert-success">{{ rsoSuccess }}<button class="close" ng-click="rsoSuccess=false">&times;</button></div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-8">
        <div class="panel panel-default">
          <div class="panel-body">
            <div google-map><div id="map"></div></div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-body">
            <p class="lead">Upcoming {{ university.name }} and RSO Events</p>
          </div>
          <ul class="list-group">
            <div ng-repeat="event in filteredEvents">
              <li class="list-group-item">
                <p class="lead">{{ event.name }}</p>
                <p ng-bind-html="event.description"></p>
                <p>
                <span ng-show="event.rso != null"><strong>Presenting RSO</strong> {{ event.rso }}<br></span>
                <strong>Date: </strong> {{ event.date | date:'short':'UTC' }}<br>
                <strong>{{ event.visibility }} Event</strong><br>
                <strong>Location</strong> <a href ng-click="openInfoWindow(event.marker)">{{ event.location_name }}</a><br>
                <strong>Type</strong> {{ event.type }}<br>
                <span ng-hide="event.phone == null && event.email == null"><strong>Contact</strong> </span>
                <span ng-show="event.phone != null"><strong>Phone:</strong> {{ event.phone }}<br></span>
                <span ng-show="event.email != null"><strong>Email:</strong> {{ event.email }}<br></span>
                <strong>Rating: </strong> {{ event.rating | number:1 }} stars
                </p>
                <p class="lead">Comments</p>
                <table class="table table-hover" ng-show="event.comments">
                  <tr ng-repeat="comment in event.comments">
                    <td>
                      <div>
                        <button style="margin-right: 5px;" class="pull-right clearfix btn btn-danger btn-sm" ng-show="comment.userid == userid" ng-click="deleteComment(comment, event)">Delete</button>
                      </div>
                      <p><strong>{{ comment.name }}</strong> @ {{ comment.created | date:'short':'UTC' }}<br>
                      <strong>Rated:</strong> {{ comment.rating }} stars<br>
                      {{ comment.body }}</p>
                    </td>
                  </tr>
                </table>
                <form ng-submit="addComment(comment, event)" class="form">
                  <div class="form-group">
                    <label for="rating" class="label-control">Rating</label>
                    <select ng-model="comment.rating" id="rating" class="form-control" ng-options="rating.display for rating in ratings"></select>
                  </div>
                  <div class="form-group">
                    <label for="comment" class="label-control">Comment</label>
                    <input ng-model="comment.body" id="comment" type="text" class="form-control">
                  </div>
                  <input type="submit" value="Add Comment" class="btn btn-primary">
                </form>
              </li>
            </div>
          </ul>
        </div>
      </div>
        <div class="col-sm-4">
          <div class="panel panel-default">
            <div class="panel-body">
              <p class="lead">Filter Events</p>
              <button class="btn btn-primary btn-block" ng-click="getLocation()" style="margin-top: 0; margin-bottom: 10px;">Events Near Me</button>
              <div class="form">
                <div class="form-group">
                  <label for="rso" class="label-control">RSOs</label>
                  <select class="form-control" id="rso" ng-model="rso.name" ng-options="rso.name for rso in rsos"></select>
                </div>
              </div>
              <p class="lead">About</p>
              <hr>
              <p>{{ rso.name.description }}</p>
            </div>
          </div>
          <div ng-show="role == 'super'"class="panel panel-default">
            <div class="panel-body">
              <p class="lead">University Super Admin Options</p>
              <button class="btn btn-warning btn-block" ng-click="openCreateEvent()">Create University Event</button>
              <!-- Show rso requests if there are any! -->
              <div ng-show="rsorequests">
                <hr>
                <p class="lead" style="margin-bottom: 0;">RSO Requests</p>
                <ul class="list-group" ng-show="rsorequests">
                  <li class="list-group-item" ng-repeat="request in rsorequests">
                    <p class="lead">{{ request.name }}</p>
                    <p>
                      <strong>Description: </strong><br>{{ request.description }}<br><br>
                      <strong>Type: </strong><br>{{ request.type }} <br><br>
                      <strong>Members: </strong><span ng-repeat="member in request.members">{{ member.name }}, </span>
                    </p>
                    <div class="row">
                      <div class="col-sm-6">
                        <button ng-click="accept(request)" class="btn btn-success btn-block">Accept</button>
                      </div>
                      <div class="col-sm-6">
                        <button ng-click="reject(request)" class="btn btn-danger btn-block">Reject</button>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div ng-show="role == 'admin'" class="panel-body">
            <student-rsos></student-rsos>
            <hr>
            <p class="lead">RSO Admin options</p>
            <button class="btn btn-warning btn-block btn-sm" ng-click="openCreateEvent()">Create RSO Event</button>
          </div>
          <imagecarousel></imagecarousel>
        </div>
      </div>
    </div>
  </div>
</div>