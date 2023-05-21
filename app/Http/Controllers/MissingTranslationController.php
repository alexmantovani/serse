<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMissingTranslationRequest;
use App\Http\Requests\UpdateMissingTranslationRequest;
use App\Models\MissingTranslation;
use Illuminate\Http\Request;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MissingTranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = Request()->filter ?? 'all';
        switch ($filter) {
            case 'pending':
                $operator = '=';
                $statusString = 'pending';
                break;

            case 'waiting':
                $operator = '=';
                $statusString = 'waiting';
                break;

            case 'translated':
                $operator = '=';
                $statusString = 'translated';
                break;

            default:
                $operator = '!=';
                $statusString = '';
                break;
        }
        $search = Request()->search ?? '';
        $orderBy = Request()->orderBy ?? 'source';
        $missingTranslations = MissingTranslation::where(function ($q) use ($search) {
            return $q
                ->where('source', 'like', '%' . $search . '%')
                ->orWhere('serial_number', 'like', '%' . $search . '%');
        })
            ->where('status', $operator, $statusString)
            ->orderBy($orderBy)
            ->paginate(100);

        return view('missing.index', compact('missingTranslations', 'search', 'filter', 'orderBy'));
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
    public function store(StoreMissingTranslationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MissingTranslation $missingTranslation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MissingTranslation $missingTranslation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMissingTranslationRequest $request, MissingTranslation $missingTranslation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MissingTranslation $missingTranslation)
    {
        //
    }

    public function receiveMissing(Request $request)
    {
        MissingTranslation::upsert($request->all(), ['source', 'language'], ['serial_number']);

        return response([
            'return code' => 0,
            'return text' => 'Done',
        ]);
    }

    public function verifyBeforeSend()
    {
        $missings = MissingTranslation::where('status', 'pending')
            ->get()
            ->groupBy('language');

        return view('missing.verify', compact('missings'));
    }

    public function send()
    {
        $missings = MissingTranslation::where('status', 'pending')
            ->get()
            ->groupBy('language');

        // TODO: Invio le traduzioni a Intradoc


        // Le imposto come inviate
        MissingTranslation::where('status', 'pending')
            ->update(['status' => 'waiting']);

        return view('missing.sent');
    }

    public function load()
    {
        return view('missing.load');
    }

    public function upload(Request $request)
    {
        if ($request->file('file')) {
            $filePath = $request->file('file');
            $fileName = $filePath->getClientOriginalName();
            $extension = $request->file->getClientOriginalExtension();

            // Salvo i file nel seguente formato ""
            $path = $request->file('file')->storeAs($folder, $uuid . '.' . $extension);

            Log::debug($path);

            // $report = Report::create([
            //     'order_id' => $request['order_id'],
            //     'original_name' => $fileName,
            //     'folder' => $folder,
            //     'token' => $uuid,
            //     'to_customer' => $request['paziente'] == 1 ? True : False,
            //     'to_doctor' => $request['medico'] == 1 ? True : False,
            //     'to_sole' => $request['sole'] == 1 ? True : False,
            // ]);

            // $report->logs()->create([
            //     'description' => 'Caricato referto', // TODO: Da fare
            // ]);
            // Order::find($request['order_id'])->logga('Caricato referto "' . $folder . '/' . $fileName . '"');
        }

        return response()->json(['success' => $fileName]);
    }
}
