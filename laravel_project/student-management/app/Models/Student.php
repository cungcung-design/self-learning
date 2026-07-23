<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $primaryKey = 'id';

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'date_of_birth', 'is_enrolled'];

    public $timestamps = true;
    use HasFactory;
}
