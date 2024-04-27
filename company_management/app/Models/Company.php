<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'address', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'company';

    public function persons()
    {
        return $this->hasMany(person::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
