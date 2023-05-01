<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccreditRequest;
use App\Http\Requests\UpdateAccreditRequest;
use App\Models\Accredit;
use App\Mail\AccreditCreated;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Response;

class AccreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = Request()->search ?? '';
        $accredits = Accredit::where('customer_company', 'like', '%' . $search . '%')
            ->orWhere('customer_email', 'like', '%' . $search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $topten = Accredit::where('created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString())
            ->selectRaw('*, COUNT(user_id) AS created')
            ->groupBy('user_id')
            ->orderBy(DB::raw('COUNT(user_id)'), 'DESC')
            ->limit(10);

        return view('accredit.index', compact("accredits", "search", "topten"));
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
        // $request->validate([
        //     'customer_company' => ['required', 'max:255'],
        //     'customer_email' => ['required', 'email'],
        //     'customer_name' => ['required', 'max:127'],
        //     'customer_id' => ['required', 'alpha_dash', 'max:127'],
        //     'pin' => ['required', 'max:255'],
        //     'machine' => ['max:127'],
        //     'duration' => ['required', 'integer'],
        //     'language' => ['required', 'max:2'],
        //     'level' => ['required', 'integer', 'between:1,7'],
        //     'format' => ['max:127'],
        //     'display_type' => ['required', 'max:5'],
        // ]);

        $token = Str::uuid()->toString();

        $machine = $request->machine ?? 'all';
        $machine = str_replace(' ', '', $machine);

        $accredit = Accredit::create([
            'user_id' => Auth::user()->id,
            'customer_company' => $request->customer_company,
            'customer_email' => $request->customer_email,
            'customer_name' => $request->customer_name,
            'customer_id' => $request->customer_id,
            'pin' => $request->pin,
            'machine' => $machine,
            'format' => $request->format ?? 'all',
            'duration' => $request->duration,
            'language' => $request->language,
            'level' => $request->level,
            'display_type' => $request->display_type,

            'token' => $token,
        ]);

        $status = 'Accredito inviato correttamente.';
        $accredit->refresh();

        Mail::to($request->get('customer_email'))->send(new AccreditCreated($accredit));

        return to_route('accredit.index')->with('status');
    }

    /**
     * Display the specified resource.
     */
    public function show($token)
    {
        $accredit = Accredit::where('token', $token)->first();
        if (!$accredit) {
            abort(404);
        }

        return view('accredit.show', compact('accredit'));
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
        // Cancello il file
        $filename = public_path('accredits/') . $accredit->token;
        if (file_exists($filename)) {
            unlink($filename);
        }

        // Cancello l'accredito
        $accredit->delete();

        return to_route('accredit.index')->with('status', 'Accredito eliminato correttamente.');
    }

    /**
     * Download the specified resource.
     *
     * @param  \App\Models\Accredit  $accredit
     * @return \Illuminate\Http\Response
     */
    public function get($token)
    {
        $accredit = Accredit::where('token', $token)->first();
        if (!$accredit) {
            abort(404);
        }

        // Se l'accredito non esiste, lo genero
        $filename = public_path('accredits/') . $accredit->token;
        if (!file_exists($filename)) {
            $cmd_str = 'python3 ' . resource_path('python') . "/accreditgen.py -username \"" . $accredit->customer_name . "\"" .
                " -id " . $accredit->customer_id . " -pin " . $accredit->pin . " -dest_dir \"" . public_path('accredits/') . "\"" .
                " -token " .  $accredit->token . " -machine \"" . $accredit->machine . "\" -level " . $accredit->level .
                " -duration " . $accredit->duration . " -type " . $accredit->display_type;

            Log::debug($cmd_str);

            // Creo il file da scaricare
            system($cmd_str, $retval);

            if ($retval != 0) {
                abort(403, 'Accredit generation error (retval: ' . $retval . ').');
            }
        }

        $accredit->downloaded_at = now();
        $accredit->save();

        $file_path = public_path() . "/accredits/" . $token;

        return Response::download($file_path, "mg_accredit.zip", [
            'Content-Length: ' . filesize($file_path)
        ]);
    }

    public function download($token)
    {
        $accredit = Accredit::where('token', $token)->first();
        if (!$accredit) {
            abort(404);
        }

        return view('accredit.download', compact('accredit'));
    }


    public function resend($token)
    {
        $accredit = Accredit::where('token', $token)->first();
        if (!$accredit) {
            abort(404);
        }

        Mail::to($accredit->customer_email)
            ->send(new AccreditCreated($accredit));

        return redirect()->route('accredit.index')->with('status', 'Email inviata correttamente.');
    }

    public function tutorial(Request $request, $type)
    {
        if ($type == 'ed1') {
            return view('accredit.tutorial_ed1',);
        } elseif ($type == 'ed2') {
            return view('accredit.tutorial_ed2',);
        }

        abort(404);
    }

}
