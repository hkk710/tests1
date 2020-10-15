<?php

namespace App\Http\Controllers;

use App\Advance;
use App\Bill;
use App\BillIndividual;
use App\Vazhipad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Bill as BillResource;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    public function create(Request $request)
    {
        foreach ($request->bills as $b) {
            $vazhipad = Vazhipad::find($b['vazhipad_id']);

            if ($vazhipad->daily_count != 0) {
                $count = BillIndividual::where('vazhipad_id', $vazhipad->id)
                    ->where('vazhipad_date', $b['vazhipad_date'] ?? Carbon::now()->format('y-m-d'))->count();

                if ($count >= $vazhipad->daily_count)
                    return [
                        'status' => 'error',
                        'message' => "Daily limit of Vazhipad {$vazhipad->name} has exceeded ({$count})"
                    ];
            }
        }

        $bill = Bill::create([
            'bill_id' => Bill::calculateBillId(),
            'total' => $request->total,
            'balance' => $request->balance,
            'advance' => $request->advance,
            'payment_method' => $request->payment_method,
            'counter' => $request->counter,
            'account_head' => $request->account_head,
            'user_id' => $request->user_id,
            'address' => $request->address,
            'phone' => $request->phone,
            'place' => $request->place,
            'reference' => $request->reference
        ]);

        $bill->advances()->create($request->only(['advance', 'balance']));

        foreach ($request->bills as $b) {
            if (empty($b['vazhipad_date'])) {
                $b['vazhipad_date'] = Carbon::now();
            }
            $bill->billIndividuals()->create($b);
        }

        return [
            'id' => $bill->id,
            'status' => 'success',
        ];
    }

    public function update(Bill $bill, Request $request)
    {
        $bill->update([
            'payment_method' => $request->payment_method,
            'account_head' => $request->account_head,
            'address' => $request->address ?? $bill->address,
            'phone' => $request->phone ?? $bill->phone,
            'place' => $request->place ?? $bill->place,
            'reference' => $request->reference
        ]);

        foreach ($request->bills as $b) {
            $bil = $bill->billIndividuals()->find($b['id']);
            $bil->update([
                'perr' => $b['perr'],
                'nakshatharam_id' => $b['nakshatharam_id']
            ]);
        }

        return [
            'id' => $bill->id,
            'status' => 'success',
        ];
    }

    public function last() {
        return [
            'bill_id' => Bill::latest()->first()->bill_id
        ];
    }

    public function search(Request $request) {
        $bill = Bill::where('bill_id', $request->bill_id)->with([
            'billIndividuals', 'billIndividuals.vazhipad', 'billIndividuals.nakshatharam', 'billIndividuals.prathishtta'
        ])->first();

        if ($bill === null) return [
            'status' => 'notfound'
        ];

        return new BillResource($bill);
    }

    public function delete(Request $request) {
        Bill::where('bill_id', $request->bill_id)->update([
            'cancelled' => true
        ]);

        return [
            'status' => 'successfully deleted'
        ];
    }

    public function totalIncome() {
        return [
            'sum' => Bill::where('created_at', '>=', Carbon::today())->sum('advance')
        ];
    }

    public function show(Bill $bill) {
        $bills = $bill->billIndividuals()
            ->with(['vazhipad', 'nakshatharam', 'prathishtta', 'bill.user'])
            ->get()
            ->groupBy(['vazhipad_id', 'prathishtta_id',' samayam'])
            ->map(function($item) {
                return $item->map(function ($i) {
                    return $i->map(function ($row) {
                        return $row->map(function ($vd) {
                            $vd->vazhipad_date = Carbon::parse($vd->vazhipad_date)->format('d/m/Y');
                            return $vd;
                        });
                    })->values();
                })->values();
            })->values();

        $duplicate = $bill->duplicate;
        $bill->update([
            'duplicate' => true
        ]);

        return [
            'date' => $bill->created_at->format('d/m/Y'),
            'bill_id' => $bill->bill_id,
            'bills' => $bills,
            'duplicate' => $duplicate
        ];
    }

    public function advance(Bill $bill, Request $request) {
        if ($request->advance > $bill->balance)
            return [ 'status' => 'failed' ];

        $advance = $bill->advance + $request->advance;
        $bill->update([
            'advance' => $advance,
            'balance' => $bill->total - $advance
        ]);

        $bill->advances()->create([
            'advance' => $request->advance,
            'balance' => $bill->total - $advance
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function deleteAdvance(Request $request) {
        $advance = Advance::find($request->advance);

        if (!$advance) return [ 'status' => 'failed' ];

        $ad = $advance->bill->advance - $advance->advance;
        $advance->bill->update([
            'advance' => $ad,
            'balance' => $advance->bill->total - $ad
        ]);
        $advance->update([ 'cancelled' => true ]);

        $advances = $advance->bill->advances()->where('cancelled', false)->get();
        $count = $advance->bill->total;
        foreach ($advances as $a) {
            $a->update([
                'balance' => $count = $count - $a->advance
            ]);
        }

        return [ 'status' => 'success' ];
    }
}
