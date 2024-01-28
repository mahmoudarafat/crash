<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    use HasFactory;

    protected $fillable = ['item_name', 'amount'];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
