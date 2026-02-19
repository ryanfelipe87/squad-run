<?php

use App\Models\LogsErrors;
use Illuminate\Support\Str;

if(!function_exists('logErro')){
    function logErro($message){
        $log = LogsErrors::create([
            'route' => Str::limit($route ?? request()->fullUrl(), 250),
            'erro' => $message,
            'user' => auth()->check() ? auth()->id() : null
        ]);

        return $log->id;
    }
}

if(!function_exists('formataCnpj')){
    function formataCnpj($cnpj){
        $cnpj = preg_replace('/\D/', '', $cnpj);
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
    }
}
