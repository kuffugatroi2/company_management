<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'full_name', 'gender', 'birthdate',
        'phone_number', 'address', 'company_id', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'person';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
