<?php

namespace App\Jobs;

use App\Conta;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ContasController;
use App\Admin;
use App\Notifications\DadosServidor;

class EnviarDadosServidor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contasController = new ContasController();

        $dados = $contasController->dadosServidor();

        $admin = new Admin();
        $admin->notify(new DadosServidor($dados));
    }
}
