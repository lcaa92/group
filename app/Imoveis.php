<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imoveis extends Model
{
    protected $fillable = [
        'codigo','titulo', 'tipo', 'cep', 'cidade', 'estado', 'bairro', 'numero', 'complemento', 'preco', 'area', 'qnt_dormitorios', 'qnt_suites', 'banheiros', 'salas', 'garagem', 'descricao', 'imagem'
    ];

    public $rules = [
		'titulo' => 'required|max:255|min:3',
		'tipo' => 'required|in:Apartamento,Casa',
		'cep' => 'required|max:20|min:3',
		'cidade' => 'required|max:100|min:3',
		'estado' => 'required|max:100',
		'bairro' => 'required|max:100',
		'numero' => 'required|integer',
		'preco' => 'required|between:0,1200000000.00',
		'area' => 'required|integer',
		'qnt_dormitorios' => 'required|integer',
		'qnt_suites' => 'required|integer',
		'banheiros' => 'required|integer',
		'salas' => 'required|integer',
		'garagem' => 'required|integer',
		'descricao' => 'required|max:1000',
		'imagem'=> 'nullable|mimes:jpeg,bmp,png,jpg',
    ];

    public function setPrecoAttribute($value)
    {
    	$source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $value);
        $this->attributes['preco'] = $valor;
    }

    public function exibePreco($value){
    	return number_format($value,2,',','.');
    }

    public function fotos()
    {
        return $this->hasMany('App\Fotos', 'id_imovel');
    }
}
