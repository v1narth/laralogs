<?php

namespace V1narth\Versionable;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use V1narth\Versionable\Support\Versionable;

class VersionableServiceProvider extends ServiceProvider
{
	public function boot(ValidationFactory $validationFactory, ConfigRepository $configRepository): void {
		$this->publishes([
			__DIR__.'/config.php' => $this->app->configPath().'/versionable.php',
		], 'config');
	}

	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		$this->mergeConfigFrom(__DIR__ . '/config.php', 'versionable');
	}
}