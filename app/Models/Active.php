<?php

namespace App\Models;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Active extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
