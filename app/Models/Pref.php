<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pref extends Model
{
    use HasFactory;

    protected $fillable = ['key'];


//    public static function updateOrCreate1(string $key, mixed $value): void
//    {
//        $defaultSetting = Pref::firstOrCreate(['key' => $key]);
//        $defaultSetting->value = $value;
//        $defaultSetting->save();
//    }
}
