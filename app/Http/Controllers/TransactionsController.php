<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    
    public function index()
    {
        $transactions = WalletTransaction::with([
            'wallet.walletable',
            'fromWallet.walletable',
            'toWallet.walletable',
            'donationCase',
        ])
        ->filter(request()->only('search'))
        ->latest()
        ->paginate(15);            

        return view('admin.transactions.index', compact('transactions'));
    }

    
}
