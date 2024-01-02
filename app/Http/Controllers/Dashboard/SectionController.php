<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Sections\SectionRepositoryInterface;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    private $sections;

    public function __construct(SectionRepositoryInterface $sections)
    {
        $this->sections = $sections;
    }
    public function index()
    {
        return $this->sections->index();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->sections->store($request);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
     return $this->sections->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->sections->destroy($request);
    }
}
