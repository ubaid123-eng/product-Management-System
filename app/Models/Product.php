<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = TABLE_PRODUCTS;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stockquantity'
    ];

    public static function checkProductName($name, $id)
    {
        return Product::where('name', $name)->where('id', '!=', $id)->exists();
    }


    


}
