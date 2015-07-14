<p class="lead">Filter Events</p>	
<div>
	<button class="btn btn-primary btn-block" ng-click="getLocation()" style="margin-top: 0; margin-bottom: 10px;">Events Near Me</button>
	<form class="form" ng-submit="view(rso)">
		<div class="form-group">
			<label for="rsoname" class="label-control">RSOs</label>
			<select class="form-control" id="rsoname" ng-model="rso.name" ng-options="mrso.name for mrso in member_rsos"></select>
		</div>
		<p><strong>About</strong><br>
			{{ rso.name.description }}
		</p>
		<!-- <input type="submit" value="View Events" class="btn btn-primary btn-block"> -->
	</form>
</div>