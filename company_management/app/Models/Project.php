<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'description', 'company_id', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'project';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function persons()
    {
        return $this->belongsToMany(Person::class, 'project_person', 'project_id', 'person_id');
    }
}
