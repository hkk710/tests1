<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Bill;
use App\Cash;
use App\Asset;
use App\Expense;
use Carbon\Carbon;
use App\BillIndividual;
use App\ExpenseIndividual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VivaramController extends Controller
{
    public function poornam(Request $request)
    {
        $paginate = $this->bills_poornam($request)
            ->with(['vazhipad', 'prathishtta', 'nakshatharam', 'bill'])
            ->paginate(15);

        $bills = $paginate->groupBy(['vazhipad_date', 'prathishtta_id', 'vazhipad_id'])
            ->map(function($item) {
                return ($item->map(function ($t) {
                    return $t->map->values()->values();
                }))->values();
            })->values();

         return [
             'bills' => $bills,
             'last' => $paginate->lastPage()
         ];
    }

    public function counter(Request $request)
    {
        $paginate = $this->bills($request)
            ->whereHas('bill', function ($query) {
                $query->where('cancelled', '==', 0);
            })->with(['vazhipad', 'prathishtta', 'nakshatharam', 'bill'])
            ->paginate(15);

        $bills = $paginate->groupBy(['prathishtta_id', 'vazhipad_id', function ($row) {
            return $row->created_at->format('y-m-d');
        }])
            ->map(function($item) {
                return ($item->map->values())->values();
            })->values();

        return [
            'bills' => $bills,
            'last' => $paginate->lastPage()
        ];
    }

    public function varav_daily(Request $request)
    {
        $query = $this->bills($request)
            ->whereHas('bill', function ($query) use ($request) {
                $query->where('cancelled', '==', 0);
                $query->where('payment_method', $request->method);
            })->when(Auth::user()->isAdmin(), function ($query) use ($request) {
                $query->whereHas('bill', function ($q) use ($request) {
                    $q->where('counter', $request->counter);
                });
            })->whereHas('bill', function ($query) {
                $query->where('account_head', 'daily');
            })->with(['vazhipad.vazhipadcattegory']);

        $total = $query->sum(DB::raw('ennam * thuka'));

        $paginate = $query->groupBy('vazhipad_id')
            ->select([
                'vazhipad_id',
                DB::raw('AVG(thuka) AS thuka'),
                DB::raw('SUM(CAST(ennam AS DECIMAL)) AS ennam'),
                DB::raw('SUM(ennam * thuka) AS total')
            ])
            ->paginate(15);

        $bills = $paginate->groupBy(['vazhipad.vazhipadcattegory_id'])
            ->map->values()->values();

        return [
            'bills' => $bills,
            'last' => $paginate->lastPage(),
            'total' => $total
        ];
    }

    public function advanced_booking(Request $request)
    {
        $paginate = $this->bills($request)
            ->whereHas('bill', function ($query) {
                $query->where('cancelled', '==', 0);
            })->with(['vazhipad', 'prathishtta', 'nakshatharam', 'bill'])
            ->whereColumn('vazhipad_date', '!=', DB::raw('CAST(created_at AS date)'))
            ->select([
                DB::raw('CAST(created_at AS varchar(255)) AS date'),
                'prathishtta_id', 'vazhipad_id', 'nakshatharam_id', 'perr', 'vazhipad_date'
            ])->paginate(15);

        $bills = $paginate->groupBy(['created_at', 'prathishtta_id', 'vazhipad_id'])->map(function ($item) {
            return ($item->map->values())->values();
        })->values();

        return [
            'bills' => $bills,
            'last' => $paginate->lastPage()
        ];
    }

    public function varav_poornam(Request $request)
    {
        $query = $this->bills($request)
            ->whereHas('bill', function ($query) use ($request) {
                $query->where('cancelled', '==', 0);
                $query->where('payment_method', $request->method);
            })->when(Auth::user()->isAdmin(), function ($query) use ($request) {
                $query->whereHas('bill', function ($q) use ($request) {
                    $q->where('counter', $request->counter);
                });
            })->with(['vazhipad.vazhipadcattegory']);

        $total = $query->sum(DB::raw('ennam * thuka'));

        $paginate = $query->groupBy(['vazhipad_id'])
            ->select([
                'vazhipad_id',
                DB::raw('AVG(thuka) AS thuka'),
                DB::raw('SUM(CAST(ennam AS DECIMAL)) AS ennam'),
                DB::raw('SUM(ennam * thuka) AS total')
            ])
            ->paginate(15);

        $bills = $paginate->groupBy(['vazhipad.vazhipadcattegory_id'])
            ->map->values()->values();

        return [
            'bills' => $bills,
            'last' => $paginate->lastPage(),
            'total' => $total
        ];
    }


    public function varav_sapthaham(Request $request)
    {
        $query = $this->bills($request)
            ->orderBy('vazhipad_date', 'desc')
            ->whereHas('bill', function ($query) use ($request) {
                $query->where('cancelled', '==', 0);
                $query->where('payment_method', $request->method);
            })->when(Auth::user()->isAdmin(), function ($query) use ($request) {
                $query->whereHas('bill', function ($q) use ($request) {
                    $q->where('counter', $request->counter);
                });
            })->whereHas('bill', function ($query) {
                $query->where('account_head', 'sapthaham');
            })->with(['vazhipad.vazhipadcattegory']);

        $total = $query->sum(DB::raw('ennam * thuka'));

        $paginate = $query->groupBy(['vazhipad_id'])
            ->select([
                'vazhipad_id',
                DB::raw('AVG(thuka) AS thuka'),
                DB::raw('SUM(CAST(ennam AS DECIMAL)) AS ennam'),
                DB::raw('SUM(ennam * thuka) AS total')
            ])
            ->paginate(15);

        $bills = $paginate->groupBy(['vazhipad.vazhipadcattegory_id'])
            ->map->values()->values();

        return [
            'bills' => $bills,
            'last' => $paginate->lastPage(),
            'total' => $total
        ];
    }

    public function varav_ulsavam(Request $request)
    {
        $query = $this->bills($request)
            ->orderBy('vazhipad_date', 'desc')
            ->whereHas('bill', function ($query) use ($request) {
                $query->where('cancelled', '==', 0);
                $query->where('payment_method', $request->method);
            })->when(Auth::user()->isAdmin(), function ($query) use ($request) {
                $query->whereHas('bill', function ($q) use ($request) {
                    $q->where('counter', $request->counter);
                });
            })->whereHas('bill', function ($query) {
                $query->where('account_head', 'ulsavam');
            })->with(['vazhipad.vazhipadcattegory']);

        $total = $query->sum(DB::raw('ennam * thuka'));

        $paginate = $query->groupBy(['vazhipad_id'])
            ->select([
                'vazhipad_id',
                DB::raw('AVG(thuka) AS thuka'),
                DB::raw('SUM(CAST(ennam AS DECIMAL)) AS ennam'),
                DB::raw('SUM(ennam * thuka) AS total')
            ])
            ->paginate(15);

        $bills = $paginate->groupBy(['vazhipad.vazhipadcattegory_id'])
            ->map->values()->values();

        return [
            'bills' => $bills,
            'last' => $paginate->lastPage(),
            'total' => $total
        ];
    }

    public function expense_daily(Request $request)
    {
        $query = $this->expenses($request)
            ->whereHas('expense', function ($query) use ($request) {
                $query->whereIn('payment_method', explode(',', $request->method));
                $query->where('account_head', 'daily');
            })->with(['expenseSubHead.expenseHead', 'expense'])
            ->when(Auth::user()->isAdmin(), function ($query) use ($request) {
                $query->whereHas('bill', function ($q) use ($request) {
                    $q->where('counter', $request->counter);
                });
            });

        $paginate = $query->paginate(15);
        $total = $query->sum(DB::raw('alav * vila'));

        $expenses = $paginate->groupBy(['expense.date', 'expenseSubHead.expense_head_id'])
            ->map(function($item) {
                return $item->map->values()->values();
            })->values();
        
        return [
            'expenses' => $expenses,
            'total' => $total,
            'last' => $paginate->lastPage(),
        ];
    }

    public function expense_poornam(Request $request)
    {
        $query = $this->expenses($request)
            ->whereHas('expense', function ($query) use ($request) {
                $query->whereIn('payment_method', explode(',', $request->method));
            })->with(['expenseSubHead.expenseHead', 'expense'])
            ->when(Auth::user()->isAdmin(), function ($query) use ($request) {
                $query->whereHas('bill', function ($q) use ($request) {
                    $q->where('counter', $request->counter);
                });
            });

        $paginate = $query->paginate(15);
        $total = $query->sum(DB::raw('alav * vila'));

        $expenses = $paginate->groupBy(['expense.date', 'expenseSubHead.expense_head_id'])
            ->map(function ($item) {
                return $item->map->values()->values();
            })->values();

        return [
            'expenses' => $expenses,
            'total' => $total,
            'last' => $paginate->lastPage(),
        ];
    }

    public function expense_ulsavam(Request $request)
    {
        $query = $this->expenses($request)
            ->whereHas('expense', function ($query) use ($request) {
                $query->whereIn('payment_method', explode(',', $request->method));
                $query->where('account_head', 'ulsavam');
            })->with(['expenseSubHead.expenseHead', 'expense'])
            ->when(Auth::user()->isAdmin(), function ($query) use ($request) {
                $query->whereHas('bill', function ($q) use ($request) {
                    $q->where('counter', $request->counter);
                });
            });

        $paginate = $query->paginate(15);
        $total = $query->sum(DB::raw('alav * vila'));

        $expenses = $paginate->groupBy(['expense.date', 'expenseSubHead.expense_head_id'])
            ->map(function ($item) {
                return $item->map->values()->values();
            })->values();

        return [
            'expenses' => $expenses,
            'total' => $total,
            'last' => $paginate->lastPage(),
        ];
    }

    public function expense_sapthaham(Request $request)
    {
        $query = $this->expenses($request)
            ->whereHas('expense', function ($query) use ($request) {
                $query->whereIn('payment_method', explode(',', $request->method));
                $query->where('account_head', 'sapthaham');
            })->with(['expenseSubHead.expenseHead', 'expense'])
            ->when(Auth::user()->isAdmin(), function ($query) use ($request) {
                $query->whereHas('bill', function ($q) use ($request) {
                    $q->where('counter', $request->counter);
                });
            });

        $paginate = $query->paginate(15);
        $total = $query->sum(DB::raw('alav * vila'));

        $expenses = $paginate->groupBy(['expense.date', 'expenseSubHead.expense_head_id'])
            ->map(function ($item) {
                return $item->map->values()->values();
            })->values();

        return [
            'expenses' => $expenses,
            'total' => $total,
            'last' => $paginate->lastPage(),
        ];
    }

    public function bank_statement(Request $request)
    {
         $query = $this->bills($request)
            ->whereHas('bill', function ($query) use ($request) {
                $query->where('account_head', $request->head);
                $query->where('cancelled', '==', 0);
            })->when(Auth::user()->isAdmin(), function ($query) use ($request) {
                $query->whereHas('bill', function ($q) use ($request) {
                    $q->where('counter', $request->counter);
                });
            })->whereHas('bill', function ($query) {
                $query->where('payment_method', 'bank');
            })->with(['vazhipad.vazhipadcattegory']);

        $total = $query->sum(DB::raw('ennam * thuka'));

        $paginate = $query->groupBy(['vazhipad_id'])
            ->select([
                'vazhipad_id',
                DB::raw('AVG(thuka) AS thuka'),
                DB::raw('SUM(CAST(ennam AS DECIMAL)) AS ennam'),
                DB::raw('SUM(ennam * thuka) AS total')
            ])->paginate(15);

        $bills = $paginate->groupBy(['vazhipad.vazhipadcattegory_id'])
            ->map->values()->values();

        return [
            'bills' => $bills,
            'last' => $paginate->lastPage(),
            'total' => $total
        ];

    }

    public function cancelled_statement(Request $request)
    {
        $paginate = $this->bills($request)
            ->whereHas('bill', function ($query) {
                $query->where('cancelled', '!=', 0);
            })->with(['vazhipad', 'prathishtta', 'nakshatharam', 'bill'])
            ->paginate(15);

        $bills = $paginate->groupBy(['prathishtta_id', 'vazhipad_id', function ($row) {
                return $row->created_at->format('y-m-d');
            }])->map(function($item) {
                return ($item->map->values())->values();
            })->values();

        return [
            'bills' => $bills,
            'last' => $paginate->lastPage()
        ];
    }

    public function pending(Request $request)
    {
        $bills = $this->bills($request)
            ->whereHas('bill', function ($query) {
                $query->where('balance', '!=', 0);
            })
            ->with(['vazhipad', 'bill'])
            ->select([
                DB::raw('*'),
                DB::raw('ennam * thuka AS total')
            ])
            ->paginate(15);

        return [
            'bills' => $bills->items(),
            'last' => $bills->lastPage()
        ];

    }

    public function account_daily(Request $request)
    {
        $method = explode(',', $request->method);
        $opening_balance = Asset::whereIn('name', $method)->sum('opening_balance');
        $opening_balance += Bill::where('created_at', '<', Carbon::parse($request->from_date)->startOfDay())
            ->where('cancelled', false)
            ->whereIn('payment_method', $method)
            ->where('account_head', 'daily')
            ->sum('advance');
        $opening_balance -= Expense::where('created_at', '<', Carbon::parse($request->from_date)->startOfDay())
            ->whereIn('payment_method', $method)
            ->where('account_head', 'daily')
            ->where('cancelled', false)
            ->sum('total');

        if (collect($method)->has('cash')) {
            $opening_balance += Cash::where('date', $request->from_date)->sum('amount');
        } else if (collect($method)->has('bank')) {
            $opening_balance += Bank::where('date', '=', $request->from_date)->sum('amount');
        }

        $bills = $this->bills($request)
            ->with(['vazhipad.vazhipadcattegory'])
            ->whereHas('bill', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
                $query->where('account_head', 'daily');
            })->groupBy(['vazhipad_id'])
            ->select([
                'vazhipad_id',
                DB::raw('SUM(ennam * thuka) AS total'),
            ])->get()
            ->groupBy(['vazhipad.vazhipadcattegory_id'])
            ->map->values()->values();

        $bill = $this->bills($request)
            ->whereHas('bill', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
                $query->where('account_head', 'daily');
            })->sum(DB::raw('ennam * thuka'));

        $expenses = $this->expenses($request)
            ->with(['expenseSubHead.expenseHead'])
            ->groupBy('expense_sub_head_id')
            ->select([
                'expense_sub_head_id',
                DB::raw('SUM(alav * vila) AS total')
            ])->whereHas('expense', function ($query) use ($method) {
                $query->where('account_head', 'daily');
                $query->whereIn('payment_method', $method);
            })->get()
            ->groupBy(['expense_sub_head.expense_head_id'])
            ->map->values()->values();

        $expense = $this->expenses($request)
            ->whereHas('expense', function ($query) use ($method) {
                $query->where('account_head', 'daily');
                $query->whereIn('payment_method', $method);
            })->sum(DB::raw('alav * vila'));

        return [
            'opening_balance' => $opening_balance,
            'bills' => $bills,
            'expenses' => $expenses,
            'billTotal' => $bill,
            'expenseTotal' => $expense,
            'closing_balance' => $opening_balance + $bill - $expense
        ];
    }

    public function account_poornam(Request $request)
    {
        $method = explode(',', $request->method);
        $opening_balance = Asset::whereIn('name', $method)->sum('opening_balance');
        $opening_balance += Bill::where('created_at', '<', Carbon::parse($request->from_date)->startOfDay())
            ->where('cancelled', false)
            ->whereIn('payment_method', $method)
            ->sum('advance');
        $opening_balance -= Expense::where('created_at', '<', Carbon::parse($request->from_date)->startOfDay())
            ->whereIn('payment_method', $method)
            ->where('cancelled', false)
            ->sum('total');

        if (collect($method)->has('cash')) {
            $opening_balance += Cash::where('date', $request->from_date)->sum('amount');
        } else if (collect($method)->has('bank')) {
            $opening_balance += Bank::where('date', '=', $request->from_date)->sum('amount');
        }

        $bills = $this->bills($request)
            ->with(['vazhipad.vazhipadcattegory'])
            ->whereHas('bill', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
            })->groupBy(['vazhipad_id'])
            ->select([
                'vazhipad_id',
                DB::raw('SUM(ennam * thuka) AS total'),
            ])->get()
            ->groupBy(['vazhipad.vazhipadcattegory_id'])
            ->map->values()->values();

        $bill = $this->bills($request)
            ->whereHas('bill', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
            })->sum(DB::raw('ennam * thuka'));

        $expenses = $this->expenses($request)
            ->with(['expenseSubHead.expenseHead'])
            ->groupBy('expense_sub_head_id')
            ->select([
                'expense_sub_head_id',
                DB::raw('SUM(alav * vila) AS total')
            ])->whereHas('expense', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
            })->get()
            ->groupBy(['expense_sub_head.expense_head_id'])
            ->map->values()->values();

        $expense = $this->expenses($request)
            ->whereHas('expense', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
            })->sum(DB::raw('alav * vila'));

        return [
            'opening_balance' => $opening_balance,
            'bills' => $bills,
            'expenses' => $expenses,
            'billTotal' => $bill,
            'expenseTotal' => $expense,
            'closing_balance' => $opening_balance + $bill - $expense
        ];
    }

    public function account_ulsavam(Request $request)
    {
        $method = explode(',', $request->method);
        $opening_balance = Asset::whereIn('name', $method)->sum('opening_balance');
        $opening_balance += Bill::where('created_at', '<', Carbon::parse($request->from_date)->startOfDay())
            ->where('cancelled', false)
            ->whereIn('payment_method', $method)
            ->where('account_head', 'ulsavam')
            ->sum('advance');
        $opening_balance -= Expense::where('created_at', '<', Carbon::parse($request->from_date)->startOfDay())
            ->whereIn('payment_method', $method)
            ->where('account_head', 'ulsavam')
            ->where('cancelled', false)
            ->sum('total');

        if (collect($method)->has('cash')) {
            $opening_balance += Cash::where('date', $request->from_date)->sum('amount');
        } else if (collect($method)->has('bank')) {
            $opening_balance += Bank::where('date', '=', $request->from_date)->sum('amount');
        }

        $bills = $this->bills($request)
            ->with(['vazhipad.vazhipadcattegory'])
            ->whereHas('bill', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
                $query->where('account_head', 'ulsavam');
            })->groupBy(['vazhipad_id'])
            ->select([
                'vazhipad_id',
                DB::raw('SUM(ennam * thuka) AS total'),
            ])->get()
            ->groupBy(['vazhipad.vazhipadcattegory_id'])
            ->map->values()->values();

        $bill = $this->bills($request)
            ->whereHas('bill', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
                $query->where('account_head', 'ulsavam');
            })->sum(DB::raw('ennam * thuka'));

        $expenses = $this->expenses($request)
            ->with(['expenseSubHead.expenseHead'])
            ->groupBy('expense_sub_head_id')
            ->select([
                'expense_sub_head_id',
                DB::raw('SUM(alav * vila) AS total')
            ])->whereHas('expense', function ($query) use ($method) {
                $query->where('account_head', 'ulsavam');
                $query->whereIn('payment_method', $method);
            })->get()
            ->groupBy(['expense_sub_head.expense_head_id'])
            ->map->values()->values();

        $expense = $this->expenses($request)
            ->whereHas('expense', function ($query) use ($method) {
                $query->where('account_head', 'ulsavam');
                $query->whereIn('payment_method', $method);
            })->sum(DB::raw('alav * vila'));

        return [
            'opening_balance' => $opening_balance,
            'bills' => $bills,
            'expenses' => $expenses,
            'billTotal' => $bill,
            'expenseTotal' => $expense,
            'closing_balance' => $opening_balance + $bill - $expense
        ];
    }

    public function account_sapthaham(Request $request)
    {
        $method = explode(',', $request->method);
        $opening_balance = Asset::whereIn('name', $method)->sum('opening_balance');
        $opening_balance += Bill::where('created_at', '<', Carbon::parse($request->from_date)->startOfDay())
            ->where('cancelled', false)
            ->whereIn('payment_method', $method)
            ->where('account_head', 'sapthaham')
            ->sum('advance');
        $opening_balance -= Expense::where('created_at', '<', Carbon::parse($request->from_date)->startOfDay())
            ->whereIn('payment_method', $method)
            ->where('account_head', 'sapthaham')
            ->where('cancelled', false)
            ->sum('total');

        if (collect($method)->has('cash')) {
            $opening_balance += Cash::where('date', $request->from_date)->sum('amount');
        } else if (collect($method)->has('bank')) {
            $opening_balance += Bank::where('date', '=', $request->from_date)->sum('amount');
        }

        $bills = $this->bills($request)
            ->with(['vazhipad.vazhipadcattegory'])
            ->whereHas('bill', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
                $query->where('account_head', 'sapthaham');
            })->groupBy(['vazhipad_id'])
            ->select([
                'vazhipad_id',
                DB::raw('SUM(ennam * thuka) AS total'),
            ])->get()
            ->groupBy(['vazhipad.vazhipadcattegory_id'])
            ->map->values()->values();

        $bill = $this->bills($request)
            ->whereHas('bill', function ($query) use ($method) {
                $query->whereIn('payment_method', $method);
                $query->where('account_head', 'sapthaham');
            })->sum(DB::raw('ennam * thuka'));

        $expenses = $this->expenses($request)
            ->with(['expenseSubHead.expenseHead'])
            ->groupBy('expense_sub_head_id')
            ->select([
                'expense_sub_head_id',
                DB::raw('SUM(alav * vila) AS total')
            ])->whereHas('expense', function ($query) use ($method) {
                $query->where('account_head', 'sapthaham');
                $query->whereIn('payment_method', $method);
            })->get()
            ->groupBy(['expense_sub_head.expense_head_id'])
            ->map->values()->values();

        $expense = $this->expenses($request)
            ->whereHas('expense', function ($query) use ($method) {
                $query->where('account_head', 'sapthaham');
                $query->whereIn('payment_method', $method);
            })->sum(DB::raw('alav * vila'));

        return [
            'opening_balance' => $opening_balance,
            'bills' => $bills,
            'expenses' => $expenses,
            'billTotal' => $bill,
            'expenseTotal' => $expense,
            'closing_balance' => $opening_balance + $bill - $expense
        ];
    }

    private function bills(Request $request)
    {
        return BillIndividual::where('created_at', '>=', $request->from_date . ' 00:00:00')
            ->where('created_at', '<=', $request->to_date . ' 23:59:59')
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

    private function bills_poornam(Request $request)
    {
        return BillIndividual::where('vazhipad_date', '>=', $request->from_date . ' 00:00:00')
            ->where('vazhipad_date', '<=', $request->to_date . ' 23:59:59')
            ->whereHas('bill', function ($query) {
                $query->where('cancelled', '0');
            })
            ->when($request->name, function ($query) use ($request) {
                $query->where('perr', 'LIKE', '%' . $request->name . '%');
            })
            ->when($request->prathishtta_id, function ($query) use ($request) {
                $query->where('prathishtta_id', $request->prathishtta_id);
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->whereHas('vazhipad', function ($q) use ($request) {
                    $q->where('vazhipadcattegory_id', $request->category_id);
                });
            })
            ->when($request->vazhipad_id, function ($query) use ($request) {
                $query->where('vazhipad_id', $request->vazhipad_id);
            });
    }

    private function expenses(Request $request)
    {
        return ExpenseIndividual::where('created_at', '>=', $request->from_date . ' 00:00:00')
            ->where('created_at', '<=', $request->to_date . ' 23:59:59')
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
