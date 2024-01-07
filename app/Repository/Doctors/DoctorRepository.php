<?php
namespace App\Repository\Doctors;

use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Section;
use App\Models\Image;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class DoctorRepository implements DoctorRepositoryInterface
{
  use UploadTrait;
 

  public function index()
  {
    $doctors = Doctor::with(['section', 'image','appointments'])->get();
    return view('dashboard.doctor.index', compact('doctors'));
  }

  public function create()
  {
    $sections = Section::all();
    $appointments = Appointment::all();
    return view('Dashboard.doctor.add', compact('sections','appointments'));

  }

  public function store($request)
  {
    DB::beginTransaction();

    try {

        $doctors = new Doctor();
        $doctors->email = $request->email;
        $doctors->password = Hash::make($request->password);
        $doctors->section_id = $request->section_id;
        $doctors->phone = $request->phone;
        $doctors->status = 1;
    
        $doctors->name = $request->name;
        $doctors->save();

        // insert pivot tABLE
        $doctors->appointments()->attach($request->appointments);


        //Upload img
        $this->verifyAndStoreImage($request,'photo','doctors','upload_image',$doctors->id,'App\Models\Doctor');

        DB::commit();
        session()->flash('add');
        return redirect()->route('doctors.index');

    }
    catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }



  }

  public function edit($id)
  {
     $sections = Section::all();
     $appointments = Appointment::all();
     $doctor = Doctor::findOrFail($id);

     return view('Dashboard.doctor.edit',compact('doctor','sections','appointments'));
  }

  public function update($request)
  {
    DB::beginTransaction();

    try {

        $doctors = Doctor::findOrFail($request->id);

        $doctors->email = $request->email;
        $doctors->section_id = $request->section_id;
        $doctors->phone = $request->phone;

        $doctors->save();
        // store trans
        $doctors->name = $request->name;
        $doctors->save();

        $doctors->appointments()->sync($request->appointments);

        //Upload img
        if($request->has('photo')){
          if($doctors->image){
            $old_img =  $doctors->image->file_name;
            $this->delete_attachment('upload_image','doctors/'.$old_img,$request->id,$request->file_name);
          }
        }
        $this->verifyAndStoreImage($request,'photo','doctors','upload_image',$doctors->id,'App\Models\Doctor');

        DB::commit();
        session()->flash('add');
        return redirect()->route('doctors.create');

    }
    catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }


  }

  public function destroy($request)
  {
       if($request->file_name){
        $this->delete_attachment('upload_image','doctors/'.$request->file_name,$request->id,$request->file_name);
       }
       Doctor::destroy($request->id);
       session()->flash('delete');
       return redirect()->route('doctors.index');
  }

  
  public function update_password($request)
  {
      try {
          $doctor = Doctor::findorfail($request->id);
          $doctor->update([
              'password'=>Hash::make($request->password)
          ]);

          session()->flash('edit');
          return redirect()->back();
      }

      catch (\Exception $e) {
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
      }
  }


  public function update_status($request)
  {
      try {
          $doctor = Doctor::findorfail($request->id);
          $doctor->update([
              'status'=>$request->status
          ]);

          session()->flash('edit');
          return redirect()->back();
      }

      catch (\Exception $e) {
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
      }
  }

  public function showdoctors_bySection($id){
    $doctors = Section::findOrFail($id)->doctors;
    $section = Section::findOrFail($id);

    return view('Dashboard.section.show_doctors',compact(['doctors','section']));
  }
}