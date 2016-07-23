<?php

namespace Ngmy\EloquentSerializedLob;

use Illuminate\Support\ServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;

class SerializedLobTraitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        AnnotationRegistry::registerLoader('class_exists');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
