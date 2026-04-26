<?php

namespace App\Http\Controllers;

use App\Models\DonationCase;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index()
    {

        $cases = DonationCase::where('status', 'active');
        $cases->when(request('type'), function ($query) {
            $query->where('type', request('type'));
        });

        $stats = [
            'transactions_count' => WalletTransaction::count(),
            'completed_cases'    => DonationCase::where('status', 'completed')->count(),
            'active_cases'       => DonationCase::where('status', 'active')->count(),
        ];

        return view('home.index', [
            'cases' => $cases->latest()->get(),
            'stats' => $stats,
        ]);
    }

    public function show(DonationCase $case)
    {
        return view('home.show', compact('case'));
    }
}
