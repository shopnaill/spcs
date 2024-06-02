<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportRequest;
use App\Events\SupportRequestReceived;

class SupportRequestController extends Controller
{
    public function receive(Request $request)
    {
        $request->validate([
            'requester_name' => 'required|string',
            'requester_device' => 'required|string',
            'message' => 'required|string',
        ]);

        $supportRequest = SupportRequest::create($request->all());

        broadcast(new SupportRequestReceived($supportRequest));

        return response()->json(['status' => 'success'], 200);
    }

    public function dashboard()
    {
        $supportRequests = SupportRequest::all();
        return view('home', compact('supportRequests'));
    }
}