<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userticket;
use App\Models\Payment;


class PaymentController extends Controller
{
    public function allPayments()
    {
        $payments = Userticket::with(['users', 'ticket.event', 'payment'])->orderByDesc('purchase_date')->get();
        return view('payment', compact('payments')); 
    }
    public function showCommissionSummary()
    {
        $usertickets = Userticket::with(['payment'])->get();

        $totalCommission = $usertickets->sum(function ($ticket) {
            return optional($ticket->payment)->amount * 0.10;
        });

        return view('admin.commission-summary', [
            'usertickets' => $usertickets,
            'totalCommission' => $totalCommission
        ]);
    }

}

