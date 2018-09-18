@extends('layouts.master')

@section('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<style type="text/css">
    #ui-datepicker-div {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
@endsection
@section('content')
   
@include('employee.edit_emp_popup')    
    <div class="row">
        <div class="col-lg-12">
            <section class="panel panel-default">
                <header class="panel-heading">
                    Add New Employee

                    @if(isset(Auth::user()->username))
                      <div class="pull-right">
                           <strong>Welcome {{ Auth::user()->username }}</strong>
                           <a href="{{ route('logout') }}">Logout</a>
                      </div>
                     
                     @endif
                </header>
                
                <form class="form-horizontal" action="{{route('save_employee_data')}}" id="frm-create-emp" method="post">
                   {{ csrf_field() }}
                    <div class="panel-body" style="border-bottom: 1px solid #ccc;">
                        
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
                                <div class="input-group">
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
                                    <input type="text" name="dob" id="dob" class="form-control main_dob" value="{{ old('dob') }}">
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

                    <div class="panel-footer" align="center">
                        <button type="submit" class="btn btn-primary btn-sm">Save Employee</button>
                    </div>

                </form>


                <div class="panel panel-default">
                    <div class="panel-heading">Employee Information</div>
                    <div class="panel-body" id="add-class-info">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered table-hover table-condensed table-striped" id="ajax-employee-search-table">
                                    <thead>
                                        <th>N<sup>o</sup></th>
                                        <th>Employee Name</th>
                                        <th>Designation</th>
                                        <th>DOB</th>
                                        <th>Age</th>
                                        <th>Action</th>
                                    </thead>
                                    
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Designation Information</div>
                    <div class="panel-body" id="add-class-info">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered table-hover table-condensed table-striped" id="designation-table">
                                    <thead>
                                        <tr>
                                          <th>N<sup>o</sup></th>
                                          <th>Designation</th>
                                          <th>Total Employee Count</th>  
                                        </tr>
                                        
                                    </thead>
                                    <tbody>
                                        @foreach($designation_with_count as $cou)
                                        <tr>
                                            <th>{{$cou->id}}</th>
                                            <th>{{$cou->designation_name}}</th>
                                            <th>{{$cou->employees_count}}</th>
                                        </tr>
                                            
                                        @endforeach
                                        
                                    </tbody>
                                    
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
   
@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $( function() {

        $( "#dob" ).datepicker({
           dateFormat:'yy-mm-dd'
        });
        $( "#modal_dob" ).datepicker({
           dateFormat:'yy-mm-dd'
        });
        

        //employee data with search
        $('#ajax-employee-search-table').DataTable({

                "language": {
                    "searchPlaceholder":"Employee Name or Designatioon"
                  },   
                "processing": true,
                "serverSide": true,
                "searching": true,
                "ajax":{
                            "url": "{{ route('showAjaxEmpInfo') }}",
                            "dataType": "json",
                            "type": "POST",
                            "data":{ _token: "{{csrf_token()}}"}
                        },
                "columns": [
                               { "data": "employee_id" },
                               { "data": "employee_name" },
                               { "data": "designation_name" },
                               { "data": "dob" },
                               { "data": "age" },
                               { "data": "options" }
                           ]    
        });

        $('#designation-table').DataTable();



      } );

    //employee edit

    $(document).on('click','.edit_emp_data',function(e){
        e.preventDefault();
        $("#emp-show").modal(); 
        var emp_id=$(this).data('id');
        $.get("{{route('EditAjaxEmpInfo')}}", {employee_id:emp_id}, function(data){
            $('#employee_name').val(data.employee_name);
            $('#modal_dob').val(data.dob);
            $('#designation_id').val(data.designation.id);
            $("#emp_id").val(data.employee_id);
           
        })
    });

    //employee update

    $('.btn-save-emp').on('click',function(e){
        var data= $('#frm-create-emp').serialize();
        $.post("{{ route('upadteEmpInformation') }}", data, function(data){
           location.reload(true);
        });
    });

</script>
@endsection
