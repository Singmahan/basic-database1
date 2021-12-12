<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

// import เพิ่มเข้ามาในกรณีบันทึกข้อมูลแบบ Query Builder
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(){
        // การดึงข้อมูลแบบ Eloquent
        $departments = Department::paginate(3);

        // การกู้คืนข้อมูล
        $trashDepartments = Department::onlyTrashed()->paginate(3);

        return view('admin.department.index',compact('departments','trashDepartments'));

        // การดึงข้อมูลแบบ Query Builder
        // $departments = DB::table('departments')->paginate(5);
        // return view('admin.department.index',compact('departments'));

        // การ Join Table แบบ Query Builder
        // $departments = DB::table('departments')
        //     ->join('users','departments.user_id','users.id')
        //     ->select('departments.*','users.name')->paginate(5);
        // return view('admin.department.index',compact('departments'));

        // การดึงข้อมูลแบบ Query Builder
        // $departments = DB::table('departments')->get();
        // return view('admin.department.index',compact('departments'));
    }
    public function store(Request $request){
        // การตรวจสอบข้อมูล
        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'
            ],
            [
                'department_name.required' => "กรุณาป้อนชื่อแผนกด้วยครับ",
                'department_name.max' => "ห้ามป้อนข้อมูลเกิน 255 ตัวอักษร",
                'department_name.unique' => "มีข้อมูลชื่อแผนกนี้ในฐานข้อมูลแล้ว"
            ]
        );

        // การบันทึกข้อมูลแบบเก่า
        // $department = new Department;
        // $department->department_name = $request->department_name;
        // $department->user_id = Auth::user()->id;
        // $department->save();
        // return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");

        // การบันทึกข้อมูลแบบ Query Builder
        $data = array();
        $data["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;
        DB::table('departments')->insert($data);
        return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");
    }
    public function edit($id){
        // การแก้ไขข้อมูลแบบ Eloquent
        $department = Department::find($id);
        return view('admin.department.edit',compact('department'));
    }
    public function update(Request $request, $id){
        // การตรวจสอบข้อมูล
        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'
            ],
            [
                'department_name.required' => "กรุณาป้อนชื่อแผนกด้วยครับ",
                'department_name.max' => "ห้ามป้อนข้อมูลเกิน 255 ตัวอักษร",
                'department_name.unique' => "มีข้อมูลชื่อแผนกนี้ในฐานข้อมูลแล้ว"
            ]
        );
        // Update data
        $update = Department::find($id)->update([
            'department_name' => $request->department_name,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('department')->with('success',"Update ข้อมูลเรียบร้อย");
    }
    public function softdelete($id){
        $delete = Department::find($id)->delete();
        return redirect()->back()->with('success',"ลบข้อมูลชั่วคราวเรียบร้อย");
    }
    public function restore($id){
        $restore = Department::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success',"กู้คืนข้อมูลเรียบร้อย");
    }
    public function delete($id){
        $delete = Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success',"ลบข้อมูลถาวร");
    }
}
