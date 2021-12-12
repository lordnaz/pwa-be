<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'internal_trx', 
        'mmp_trx', 
        'status', 
        'code',
        'message',
        'created_at', 
        'updated_at'
    ]; 
 
}
