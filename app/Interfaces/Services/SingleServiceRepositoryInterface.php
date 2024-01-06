<?php
namespace App\Interfaces\Services;


interface SingleServiceRepositoryInterface
{

    // get All Sections
    public function index();
 
    public function store($request);

    public function update($request);

    public function destroy($request);

}