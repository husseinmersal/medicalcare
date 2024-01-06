<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private $services;

    public function __construct(SingleServiceRepositoryInterface $services)
    {
        $this->services = $services;
    }
    public function index()
    {
        return $this->services->index();
    }

}
