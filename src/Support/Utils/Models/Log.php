<?php

namespace V1narth\Versionable\Support\Utils\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
	/**
	 * Disable guard attributes.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Disable updated_at column.
	 *
	 * @var string|null
	 */
	public const UPDATED_AT = null;

	public static function getVersions(Model $versionable) {
		return self::query()->where([
			'versionable_type' => get_class($versionable),
			'versionable_id' => $versionable->getKey()
		]);
	}
}