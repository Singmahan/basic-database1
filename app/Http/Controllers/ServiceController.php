<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(){
        // การดึงข้อมูลแบบ Eloquent
        $services = Service::paginate(3);
        return view('admin.service.index',compact('services'));

        // การดึงข้อมูลแบบ Query Builder
        // $services = DB::table('services')->paginate(3);
        // return view('admin.service.index',compact('services'));

    }
    public function store(Request $request){
        // การตรวจสอบข้อมูล
        $request->validate(
            [
                'service_name' => 'required|unique:services|max:255',
                'service_image' => 'required|mimes:jpg,jpeg,png'
            ],
            [
                'service_name.required' => "กรุณาระบุการบริการด้วยครับ",
                'service_name.max' => "ห้ามป้อนข้อมูลเกิน 255 ตัวอักษร",
                'service_name.unique' => "มีข้อมูลชื่อบริการนี้ในฐานข้อมูลแล้ว",
                'service_image.required' => "กรุณาระบุภาพประกอบการบริการด้วยครับ"
            ]
        );

        // การเข้ารหัสรูปภาพ
        $service_image = $request->file(('service_image'));
        // ทำการตั้งชื่อภาพใหม่
        $name_gen = hexdec(uniqid());

        // ดึงนามสกุลไฟล์ภาพ
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        $img_name = $name_gen.'.'.$img_ext;

        // การ upload image และบันทึกข้อมูล
        $upload_location = 'image/services';
        $full_path = $upload_location.$img_name;
        Service::insert([
            'service_name' => $request->service_name,
            'service_image' => $full_path,
            'created_at' => Carbon::now()
        ]);
        $service_image->move($upload_location,$img_name);
        return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");
    }
}
