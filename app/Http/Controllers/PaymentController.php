<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */



    public function initiate($receipt_id, $user_id)
    {
        $receipt = Receipt::findOrFail($receipt_id);
        $user = User::findOrFail($user_id);

        if ($receipt->status !== 'pending' || $receipt->status !== 'failed' ) {
            $receipt->update([
                'reference' => (string) Str::uuid(),
                'status' => 'pending',
            ]);
        }

        $response = Http::withToken(config('services.paystack.secret'))
            ->post(config('services.paystack.payment_url') . '/transaction/initialize', [
                'email' => $user->email,
                'amount' => $receipt->amount * 100,
                'reference' => $receipt->reference,
                'callback_url' => route('paystack.callback'),
            ]);



        $data = $response->json();

        if (!$response->successful() || empty($data['data']['authorization_url'])) {
            return response()->json(['error' => 'Failed to initiate payment'], 500);
        }

        return response()->json([
            'url' => $data['data']['authorization_url']
        ]);
    }




    public function handleCallBack(Request $request)
    {
        $reference = $request->query('reference');


        $response = Http::withToken(config('services.paystack.secret'))
            ->get(config('services.paystack.payment_url') . '/transaction/verify/' . $reference);

        $data = $response->json();

//        dd($data);
        if ($data['status'] && $data['data']['status'] === 'success') {
            $receipt = Receipt::where('reference', $reference)->first();

            if ($receipt && $receipt->status !== 'successful') {
                $receipt->update([
                    'status' => 'successful',
                    'paid_at' => now(),
                    'payment_method' => $data['data']['channel'],
                    'metadata' => $data['data'],
                ]);
            }
        }


        return redirect()->route('reader.receipt.view', [
            'user_id' => $receipt->user_id,
            'publication_id' => $receipt->publication_id,
            'receipt_id' => $receipt->id,
        ])->with('success', 'Payment successful!');



    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
