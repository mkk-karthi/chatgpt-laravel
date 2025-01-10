<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = "chats";
    public $timestamps = true;

    protected $fillable = ["role", "message", "chat_group_id"];
}
