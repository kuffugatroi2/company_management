<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'role', 'description', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'role';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
