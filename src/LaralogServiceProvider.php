<?php

namespace Vinarth\Laralog;

use Illuminate\Support\ServiceProvider;

class LaralogServiceProvider extends ServiceProvider
{
	public function boot(ValidationFactory $validationFactory, ConfigRepository $configRepository): void {

	}
}