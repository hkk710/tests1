<?php

namespace App\Http\Controllers;

use App\ExpenseHead;
use App\Expense;
use App\ExpenseIndividual;
use App\ExpenseSubHead;
use App\Http\Resources\ExpenseHead as ExpenseHeadResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Resources\Expense as ExpenseResource;
use App\Http\Resources\ExpenseSubHead as ExpenseSubHeadResource;

class ExpenseController extends Controller
{
    public function index()
    {
        return [
            'expense_heads' => ExpenseHeadResource::collection(
                ExpenseHead::all()
            ),
            'sub_heads' => ExpenseSubHeadResource::collection(
                ExpenseSubHead::all()
            )
        ];
    }

    public function create(Request $request)
    {
        $lastMonthLastRecord = Expense::where('created_at', '<', Carbon::now()->startOfMonth())
            ->orderBy('id', 'desc')->first();
        $lastRecord = Expense::latest()->first();

        $id = (optional($lastRecord)->id - optional($lastMonthLastRecord)->id + 1) . '/' . Carbon::now()->format('my');

        $expense = Expense::create([
            'expense_id' => $id,
            'total' => $request->total,
            'date' => $request->date,
            'voucher_number' => $request->voucher_number,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'tharam' => $request->tharam,
            'user_id' => $request->user_id,
            'counter' => $request->counter,
            'narration' => $request->narration,
            'account_head' => $request->account_head
        ]);

        foreach ($request->expenses as $e) {
            $expense->expenseIndividuals()->create($e);
        }
        
        return [
            'id' => $expense->id,
            'status' => 'success'
        ];
    }

    public function update(Expense $expense, Request $request)
    {
        $expense->update([
            'total' => $request->total,
            'date' => $request->date,
            'voucher_number' => $request->voucher_number,
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'tharam' => $request->tharam,
            'narration' => $request->narration,
            'account_head' => $request->account_head,
            'total' => $request->total,
        ]);

        foreach ($request->expenses as $e) {
            $exp = $expense->expenseIndividuals()->find($e['id']);
            $exp->update([
                'alav' => $e['alav'],
                'vila' => $e['vila'],
                'expense_sub_head_id' => $e['expense_sub_head_id'],
            ]);
        }

        return [
            'id' => $expense->id,
            'status' => 'success'
        ];
    }

    public function search(Request $request)
    {

        $expense = Expense::where('expense_id', $request->expense_id)->with([
            'expenseIndividuals', 'expenseIndividuals.expense'
        ])->first();

        if ($expense === null) return [
            'status' => 'notfound'
        ];

        return new ExpenseResource($expense);
    }
    

    public function totalExpense()
    {
        return [
            'sum' => Expense::where('created_at', '>=', Carbon::today())->sum('total')
        ];
    }

    public function last() {
        return [
            'expense_id' => optional(Expense::latest()->first())->expense_id
        ];
    }

    public function delete(Request $request)
    {
        Expense::where('expense_id', $request->expense_id)->update([ 'cancelled' => true ]);

        return [
            'status' => 'success'
        ];
    }
}