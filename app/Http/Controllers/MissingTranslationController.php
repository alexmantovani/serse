<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMissingTranslationRequest;
use App\Http\Requests\UpdateMissingTranslationRequest;
use App\Models\MissingTranslation;
use App\Models\SerialNumber;
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
            ->where('status', '!=', 'deleted')
            ->orderBy($orderBy)
            ->paginate(200);

        // return view('missing.index', compact('missingTranslations', 'search', 'filter', 'orderBy'));
        $serialNumber = null;
        if (isset(Request()->matricola)) {
            $serialNumber = SerialNumber::firstWhere('name', Request()->input('matricola'));
        }
        return view('missing.index', compact('serialNumber', 'missingTranslations', 'search', 'filter', 'orderBy'));
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
    public function edit($missingTranslation)
    {
        return view('missing.edit', ['missing_translation' => MissingTranslation::find($missingTranslation)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMissingTranslationRequest $request, $missingTranslationId)
    {
        $missingTranslation = MissingTranslation::find($missingTranslationId);
        $missingTranslation->update([
            'translation' => $request['translation'],
            'status' => 'translated',
        ]);

        return to_route('missing.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $missingTranslation = MissingTranslation::find($id);
        $missingTranslation->update(['status' => 'deleted']);

        // return redirect()->back();
        return back();
    }

    public function receiveMissing(Request $request)
    {
        MissingTranslation::upsert($request->all(), ['source', 'language', 'context'], ['serial_number', 'comment', 'status']);

        // TODO: In teoria andrebbero aggiunti i seriali delle nuove traduzioni alla classe SeriaNumber
        // $serials = $request->pluck('serial_number');
        // return $serials;

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

    public function indexSerial($serial)
    {
        // $serialNumber = SerialNumber::firstWhere('name', $matricola) ?? abort(404);

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
        $missingTranslations = MissingTranslation::where('serial_number', $serial)
            ->where(function ($q) use ($search) {
                return $q
                    ->where('source', 'like', '%' . $search . '%')
                    ->orWhere('serial_number', 'like', '%' . $search . '%');
            })
            ->where('status', $operator, $statusString)
            ->orderBy($orderBy)
            ->paginate(100);

        return view('missing.index_serial', compact('serial', 'missingTranslations', 'search', 'filter', 'orderBy'));
    }
}
