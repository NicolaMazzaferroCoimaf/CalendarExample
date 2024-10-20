<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $employees = Employee::get();

        return view('welcome', compact('employees'));
    }
}
