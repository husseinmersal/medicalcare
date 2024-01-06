<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use Illuminate\Http\Request;

class SingleServiceController extends Controller
{
    private $single_service;

    public function __construct(SingleServiceRepositoryInterface $single_service)
    {
        $this->single_service = $single_service;
    }



    public function index()
    {
        return $this->single_service->index();
    }


    public function store(Request $request)
    {
        return $this->single_service->store($request);
    }

    public function update(Request $request)
    {
        return $this->single_service->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->single_service->destroy($request);
    }
}
