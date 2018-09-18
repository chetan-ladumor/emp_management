<div class="modal" id="emp-show" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Employee Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="form-horizontal" action="{{route('save_employee_data')}}" id="frm-create-emp" method="post">
               {{ csrf_field() }}
                <div class="panel-body" style="border-bottom: 1px solid #ccc;">
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="form-group">
                        
                        <div class="col-sm-4">
                            <label for="employee_name">Emploee Name</label>
                            <div class="input-group">
                                <input type="text" name="employee_name" class="form-control" id="employee_name" value="{{ old('employee_name') }}">
                            </div>
                            @if ($errors->has('employee_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('employee_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-sm-4">
                            <label for="designation_id">Designation</label>
                            <div class="input-group designation_div">
                                <select class="form-control" name="designation_id" id="designation_id">
                                    <option value="">Select Designation</option>
                                    
                                    @foreach($designations as $desi)
                                        <option value="{{$desi->id}}" {{ old('designation_id') == $desi->id ? 'selected' : '' }}>{{$desi->designation_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('designation_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('designation_id') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="col-sm-4">
                            <label for="dob">DOB</label>
                            <div class="input-group">
                                <input type="text" name="dob" id="modal_dob" class="form-control popup_dob" value="{{ old('dob') }}">
                                </input>
                            </div>
                            @if ($errors->has('dob'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                            @endif
                        </div>
                       

                    </div>
                </div>


            </form>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success btn-save-emp">Save</button>
			</div>
		</div>
	</div>
</div>