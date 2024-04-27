<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'project_id', 'person_id', 'start_time', 'end_time', 'priority',
        'name', 'description', 'status', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'task';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
