<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    //
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'status', 'user_id'];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
