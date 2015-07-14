<p class="lead">Create Account</p>
<form ng-submit="create(register)" class="form-horizontal" novalidate>
	<div class="form-group">
		<label for="sid" class="label-control col-sm-3">Student ID</label>
		<div class="col-sm-9"><input id="sid" type="number" ng-model="register.sid" class="form-control" required></div>
	</div>
	<div class="form-group">
		<label for="firstname" class="label-control col-sm-3">First name</label>
		<div class="col-sm-9"><input id="firstname" type="text" ng-model="register.firstname" class="form-control" required></div>
	</div>
	<div class="form-group">
		<label for="lastname" class="label-control col-sm-3">Last name</label>
		<div class="col-sm-9"><input id="lastname" type="text" ng-model="register.lastname" class="form-control" required></div>
	</div>
	<div class="form-group">
		<label for="username" class="label-control col-sm-3">Username</label>
		<div class="col-sm-9"><input id="username" type="text" ng-model="register.username" class="form-control" required></div>
	</div>
	<div class="form-group">
		<label for="password" class="label-control col-sm-3">Password</label>
		<div class="col-sm-9"><input id="password" type="password" ng-model="register.password" class="form-control" required></div>
	</div>
	<div class="form-group" ng-hide="register.role == 'student'">
		<label for="email" class="label-control col-sm-3">Email</label>
		<div class="col-sm-9">
		<input id="email" type="email" ng-model="register.adminemail" class="form-control" required></div>
	</div>
	<div class="form-group" ng-show="register.role == 'student'">
		<label for="emaildomain" class="label-control col-sm-3">Email</label>
		<div class="col-sm-9">
			<div class="input-group">
				<input id="emaildomain" ng-model="register.studentemail" type="text" class="form-control" aria-describedby="basic-addon" required>
				<!-- <span class="input-group-addon" id="basic-addon">{{ register.school.email_domain }}</span> -->
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="role" class="label-control col-sm-3">Role</label>
		<div class="col-sm-9">
			<select id="role" ng-model="register.role" class="form-control">
				<option value="admin">University Admin</option>
				<option value="student">Student</option>
			</select>
		</div>
	</div>
	<div class="form-group" ng-show="register.role == 'student'">
		<label for="school" class="label-control col-sm-3">School</label>
		<div class="col-sm-9">
			<!-- Add this to ng-options
			university.name for university in universities

			-->
			
			<select id="school" ng-model="register.school" class="form-control">
				<option ng-repeat="u in universities" ng-value = "u.u_id">{{u.u_name}}</option>
			</select>
		</div>
	</div>

	<input class="btn btn-success btn-block" type="submit" value="Create">
</form>
<div class="alert alert-danger" ng-show="errorMessage_create" style="margin-top: 10px; margin-bottom: 0;">{{ errorMessage_create }}</div>
