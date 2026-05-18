<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['mosque_id','name','email','amount','message','stripe_session_id'];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
