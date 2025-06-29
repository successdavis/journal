<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Receipt;
use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($user_id, $publication_id, $receipt_id)
    {
        $user = User::findOrFail($user_id);
        $publication = Publication::findOrFail($publication_id);
        $receipt = Receipt::findOrFail($receipt_id);

        return inertia::render('Reader/Receipt', [
            'receipt' => $receipt,
            'user' => $user,
            'publication' => $publication,
        ]);
    }


    public function showReceipts($user_id)
    {
        $user = User::findOrFail($user_id);
        $receipts = Receipt::with(['publication', 'user'])
            ->where('user_id', $user->id)
            ->get();

        return inertia::render('Reader/viewReceipts', [
            'receipts' => $receipts,
        ]);
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
    public function store($user_id, $publication_id)
    {
        $user = User::findOrFail($user_id);
        $publication = Publication::findOrFail($publication_id);

        $existing = Receipt::where('user_id', $user_id)
            ->where('publication_id', $publication_id)
            ->first();
//dd($existing);
        $receipt = $existing ?? Receipt::create([
            'user_id' => $user_id,
            'publication_id' => $publication_id,
            'amount' => $publication->amount,
            'currency' => 'NGN',
            'receipt_no' => 'RCPT-' . strtoupper(Str::random(10)),
            'reference' => Str::uuid(),
            'status' => 'pending',
        ]);

        return response()->json([
            'receipt' => $receipt,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceiptRequest $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        //
    }
}
