<div class="modal-header">
	<button class="close" ng-click="close()"><span>&times;</span></button>
	<div class="clearfix"></div>
</div>
<div class="modal-body">
	<form ng-submit="rsoCreate(rsop)" class="form-horizontal">
		<div class="form-group">
			<label for="rsoname" class="label-control col-sm-3">RSO Name</label>
			<div class="col-sm-9">
			<input id="roname" type="text" ng-model="rsop.name" class="form-control"></div>
		</div>
		<div class="form-group">
			<label for="rsodescription" class="label-control col-sm-3">Description</label>
			<div class="col-sm-9">
			<input id="rsodescription" type="text" ng-model="rsop.description" class="form-control"></div>
		</div>
		<div class="form-group">
			<label for="type" class="label-control col-sm-3">Type</label>
			<div class="col-sm-9">
				<select id="type" ng-model="rsop.type" class="form-control">
					<option value="club">Club</option>
					<option value="organization">Organization</option>
					<option value="fraternity">Fraternity</option>
					<option value="sorority">Sorority</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="rsoadmin" class="label-control col-sm-3">RSO Administrator</label>
			<div class="col-sm-9">
				<div class="input-group">
					<input id="rsoadmin" ng-model="rsop.members.admin" type="text" class="form-control" aria-describedby="basic-addon">
					<span class="input-group-addon" id="basic-addon">{{ university.email_domain }}</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="rsomember1" class="label-control col-sm-3">RSO Member 1</label>
			<div class="col-sm-9">
				<div class="input-group">
					<input id="rsomember1" ng-model="rsop.members.member1" type="text" class="form-control" aria-describedby="basic-addon">
					<span class="input-group-addon" id="basic-addon">{{ university.email_domain }}</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="rsomember2" class="label-control col-sm-3">RSO Member 2</label>
			<div class="col-sm-9">
				<div class="input-group">
					<input id="rsomember2" ng-model="rsop.members.member2" type="text" class="form-control" aria-describedby="basic-addon">
					<span class="input-group-addon" id="basic-addon">{{ university.email_domain }}</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="rsomember3" class="label-control col-sm-3">RSO Member 3</label>
			<div class="col-sm-9">
				<div class="input-group">
					<input id="rsomember3" ng-model="rsop.members.member3" type="text" class="form-control" aria-describedby="basic-addon">
					<span class="input-group-addon" id="basic-addon">{{ university.email_domain }}</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="rsomember4" class="label-control col-sm-3">RSO Member 4</label>
			<div class="col-sm-9">
				<div class="input-group">
					<input id="rsomember4" ng-model="rsop.members.member4" type="text" class="form-control" aria-describedby="basic-addon">
					<span class="input-group-addon" id="basic-addon">{{ university.email_domain }}</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="rsomember5" class="label-control col-sm-3">RSO Member 5</label>
			<div class="col-sm-9">
				<div class="input-group">
					<input id="rsomember5" ng-model="rsop.members.member5" type="text" class="form-control" aria-describedby="basic-addon">
					<span class="input-group-addon" id="basic-addon">{{ university.email_domain }}</span>
				</div>
			</div>
		</div>
		<input class="btn btn-primary btn-block" type="submit" value="Send Request">
	</form>
	<div class="alert alert-danger" ng-show="rsoRequestError" style="margin-top: 10px; margin-bottom: 0;">{{ rsoRequestError }}</div>
</div>