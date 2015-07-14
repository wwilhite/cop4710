<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<div id="map"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-body" style="height: 480px; overflow-y: hidden;">
				<p class="lead">Filter Events</p>
				<button class="btn btn-primary btn-block" ng-click="getLocation()" style="margin-bottom: 10px;">Events Near Me</button>
				<form class="form" ng-submit="updateFilter(filterUniversity)">
					<div class="form-group">
						<label for="university" class="label-control">University</label>
						<select id="role" ng-model="filterUniversity" class="form-control" ng-options="university.name for university in universities">
						</select>
					</div>
				</form>
				<p class="lead" style="margin-top: 10px;">About</p>
				<p ng-bind-html="filterUniversity.description"></p>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<ul class="list-group">
			<li class="list-group-item" ng-repeat="event in filteredEvents">
				<div id="anchor{{ event.id }}"></div>
				<p class="lead">{{ event.name }} {{ event.date | date:'short':'UTC' }}</p>
				<p ng-bind-html="event.description"></p>
				<p>
				<strong>University</strong> {{ event.university }}<br>
				<span ng-show="event.rso != null"><strong>Presenting RSO</strong> {{ event.rso }}<br></span>
				<strong>Location</strong> <a href ng-click="openInfoWindow(event.marker)">{{ event.location_name }}</a><br>
				<strong>Type</strong> {{ event.type }}<br>
				<span ng-hide="event.contactphone == null && event.contactemail == null"><strong>Contact</strong> </span>
				<span ng-show="event.contactphone != null"><strong>Phone:</strong> {{ event.contactphone }}<br></span>
				<span ng-show="event.contactemail != null"><strong>Email:</strong> {{ event.contactemail }}<br></span>
				</p>
			</li>
		</ul>
	</div>
</div>