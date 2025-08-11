<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
     public function checkout(Request $request)
{
    $user = Auth::user()->id;
    $subscriptionType = $request->Typepayment;

    $events = Event::where('user_id', $user)->get();
    $eventNpaid = $events->where('paid', '=', 0);

    $cardio = $eventNpaid->where('TypeSeance', 'cardio');
    $prixcardio = $cardio->count() * 5000;
    $musculation = $eventNpaid->where('TypeSeance', '=', 'musculation');
    $prixmusculation = $musculation->count() * 6000;
    $yoga = $eventNpaid->where('TypeSeance', '=', 'yoga');
    $prixyoga = $yoga->count() * 4000;
    $crossfit = $eventNpaid->where('TypeSeance', '=', 'crossfit');
    $prixcrossfit = $crossfit->count() * 7000;

    Stripe::setApiKey(config('stripe.sk'));

    if ($subscriptionType === 'subscription') {
        
        $priceId = config('stripe.monthly_price_id'); 

        $session = Session::create([
            'mode' => 'subscription',
            'line_items' => [
                [
                    'price' => $priceId,
                    'quantity' => 1,
                ]
            ],
            'success_url' => route('dashboard'),
            'cancel_url' => route('dashboard'),
        ]);
    } else {
        // Mode paiement à l'unité (one_time)
        $totalAmount = $prixcardio + $prixmusculation + $prixyoga + $prixcrossfit;

        

        $session = Session::create([
            'mode' => 'payment',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Paiement des séances',
                        ],
                        'unit_amount' => $totalAmount,
                    ],
                    'quantity' => 1,
                ],
            ],
            'success_url' => route('dashboard'),
            'cancel_url' => route('dashboard'),
        ]);
    }

    return redirect()->away($session->url);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
