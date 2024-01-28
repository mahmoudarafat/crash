<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function create()
    {
        return view('bills.create');
    }

    public function store(Request $request)
    {
        // return ($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        $bill = Bill::create([
            'title' => $request->input('title'),
        ]);

        foreach ($request->input('items') as $itemData) {
            $bill->items()->create($itemData);
        }

        return redirect()->route('bills.create')->with('success', 'Bill created successfully.');
    }
}
