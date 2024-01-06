<?php
namespace App\Repository\Services;

use App\Interfaces\Services\SingleServiceRepositoryInterface;
use App\Models\Service;

class SingleServiceRepository implements SingleServiceRepositoryInterface
{
  public function index()
  {
    $services = Service::all();

    return view('Dashboard.service.single-service.index', compact('services'));
  }


  public function store($request)
  {
    try {
      $SingleService = new Service();
      $SingleService->price = $request->price;
      $SingleService->description = $request->description;
      $SingleService->status = 1;
      $SingleService->save();

      // store trans
      $SingleService->name = $request->name;
      $SingleService->save();

      session()->flash('add');
      return redirect()->route('services.index');

    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function update($request)
  {
    try {

      $SingleService = Service::findOrFail($request->id);
      $SingleService->price = $request->price;
      $SingleService->description = $request->description;
      $SingleService->status = $request->status;
      $SingleService->save();

      // store trans
      $SingleService->name = $request->name;
      $SingleService->save();

      session()->flash('edit');
      return redirect()->route('services.index');

    } catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
  }

  public function destroy($request)
  {
    Service::destroy($request->id);
    session()->flash('delete');
    return redirect()->route('services.index');
  }
}