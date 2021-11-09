<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_cart extends Model
{
    use HasFactory;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['product_id','quantity','user_id	'];

    protected $table = 'user_cart';



}
