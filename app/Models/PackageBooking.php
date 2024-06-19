<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'package_wedding_id',
        'user_id',
        'quantity',
        'wedding_date',
        'total_amount',
        'is_paid',
        'proof',
        'package_bank_id',
        'sub_total',
        'tax',
        'insurance',
    ];

    protected $casts =[
        'wedding_date' =>'date',
    ];

    public function customer(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function wedding(){
        return $this->belongsTo(PackageWedding::class,'package_wedding_id');
    }
    public function bank(){
        return $this->belongsTo(PackageBank::class, 'package_bank_id');
    }
}
