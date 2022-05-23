<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    

    protected $table = "tasks";
    protected $fillable = [
        'id',
        'title',
        'description',
        'priority',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
