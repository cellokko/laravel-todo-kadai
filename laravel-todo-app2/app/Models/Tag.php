<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    // 中間テーブルにはタイムスタンプが自動的に保存されないため、withTimeStamps()をつなげる
    public function todos() {
        return $this->belongsToMany(Todo::class)->withTimestamps();
    }   
}