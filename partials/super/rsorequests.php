<p class="lead">Student RSO Requests</p>
<div class="col-sm-4" ng-repeat="request in rsorequests">
	<div class="panel panel-default">
		<div class="panel-body">
			<p class="lead">{{ request.name }}</p>
			<p>
				<strong>Description: </strong><br>{{ request.description }}<br><br>
				<strong>Type: </strong><br>{{ request.type }} <br><br>
				<strong>Members: </strong><span ng-repeat="member in request.members">{{ member.name }}, </span>
			</p>
		</div>
		<div class="panel-footer">
			<div class="col-sm-6">
				<button ng-click="accept(request)" class="btn btn-success btn-block">Accept</button>
			</div>
			<div class="col-sm-6">
				<button ng-click="reject(request)" class="btn btn-danger btn-block">Reject</button>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>