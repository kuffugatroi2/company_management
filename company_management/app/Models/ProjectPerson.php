<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectPerson extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'person_id', 'project_id', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'project_person';
}
