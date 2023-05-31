<?php

namespace App\Http\Controllers;

use App\Models\SerialNumber;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $search = Request()->search ?? '';
        $serialNumber = SerialNumber::firstWhere('name', $search);

        $totalMissing = 0;
        if ($serialNumber) {
            // Verifico quante traduzioni mi mancano
            $totalMissing = $serialNumber->translations->where('status', '!=','pending')->count();
        }

        return view('dashboard', compact('search', 'serialNumber', 'totalMissing'));
    }
}
