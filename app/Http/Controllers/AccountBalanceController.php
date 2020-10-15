<?php

namespace App\Http\Controllers;

use App\AccountBalance;
use App\Asset;
use App\Bank;
use App\Bill;
use App\Cash;
use App\Expense;
use App\Liability;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountBalanceController extends Controller
{
    // assets
    public function assets(Request $request)
    {
        Asset::create([
            'name' => $request->name,
            'opening_balance' => $request->opening_balance,
            'date' => $request->date
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function updateAssets(Asset $asset, Request $request)
    {
        $asset->update([
            'opening_balance' => $request->opening_balance,
            'date' => $request->date
        ]);

        return [
            'status' => 'success'
        ];
    }

    // liabilities
    public function liabilities(Request $request)
    {
        Liability::create([
            'name' => $request->name,
            'opening_balance' => $request->opening_balance,
            'date' => $request->date
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function updateLiabilities(Liability $liability, Request $request)
    {
        $liability->update([
            'opening_balance' => $request->opening_balance,
            'date' => $request->date
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function getData()
    {
        return [
            'assets' => Asset::all(),
            'liabilities' => Liability::all()
        ];
    }

    public function transfer(Request $request)
    {
        Bank::create([
            'amount' => $request->amount * ($request->to == 'cash' ? -1 : 1),
            'date' => $request->date,
            'narration' => $request->narration
        ]);

        Cash::create([
            'amount' => $request->amount * ($request->to == 'bank' ? -1 : 1),
            'date' => $request->date,
            'narration' => $request->narration
        ]);

        return [
            'status' => 'success'
        ];
    }
}