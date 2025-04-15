<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // define quuais campos podem ser preenchidos em massa
  protected $fillable = ['name', 'description', 'price'];
}
