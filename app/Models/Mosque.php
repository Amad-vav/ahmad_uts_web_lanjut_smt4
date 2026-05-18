<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    use HasFactory;

    protected $fillable = ['name','address','lat','lng','description','contact'];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
