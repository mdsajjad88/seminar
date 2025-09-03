<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeminarRegistration extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'mobile',
        'diseases',
        'address',
        'age',
        'comment',
        'invoice_number',
        'trx_id',
        'status',
    ];
}
