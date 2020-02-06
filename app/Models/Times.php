<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Times extends Model
{
    public $table = 'times';

    protected $fillable = [
        'user_id',
        'total_time_worked',
        'hours_left',
        'total_breaks'
    ];


    public function user() {
        return $this->belongsTo('App\Models\Users', 'user_id');
    }
}
