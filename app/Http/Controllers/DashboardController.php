<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use App\Models\DonationCase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = WalletTransaction::with([
            'wallet.walletable',
            'donationCase'
        ])
        ->latest()
        ->take(10)
        ->get();

        // Total donated amount sum only deposit transactions tied to a donation case
        $totalDonations = WalletTransaction::whereNotNull('donation_case_id')
            ->where('type', 'deposit')
            ->sum('amount');

        // Number of unique donors: distinct wallets that initiated withdraw transactions for donations
        $donorsCount = WalletTransaction::whereNotNull('donation_case_id')
            ->where('type', 'withdraw')
            ->distinct('wallet_id')
            ->count('wallet_id');

        // Active cases count
        $activeCasesCount = DonationCase::where('status', 'active')->count();

    return view('admin.dashboard.index', compact('transactions', 'totalDonations', 'donorsCount', 'activeCasesCount'));
    }

}
