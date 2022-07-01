<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'description',
        'discount'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function scopeFilter($query, array $filters){
        if($filters['search'] ?? false ){
            $query->where('code', 'like', '%' . request('search') . '%')
                ->orWhere('discount', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%');


        }
    }
}
