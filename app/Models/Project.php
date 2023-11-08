<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [ 'title','description','start_datetime','end_datetime','estimated_time','created_by' ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
