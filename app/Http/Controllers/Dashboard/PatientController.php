<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Interfaces\Patients\PatientRepositoryInterface;


class PatientController extends Controller
{
    private $Patient;

    public function __construct(PatientRepositoryInterface $Patient)
    {
        $this->Patient = $Patient;
    }

    public function index()
    {
        return $this->Patient->index();
    }


    public function create()
    {
        return$this->Patient->create();
    }


    public function store(Request $request)
    {
       return $this->Patient->store($request);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        return $this->Patient->edit($id);
    }


    public function update(Request $request)
    {
        return $this->Patient->update($request);
    }


    public function destroy(Request $request)
    {
       return $this->Patient->destroy($request);
    }
}
