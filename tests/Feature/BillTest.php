<?php

use App\Models\Bill;
use App\Models\BillItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a bill with items', function () {
    $response = $this->post(route('bills.store'), [
        'title' => 'Test Bill',
        'items' => [
            ['item_name' => 'Item 1', 'amount' => 10.99],
            ['item_name' => 'Item 2', 'amount' => 20.49],
        ],
    ]);

    $response->assertRedirect(route('bills.create'));
    $response->assertSessionHas('success', 'Bill created successfully.');

    $this->assertDatabaseHas('bills', ['title' => 'Test Bill']);
    $bill = Bill::where('title', 'Test Bill')->first();

    $this->assertCount(2, $bill->items);
    $this->assertDatabaseHas('bill_items', ['item_name' => 'Item 1', 'amount' => 10.99]);
    $this->assertDatabaseHas('bill_items', ['item_name' => 'Item 2', 'amount' => 20.49]);
});
