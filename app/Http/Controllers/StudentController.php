<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{
	public function create(){
		return view('admin.add_student');
	}

	public function store(Request $request){
		$data = array();
		$data['name']			= $request->name;
		$data['roll']			= $request->roll;
		$data['fathersname']			= $request->fathersname;
		$data['mothersname']		= $request->mothersname;
		$data['email']		= $request->email;
		$data['phone']					= $request->phone;
		$data['address']					= $request->address;
		$data['password']					= $request->password;
		$data['admissyear']		= $request->admissyear;
		$data['department']		= $request->department;

		$image=$request->file('image');
		if($image){
			$image_name = rand();
			$ext = strtolower($image->getClientOriginalExtension());
			$image_full_name = $image_name.'.'.$ext;
			$upload_path = 'images/';
			$image_url = $upload_path.$image_full_name;
			$success = $image->move($upload_path,$image_full_name);
			if($success){
				$data['image']=$image_url;

				DB::table('students_tbl')->insert($data);
				return redirect('all-students')->with('status','added student');
			}
		}

		$data['image']='';
		DB::table('students_tbl')->insert($data);

		return redirect('add-student')->with('status', 'without image');
	}

	public function index(){
		$students = DB::table('students_tbl')->get();

		return view('admin.all_students', compact('students'));

	}


	public function cse(){
		$cse_students = DB::table('students_tbl')->where('department', 1)->get();

		return view('admin.cse', compact('cse_students'));
	}

	public function bba(){
		$bba_students = DB::table('students_tbl')->where('department', 2)->get();

		return view('admin.bba', compact('bba_students'));
	}

	public function eee(){
		$eee_students = DB::table('students_tbl')->where('department', 3)->get();

		return view('admin.eee', compact('eee_students'));
	}

	public function ece(){
		$ece_students = DB::table('students_tbl')->where('department', 4)->get();

		return view('admin.ece', compact('ece_students'));
	}



}
