<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\Payment;


class PaymentController extends Controller
{
    public function allPayments()
    {
        $data = $this->getCommissionSummary();
        return view('payment', $data);
    }
    public function showCommissionSummary()
    {
        // Get all payments
        $data = $this->getCommissionSummary();

        return view('admin.commission-summary', $data);
    }
    private function getCommissionSummary()
    {
        $payments = Payment::with(['users', 'ticket.event'])->orderByDesc('payment_date')->get();
        $payments->each(function ($payment) {
            $payment->commission = $payment->total * 0.10;
        });
        $totalPayments = $payments->sum('total');
        $totalCommission = $totalPayments * 0.10;

        return compact('payments', 'totalPayments', 'totalCommission');
    }

}

