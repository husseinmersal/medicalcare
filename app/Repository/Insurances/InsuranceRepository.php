<?php
namespace App\Repository\Insurances;

use App\Interfaces\Insurances\InsuranceRepositoryInterface;
use App\Models\Insurance;
use App\Models\Section;

class InsuranceRepository implements InsuranceRepositoryInterface
{

    public function index()
    {
        $insurances = Insurance::all();
        return view('Dashboard.insurance.index', compact('insurances'));
    }

    public function create()
    {
        return view('Dashboard.insurance.create');
    }

    public function store($request)
    {
        try {
            $insurances = new Insurance();
            $insurances->insurance_code = $request->insurance_code;
            $insurances->discount_percentage = $request->discount_percentage;
            $insurances->Company_rate = $request->Company_rate;
            $insurances->status = 1;
            $insurances->save();

            // insert trans
            $insurances->name = $request->name;
            $insurances->notes = $request->notes;
            $insurances->save();
            session()->flash('add');
            return redirect()->route('insurance.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $insurances = Insurance::findorfail($id);
        return view('Dashboard.insurance.edit', compact('insurances'));
    }

    public function update($request)
    {
        if (!$request->has('status'))
            $request->request->add(['status' => 0]);
        else
            $request->request->add(['status' => 1]);

        $insurances = Insurance::findOrFail($request->id);

        $insurances->update($request->all());

        // insert trans
        $insurances->name = $request->name;
        $insurances->notes = $request->notes;
        $insurances->save();

        session()->flash('edit');
        return redirect('insurance');
    }

    public function destroy($request)
    {
        Insurance::destroy($request->id);
        session()->flash('delete');
        return redirect('insurance');
    }

}