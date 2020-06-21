<?php

namespace Tests;

use V1narth\Versionable\VersionableServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->app->setBasePath(__DIR__);
		$this->artisan('migrate:fresh', [
			'--path' => 'database/migrations',
		]);

		$this->withFactories(__DIR__.'/database/factories');
	}

	protected function getPackageProviders($app): array
	{
		return [
			VersionableServiceProvider::class
		];
	}

	protected function getEnvironmentSetUp($app)
	{
		parent::getEnvironmentSetUp($app);

		$app['config']->set('database.default', 'mysql');
		$app['config']->set('database.connections.mysql', [
			'driver' => 'mysql',
			'database' => env('LIGHTHOUSE_TEST_DB_DATABASE', 'test'),
			'host' => env('LIGHTHOUSE_TEST_DB_HOST', 'mysql'),
			'username' => env('LIGHTHOUSE_TEST_DB_USERNAME', 'root'),
			'password' => env('LIGHTHOUSE_TEST_DB_PASSWORD', ''),
		]);
	}
}