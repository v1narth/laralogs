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
		])->latest()->first();
	}

	public static function getRevisions(Model $versionable) {
		$revisions = self::query()
			->select('group_id')
			->where([
				'versionable_type' => get_class($versionable),
				'versionable_id'   => $versionable->getKey()
			])
			->groupBy('group_id')
			->pluck('group_id');

		return $revisions->map(function ($groupId) {
			return [
				$groupId => [
					'previous' => self::query()->where('group_id', $groupId)->get()
				]
			];
		});
	}

	public static function revert(Model $versionable, array $columns) {
		$versions = self::query()
			->where('group_id',
				self::findLatestGroupId($versionable)
			)->get()->toArray();

		foreach ($versions as $version) {
			if ( $version['previous'] ) {
				$versionable->update([
					$version['column'] => $version['previous']
				]);
			}
		}

		return $versionable;

	}

	private static function findLatestGroupId($versionable): int {
		return self::query()->where([
			'versionable_type' => get_class($versionable),
			'versionable_id' => $versionable->id
		])->orderBy('group_id', 'desc')->first()->group_id ?? 0;
	}
}