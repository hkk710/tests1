<?php

namespace App\Http\Controllers;

use App\Bill;
use App\User;
use App\Asset;
use App\Expense;
use App\Vazhipad;
use Carbon\Carbon;
use App\Prathishtta;
use App\ExpenseHead;
use App\BillIndividual;
use App\AccountBalance;
use App\ExpenseSubHead;
use App\Vazhipadcattegory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\VazhipadCategory;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Vazhipad as VazhipadResource;
use App\Http\Resources\ExpenseHead as ExpenseHeadResource;
use App\Http\Resources\Prathishtta as PrathishttaResource;
use App\Http\Resources\ExpenseSubHead as ExpenseSubHeadResource;

class AdminController extends Controller
{
    public function dashboard() {
        $today = Carbon::today();
        $from = Carbon::createFromDate($today->year, $today->month)->startOfMonth();
        $to = Carbon::createFromDate($today->year, $today->month)->endOfMonth();

        $total = $this->billsBetween($from, $to)->sum('advance');
        $expense = $this->expensesBetween($from, $to)->sum('total');

        $opening_balance = Bill::where('created_at', '<', Carbon::parse($from->format('Y-m-d'))->startOfDay())
            ->where('cancelled', false)->sum('advance'); // bills
        $opening_balance -= Expense::where('date', '<', $from->format('Y-m-d'))
            ->where('cancelled', false)->sum('total'); // expenses

        // $opening_balance = AccountBalance::where('date', '<', $from->format('Y-m-d'))->sum('amount');
        $opening_balance += Asset::whereIn('name', ['cash', 'bank'])->sum('opening_balance');
    
        $data = collect([]);

        while ($from->lte($to)) {
            $data->push([
                'total' => $this->billsBetween(
                        $from->startOfDay()->format('Y-m-d H:i:s'), $from->endOfDay()->format('Y-m-d H:i:s')
                    )->sum('advance'),
                'expense' => $this->expensesBetween(
                        $from->startOfDay()->format('Y-m-d H:i:s'), $from->endOfDay()->format('Y-m-d H:i:s')
                    )->sum('total'),
                'day' => $from->format('d'),
            ]);
                    $from->addDays();
        }

        return [
            'total' => $total,
            'expense' => $expense,
            'opening_balance' => $opening_balance,
            'closing_balance' => $opening_balance + $total - $expense,
            'data' => $data
        ];
    }

    private function billsBetween($from, $to) {
        return Bill::where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->where('cancelled', false);
    }

    private function expensesBetween($from, $to) {
        return Expense::where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->where('cancelled', false);
    }

    // vazhipad category
    public function newVazhipadCategory(Request $request)
    {
        $vazhipadcattegory = Vazhipadcattegory::create($request->only('name'));

        return new VazhipadCategory($vazhipadcattegory);
    }

    public function updateVazhipadCategory(Vazhipadcattegory $vazhipadcattegory, Request $request)
    {
        $vazhipadcattegory->update([
            'name' => $request->name
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function deleteVazhipadCategory(Vazhipadcattegory $vazhipadcattegory)
    {
        $vazhipadcattegory->delete();

        return [
            'status' => 'success'
        ];
    }

    // vazhipad
    public function newVazhipad(Request $request) 
    {
        $vazhipad = Vazhipad::create($request->all());

        return new VazhipadResource($vazhipad);
    }

    public function updateVazhipad(Vazhipad $vazhipad, Request $request)
    {
        $vazhipad->update($request->all());

        return [
            'status' => 'success',
            'category' => $vazhipad->vazhipadcattegory->name
        ];
    }

    public function deleteVazhipad(Vazhipad $vazhipad) 
    {
        $vazhipad->delete();

        return [
            'status' => 'success'
        ];
    }

    // prathishtta
    public function newPrathishtta(Request $request)
    {
        $prathishtta = Prathishtta::create($request->only('name'));

        return new PrathishttaResource($prathishtta);
    }

    public function updatePrathishtta(Prathishtta $prathishtta, Request $request)
    {
        $prathishtta->update([
            'name' => $request->name
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function deletePrathishtta(Prathishtta $prathishtta)
    {
        $prathishtta->delete();

        return [
            'status' => 'success'
        ];
    }

    // allocation
    public function newAllocation(Request $request)
    {
        DB::table('prathishtta_vazhipad')->insert([
            'prathishtta_id' => $request->prathishtta_id,
            'vazhipad_id' => $request->vazhipad_id
        ]);

        return (array) DB::table('prathishtta_vazhipad')
            ->join('prathishttas', 'prathishttas.id',  '=', 'prathishtta_vazhipad.prathishtta_id')
            ->join('vazhipads', 'vazhipads.id', '=', 'prathishtta_vazhipad.vazhipad_id')
            ->select([
                'prathishtta_vazhipad.id as id', 'prathishtta_id', 'vazhipad_id', 'vazhipads.name as vazhipad', 'prathishttas.name as prathishtta'
            ])->orderBy('id', 'desc')->first();
    }

    public function deleteAllocation($id)
    {
        $allocation = DB::table('prathishtta_vazhipad')->delete($id);

        return [
            'status' => 'success'
        ];
    }

    // expenses head
    public function newExpenseHead(Request $request)
    {
        $ExpenseHead = ExpenseHead::create($request->only('name'));

        return new ExpenseHeadResource($ExpenseHead);
    }

    public function updateExpenseHead(ExpenseHead $expenseHead, Request $request)
    {
        $expenseHead->update([
            'name' => $request->name
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function deleteExpenseHead(ExpenseHead $expenseHead)
    {
        $expenseHead->delete();

        return [
            'status' => 'success'
        ];
    }

    // sub head
    public function newExpenseSubHead(Request $request)
    {
        $expenseSubHead = ExpenseSubHead::create(
            $request->only(['name', 'code', 'expense_head_id'])
        );

        return new ExpenseSubHeadResource($expenseSubHead);
    }

    public function updateExpenseSubHead(ExpenseSubHead $expenseSubHead, Request $request)
    {
        $expenseSubHead->update(
            $request->only(['name', 'code', 'expense_head_id'])
        );

        return [
            'status' => 'success'
        ];
    }

    public function deleteExpenseSubHead(ExpenseSubHead $expenseSubHead)
    {
        $expenseSubHead->delete();

        return [
            'status' => 'success'
        ];
    }

    // users
    public function newUser(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'designation' => $request->designation
        ]);

        return new UserResource($user);
    }

    public function updateUser(User $user, Request $request)
    {
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'designation' => $request->designation
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return [
            'status' => 'success'
        ];
    }

    // booking status
    public function booking(Request $request)
    {
        $start = Carbon::createFromDate($request->year, $request->month)->startOfMonth();
        $end = Carbon::createFromDate($request->year, $request->month)->endOfMonth();

        $bills = BillIndividual::where('vazhipad_date', '>=', $start->format('Y-m-d'))
            ->where('vazhipad_date', '<=', $end->format('Y-m-d'))
            ->where('vazhipad_id', $request->vazhipad_id)
            ->get()
            ->groupBy(['vazhipad_date' => function ($row) {
                return Carbon::parse($row->vazhipad_date)->format('j');
            }]);

        return $bills;
    }
}