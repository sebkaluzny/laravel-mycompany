<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateVueEntity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vueentity {name : The name of the entity.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * @var Filesystem
     */
    private $files;

    private $composer;

    private $meta;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = app()['composer'];
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->meta = (new NameParser)->parse($this->argument('name'));
//        $this->makeMigration();
//        $this->makeModel();
    }

    private function makeEntity()
    {

    }
}
