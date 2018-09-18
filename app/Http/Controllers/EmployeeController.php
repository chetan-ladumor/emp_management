<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use App\Employee;
use Carbon\Carbon;
class EmployeeController extends Controller
{
	// display Employee view with employee data and designation data
    public function index()
    {
    	$designations=Designation::all();
    	$designation_with_count=Designation::withCount('employees')
                                            ->get();
    	return view('employee.emp',compact('designations','designation_with_count'));
    }

    //save employee data
    public function save_employee_data(Request $request)
    {
    	$this->validate($request,[
    		'employee_name'=>'required',
    		'designation_id'=>'required',
    		'dob'=>'required',
    	]);
    	$age=Carbon::parse($request->dob)->age;
    	Employee::create([
    		'employee_name'=>$request->employee_name,
    		'designation_id'=>$request->designation_id,
    		'dob'=>$request->dob,
    		'age'=>$age,
    	]);
    	return redirect()->back();
    }

    //list out employee data wwith search
    // here i have used datatable but custom search functionality is implemented
    public function showAjaxEmpInfo(Request $request,Employee $employee)
    {
    	
    	$columns = array(
    						0=> 'employee_id', 
                            1 =>'employee_name', 
                            3 =>'designation_id',
                            4=> 'dob',
                            5=> 'age',
                           
    	                );
    	  
        $totalData = Employee::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        { 
        	$students=$employee->with('designation')
        	                   ->offset($start)
                               ->limit($limit)->get();           
            
            
        }
        else
        {
        	$search = $request->input('search.value'); 

            $students =  $employee->with('designation')
                            ->where('employee_name','LIKE',"%{$search}%")
                            ->orWhereHas(
							    'designation', function($query) use ($search){
								$query->where('designation_name','LIKE',"%{$search}%");

							    }
							)
            				->offset($start)
                            ->limit($limit)
                            ->get(); 
                            
            $totalFiltered = $employee->where('employee_name','LIKE',"%{$search}%"
        					)->orWhereHas(
							    'designation', function($query) use ($search){
								$query->where('designation_name','LIKE',"%{$search}%");

							    }
							)->count();
        	
        	
        }
        
    	$students_data = array();

    	if(!empty($students))
    	{
    	    foreach ($students as $student)
    	    {
    	    	$edit =  route('EditAjaxEmpInfo',$student->employee_id);
    	    	$delete =  route('DeleteAjaxEmpInfo',$student->employee_id);
    	       
    	        $nestedData['employee_name'] = $student->employee_name;
    	        $nestedData['designation_name'] = $student['designation']['designation_name'];
    	        $nestedData['dob'] = $student->dob;
    	        $nestedData['age'] = $student->age;
    	        $nestedData['employee_id'] = $student->employee_id;
    	        $nestedData['options'] = "&emsp;<a href='#' title='Edit' ><span class='glyphicon glyphicon-edit edit_emp_data' data-id='{$student->employee_id}'></span></a>
    	                                  &emsp;<a href='{$delete}' title='DELETE' ><span class='glyphicon glyphicon-trash'></span></a>";
    	        $students_data[] = $nestedData;
    	        

    	    }
    	}

    	$json_data = array(
    	            "draw"            => intval($request->input('draw')),  
    	            "recordsTotal"    => intval($totalData),  
    	            "recordsFiltered" => intval($totalFiltered), 
    	            "data"            => $students_data   
    	            );
    	    
    	echo json_encode($json_data);  
   
    	
    }

    //delete employee 
    public function DeleteAjaxEmpInfo($id)
    {
    	$employee=Employee::find($id);
    	$employee->delete();
    	return redirect()->back();
    }

    //get employee data for edit
    public function EditAjaxEmpInfo(Request $request,Employee $employee)
    {

    	if($request->ajax())
    	{
    		
    		return response( $employee->where('employee_id', $request->employee_id)->with('designation')->first());
    		
    	}
    }

    //update employee data
    public function upadteEmpInformation(Request $request,Employee $employee)
    {
    	$emp=$employee->find($request->emp_id);
    	$emp->age=Carbon::parse($request->dob)->age;
    	$emp->employee_name=$request->employee_name;
    	$emp->designation_id=$request->designation_id;
    	$emp->dob=$request->dob;
    	$emp->save();
    }	


}
