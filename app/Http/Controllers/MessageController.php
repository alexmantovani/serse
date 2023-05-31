<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Message;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::whereDate('updated_at', Carbon::today())
            ->orderBy('updated_at')
            ->paginate(50);
        $orderBy = '';
        return view('message.index', compact('messages', 'orderBy'));
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
    public function store(StoreMessageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }

    public function hash(Request $request, $matricola)
    {
        $message = Message::where('serial_number', $matricola)
        ->where('file', $request->file)
        ->first();

        if (($message) && ($message->hash === $request->hash)) {
            // Nulla è cambiato
            return response([
                'return code' => 0,
                'return text' => 'Unchanged',
            ]);
        }

        $serialNumber = SerialNumber::firstOrCreate(['name' => $matricola]);

        // L'hash è cambiato
        $message = Message::updateOrCreate([
            'serial_number' => $matricola,
            'file' => $request->file,
        ], [
            'hash' => $request->hash,
        ]);

        // TODO: Notifico a chi interessa
        //

        return response([
            'return code' => 0,
            'return text' => $serialNumber,
        ]);
    }
}
