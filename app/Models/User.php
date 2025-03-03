<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'tbl_user';

    // Columns in the table
    protected $fillable = [
        'username', 'password', 'gender'
    ];

    public $timestamps = false;
    protected $primarykey = 'userid';
}
