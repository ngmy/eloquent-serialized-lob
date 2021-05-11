<?php

declare(strict_types=1);

namespace Ngmy\EloquentSerializedLob;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\ServiceProvider;
use JMS\Serializer\SerializerBuilder;
use Ngmy\EloquentSerializedLob\Serializers\JsonSerializer;
use Ngmy\EloquentSerializedLob\Serializers\XmlSerializer;

class EloquentSerializedLobServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        AnnotationRegistry::registerLoader('class_exists');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind(JsonSerializer::class, function () {
            $serializer = SerializerBuilder::create()->build();
            return new JsonSerializer($serializer);
        });
        $this->app->bind(XmlSerializer::class, function () {
            $serializer = SerializerBuilder::create()->build();
            return new XmlSerializer($serializer);
        });
    }
}
