<?php

namespace App\Providers;

use App\Repositories\Element\ElementInterface;
use App\Repositories\Element\ElementPricingInterface;
use App\Repositories\Element\ElementPricingRepository;
use App\Repositories\Element\ElementRepository;
use App\Repositories\Element\ElementTaskInterface;
use App\Repositories\Element\ElementTaskRepository;
use App\Repositories\File\FileInterface;
use App\Repositories\File\FileRepository;
use App\Repositories\GoodsReceived\GoodsReceivedInterface;
use App\Repositories\GoodsReceived\GoodsReceivedRepository;
use App\Repositories\Project\ProjectInterface;
use App\Repositories\Project\ProjectRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GoodsReceivedInterface::class, GoodsReceivedRepository::class);
        $this->app->bind(ElementInterface::class, ElementRepository::class);
        $this->app->bind(FileInterface::class, FileRepository::class);
        $this->app->bind(ElementTaskInterface::class, ElementTaskRepository::class);
        $this->app->bind(ProjectInterface::class, ProjectRepository::class);
        $this->app->bind(ElementPricingInterface::class, ElementPricingRepository::class);
    }
}
