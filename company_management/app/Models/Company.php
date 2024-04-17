<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    const ACTIVE = 'active';
    const UNACTIVE = 'unactive';
    const ARRAYSTATUS = [
        Company::ACTIVE,
        Company::UNACTIVE,
    ];

    protected $fillable = [
        'code', 'name', 'address', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'company';
}
