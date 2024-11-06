<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'test:email';
    protected $description = 'Send a test email';

    public function handle()
    {
        \Mail::raw('Teste de email', function ($message) {
            $message->to('nkiblo.gm@gmail.com')
                    ->subject('Assunto do Teste');
        });
        

        $this->info('Test email sent!');
    }
}

