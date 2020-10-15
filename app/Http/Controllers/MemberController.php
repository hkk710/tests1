<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Resources\Member as MemberResource;

class MemberController extends Controller
{
    public function members(Request $request)
    {
        $query = Member::when($request->key_word, function ($query) use ($request) {
            $value = '%' . $request->key_word . '%';
            $query->where('name', 'LIKE', $value)
                ->orWhere('address', 'LIKE', $value)
                ->orWhere('street', 'LIKE', $value)
                ->orWhere('place', 'LIKE', $value)
                ->orWhere('phone', 'LIKE', $value);
        });

        if ($request->paginate)
            $members = $query->paginate($request->paginate);
        else
            $members = $query->get();

        return MemberResource::collection($members);
    }

    public function create(Request $request)
    {
        $member = Member::create([
            'name' => $request->name,
            'address' => $request->address,
            'street' => $request->street,
            'place' => $request->place,
            'phone' => $request->phone,
            'email' => $request->email,
            'amount' => $request->amount
        ]);

        return new MemberResource($member);
    }

    public function update(Member $member, Request $request)
    {
        $member->update([
            'name' => $request->name,
            'address' => $request->address,
            'street' => $request->street,
            'place' => $request->place,
            'phone' => $request->phone,
            'email' => $request->email,
            'amount' => $request->amount
        ]);

        return [
            'status' => 'success'
        ];
    }

    public function delete(Member $member)
    {
        $member->delete();

        return [
            'status' => 'success'
        ];
    }
}
