<?php

namespace V1narth\Versionable;

use V1narth\Versionable\Support\Versionable;

trait VersionableTrait
{
	public static function bootVersionableTrait() {
		$versionable = Versionable::init();

		static::saving(function($model) use ($versionable) {
			$versionable->saving($model);
		});

		static::saved(function($model) use ($versionable) {
			$versionable->saved($model);
		});
	}
}