<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['position', 'name', 'user_id'];

    public function tarefas()
    {
        return $this->hasMany(Tarefa::class)->orderBy('position');
    }
}
