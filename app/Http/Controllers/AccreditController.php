<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccreditRequest;
use App\Http\Requests\UpdateAccreditRequest;
use App\Models\Accredit;

class AccreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accredits = Accredit::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('accredit.index', compact("accredits"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accredit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccreditRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Accredit $accredit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accredit $accredit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccreditRequest $request, Accredit $accredit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accredit $accredit)
    {
        //
    }
}
