<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = Request()->search ?? '';
        $orderBy = Request()->orderBy ?? 'source';
        $translations = Translation::where(function ($q) use ($search) {
            return $q
                ->where('source', 'like', '%' . $search . '%')
                ->orWhere('destination', 'like', '%' . $search . '%')
                ->orWhere('serial_number', 'like', '%' . $search . '%');
        })
            ->whereIn('status', ['translated'])
            ->orderBy($orderBy)
            ->paginate(200);

        return view('translation.index', compact('translations', 'search', 'orderBy'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTranslationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Translation $translation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Translation $translation)
    {
        return view('translation.edit', ['translation' => $translation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTranslationRequest $request, Translation $translation)
    {
        $translation->update([
            'translation' => $request['translation'],
            'status' => 'translated',
        ]);

        return to_route('translation.missing');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Translation $translation)
    {
        //
    }

    public function missing($serial = '')
    {
        $search = Request()->search ?? '';
        $orderBy = Request()->orderBy ?? 'source';
        $translations = Translation::join('languages', 'languages.code', 'language')
        ->select('translations.*', 'languages.name as language_name')
        ->where(function ($q) use ($search) {
            return $q
                ->where('source', 'like', '%' . $search . '%')
                ->orWhere('destination', 'like', '%' . $search . '%')
                ->orWhere('serial_number', 'like', '%' . $search . '%');
        })
        ->whereIn('status', ['pending', 'waiting'])
        ->orderBy($orderBy)
        ->paginate(200);
        return view('translation.missing', compact('translations', 'search', 'orderBy', 'serial'));
    }

    public function receiveMissing(Request $request)
    {
        Translation::upsert($request->all(), ['source', 'language', 'context'], ['serial_number', 'comment', 'status']);
        return response([
            'return code' => 0,
            'return text' => 'Done',
        ]);
    }
}
