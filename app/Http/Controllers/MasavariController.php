<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Masavari;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MasavariController extends Controller
{
    public function index()
    {
        return Masavari::orderBy('id', 'desc')
            ->with(['member'])
            ->paginate(10);
    }

    public function create(Request $request)
    {
        $member = Member::find($request->member_id);
        $masavaries = $member-> masavaris();

        $lastRecord = $masavaries->orderBy('id', 'desc')->first();
        $lastRecordOn = Carbon::parse(optional($lastRecord)->date ?? $member->created_at)->startOfMonth();
        $hasPayment = $masavaries->where('date', $lastRecordOn->format('m/y'))->sum('amount');

        $amount = $request->amount;
        $pending = $member->amount - $hasPayment;

        $bill = Bill::create([
            'advance' => $amount,
            'total' => $amount,
            'balance' => 0,
            'payment_method' => 'cash',
            'account_head' => 'daily',
            'bill_id' => Bill::calculateBillId(),
            'counter' => $request->counter,
            'user_id' => $request->user_id,
        ]);

        if ($pending != 0) {
            $amountTemp = $amount > $pending ? $pending : $amount;
            $masavaries->create([
                'date' => $lastRecordOn->format('m/y'),
                'amount' => $amountTemp,
                'bill_id' => $bill->id
            ]);
            $bill->billIndividuals()->create([
                'vazhipad_id' => 1,
                'perr' => $member->name,
                'nakshatharam_id' => 28,
                'prathishtta_id' => 1,
                'thuka' => $amountTemp,
                'vazhipad_date' => Carbon::now(),
                'samayam' => 0,
                'ennam' => 1
            ]);
            $amount -= $amountTemp;
        }

        while ($amount > 0) {
            $lastRecordOn->addMonth();

            $pending = $member->amount - $masavaries->where('date', $lastRecordOn->format('m/y'))->sum('amount');
            $amountTemp = $amount > $pending ? $pending : $amount;
            $masavaries->create([
                'date' => $lastRecordOn->format('m/y'),
                'amount' => $amountTemp,
                'bill_id' => $bill->id
            ]);
            $bill->billIndividuals()->create([
                'vazhipad_id' => 1,
                'perr' => $member->name,
                'nakshatharam_id' => 28,
                'prathishtta_id' => 1,
                'thuka' => $amountTemp,
                'vazhipad_date' => Carbon::now(),
                'samayam' => 0,
                'ennam' => 1
            ]);
            $amount -= $amountTemp;
        }

        return [
            'id' => $bill->id,
            'status' => 'success'
        ];
    }

    public function update(Masavari $masavari, Request $request)
    {
        $originalAmount = $masavari->amount;
        $masavari->update([ 'amount' => $request->amount ]);

        $amount = $masavari->bill->total - $request->amount;
        $masavari->bill->update([
            'total' => $amount,
            'advance' => $amount
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function delete(Masavari $masavari)
    {
        if ($masavari->bill->masavaris->count() == 1)
            $masavari->bill->delete();
        else {
            $amount = $masavari->bill->total - $masavari->amount;
            $masavari->bill->update([
                'total' => $amount,
                'advance' => $amount
            ]);
            $masavari->delete();
        }

        return [
            'status' => 'success'
        ];
    }
}
