<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'desc',
        'id_user',
    ];
    
    public function User()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
