<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fotos extends Model
{
    protected $fillable = [
        'id_imovel', 'principal', 'imagem'
    ];

    public $rules = [
		'principal' => 'required|integer|nullable',
		'id_imovel' => 'required|integer',
		'imagem'=> 'nullable|mimes:jpeg,bmp,png,jpg',
    ];
}
