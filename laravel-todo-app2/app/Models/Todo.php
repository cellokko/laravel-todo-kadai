<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function goal() {
        return $this->belongsTo(Goal::class);
    }

    // 中間テーブルにはタイムスタンプが自動的に保存されないため、末尾につなげている
    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
