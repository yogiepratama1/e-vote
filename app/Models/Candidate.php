<?php

namespace App\Models;

use App\Models\Active;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $dates = ['start', 'end'];

    public function active()
    {
        return $this->belongsTo(Active::class, 'active_id');
    }
}
