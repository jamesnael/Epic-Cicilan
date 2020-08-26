<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetLaravelOptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'option:default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set default value for laravel options';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("Start set default value for options.");

        $bar = $this->output->createProgressBar(2);

        $bar->setFormat('debug');

        $bar->start();

        option(['pph_21' => '0']);

        $bar->advance();
        usleep(300000);

        option(['pph_23' => '0']);

        $bar->advance();
        usleep(300000);

        option(['sp1_date' => 14]);

        $bar->advance();
        usleep(300000);

        option(['sp2_date' => 21]);

        $bar->advance();
        usleep(300000);

        option(['sp3_date' => 28]);

        $bar->advance();
        usleep(300000);

        $bar->finish();

        $this->info("\nSet default value success.");
    }
}
