<?php

namespace V1narth\Versionable;

use Illuminate\Database\Eloquent\Model;
use V1narth\Versionable\Support\Utils\Models\Log;
use V1narth\Versionable\Support\Versionable;

/**
 * Trait VersionableTrait
 *
 * @package V1narth\Versionable
 */
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

	public function versions() {
		/** @var Model $this */
		return Log::getVersions($this);
	}

	public function revisions() {
		/** @var Model $this */
		return Log::getRevisions($this);
	}

	public function revisionsCount() {
		return $this->revisions()->count();
	}

	public function revertVersion($columns = []) {
		/** @var Model $this */
		return Log::revert($this, $columns);
	}
}