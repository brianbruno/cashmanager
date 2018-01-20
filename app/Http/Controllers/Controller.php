<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $mensagens = array(
        "AtualizacaoSucesso" => 'Preferências atualizadas com sucesso.',
        "AtualizacaoErro"    => 'Erro ao atualizar registro.',
        "CriadoSucesso"      => 'Criado com sucesso.',
        "CriadoErro"         => 'Erro ao criar registro.',
        "LimiteMaximo"       => 'Limite máximo atingido',
        "NaoExcluirPrincipal"=> 'Não é possível fechar a conta principal. Vá em configurações e altere.',
        "NaoExcluirPadrao"   => 'Não é possível fechar a Conta Padrão.'
    );

    /**
     * Display the specified resource.
     *
     * @param String $returnType
     * @param array $array
     * @param String $view
     * @return \Illuminate\Http\Response
     */
    public function resposta($array, $returnType, $view = 'home'){
        if($returnType == 'json')
            return response()->json($array);
        else
            return view($view, $array);

    }
}
