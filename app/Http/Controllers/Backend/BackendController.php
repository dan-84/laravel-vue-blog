<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackendController extends Controller
{
    /**
     * Show admin home.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('backend.home');
    }

    protected function redirectResponse(Request $request, $message, $type = 'success')
    {
        if ($request->wantsJson()) {
            return response()->json([
                'status'  => $type,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with("flash_{$type}", $message);
    }
}
