<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Bank;
use App\Cash;
use App\Asset;
use App\Expense;
use Carbon\Carbon;
use App\BillIndividual;
use App\ExpenseIndividual;
use App\Liability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function trial_balance(Request $request)
    {
        $cash = $bank = 0;
        $methods = ['cash', 'bank'];

        foreach ($methods as $method) {
            $assetsCash = Asset::where('name', $method)->first()->opening_balance;
            $income = Bill::where('payment_method', $method)
                ->where('created_at', '<', $request->from_date . ' 00:00:00')
                ->sum('advance');
            $expense = Expense::where('payment_method', $method)
                ->where('created_at', '<', $request->from_date . ' 00:00:00')
                ->sum('total');

            $$method = $assetsCash + $income - $expense;
        }

        $assets = Asset::whereNotIn('name', $methods)->get();
        $assets_total = Asset::whereNotIn('name', $methods)->sum('opening_balance');

        $liabilities = Liability::all();
        $liabilities_total = Liability::sum('opening_balance');

        $bills = $this->bills($request)
            ->join('vazhipads', 'vazhipads.id', '=', 'bill_individuals.vazhipad_id')
            ->groupBy('vazhipadcattegory_id')
            ->select([
                'vazhipadcattegory_id',
                DB::raw("(select name from vazhipadcattegories where id = vazhipadcattegory_id) as name"),
                DB::raw('SUM(ennam * thuka) AS total'),
            ])->get();

        $expenses = $this->expenses($request)
            ->join('expense_sub_heads', 'expense_sub_heads.id', '=', 'expense_individuals.expense_sub_head_id')
            ->groupBy('expense_head_id')
            ->select([
                'expense_head_id',
                DB::raw("(select name from expense_heads where id = expense_head_id) as name"),
                DB::raw('SUM(alav * vila) AS total')
            ])->get();


        $expenses_total = $this->expenses($request)
            ->sum(DB::raw('alav * vila'));

        $bills_total = $this->bills($request)
            ->sum(DB::raw('ennam * thuka'));

        $debit = $cash + $bank + $assets_total + $expenses_total;
        $credit = $liabilities_total + $bills_total;

        return [
            'bills' => $bills,
            'expenses' => $expenses,
            'assets' => $assets,
            'liabilities' => $liabilities,
            'cash' => $cash,
            'bank' => $bank,
            'debit' =>$debit,
            'credit' => $credit,
        ];
    }

    public function income_expenditure(Request $request)
    {
        $bills = $this->bills($request)
            ->join('vazhipads', 'vazhipads.id', '=', 'bill_individuals.vazhipad_id')
            ->groupBy('vazhipadcattegory_id')
            ->select([
                'vazhipadcattegory_id',
                DB::raw("(select name_en from vazhipadcattegories where id = vazhipadcattegory_id) as name_en"),
                DB::raw('SUM(ennam * thuka) AS total'),
            ])->get();

        $expenses = $this->expenses($request)
            ->join('expense_sub_heads', 'expense_sub_heads.id', '=', 'expense_individuals.expense_sub_head_id')
            ->groupBy('expense_head_id')
            ->select([
                'expense_head_id',
                DB::raw("(select name from expense_heads where id = expense_head_id) as name"),
                DB::raw('SUM(alav * vila) AS total')
            ])->get();

        return [
            'bills' => $bills,
            'expenses' => $expenses,
        ];
    }

    public function balance_sheet(Request $request)
    {
        $cash = $bank = 0;
        $methods = ['cash', 'bank'];

        foreach ($methods as $method) {
            $assetsCash = Asset::where('name', $method)->first()->opening_balance;
            $income = Bill::where('payment_method', $method)
                ->where('created_at', '<', $request->from_date . ' 00:00:00')
                ->sum('advance');
            $expense = Expense::where('payment_method', $method)
                ->where('created_at', '<', $request->from_date . ' 00:00:00')
                ->sum('total');

            $$method = $assetsCash + $income - $expense;
        }

        $assets = Asset::whereNotIn('name', $methods)->get();
        $assets_total = Asset::whereNotIn('name', $methods)->sum('opening_balance');

        $liabilities = Liability::all();
        $liabilities_total = Liability::sum('opening_balance');

        return [
            'assets' => $assets,
            'liabilities' => $liabilities,
            'cash' => $cash,
            'bank' => $bank,
            'total' => [
                'assets' => $cash + $bank + $assets_total,
                'liabilities' => $liabilities_total
            ]
        ];
    }

    private function bills(Request $request)
    {
        return BillIndividual::where('bill_individuals.created_at', '>=', $request->from_date . ' 00:00:00')
            ->where('bill_individuals.created_at', '<=', $request->to_date . ' 23:59:59')
            ->when($request->name, function ($query) use ($request) {
                return $query->where('perr', 'LIKE', '%' . $request->name . '%');
            })
            ->when($request->prathishtta_id, function ($query) use ($request) {
                return $query->where('prathishtta_id', $request->prathishtta_id);
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->whereHas('vazhipad', function ($q) use ($request) {
                    $q->where('vazhipadcattegory_id', $request->category_id);
                });
            })
            ->when($request->vazhipad_id, function ($query) use ($request) {
                return $query->where('vazhipad_id', $request->vazhipad_id);
            });
    }

    private function expenses(Request $request)
    {
        return ExpenseIndividual::where('expense_individuals.created_at', '>=', $request->from_date . ' 00:00:00')
            ->where('expense_individuals.created_at', '<=', $request->to_date . ' 23:59:59')
            ->whereHas('expense', function ($query) {
                $query->where('cancelled', 0);
            })
            ->when($request->method, function ($query) use ($request) {
                $query->whereHas('expense', function ($q) use ($request) {
                    $q->whereIn('payment_method', explode(',', $request->method));
                });
            })
            ->when($request->expense_head, function ($query) use ($request) {
                $query->whereHas('expenseSubHead', function ($q) use ($request) {
                    $q->where('expense_head_id', $request->expense_head);
                });
            })
            ->when($request->sub_head, function ($query) use ($request) {
                $query->where('expense_sub_head_id', $request->sub_head);
            });
    }
}
