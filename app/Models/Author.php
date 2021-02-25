<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ['dob']; //parse dates as carbon dates

    //parse date into carbon object
    public function setDobAttribute($dob){
        $this->attributes['dob'] = Carbon::parse($dob);
    }
}
