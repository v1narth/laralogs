<?php

namespace V1narth\Versionable\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use V1narth\Versionable\Support\Contracts\Versionable as IVersionable;
use V1narth\Versionable\Support\Utils\Models\Log;

class Versionable implements IVersionable
{
	/**
	 * TODO:
	 *
	 * @return Versionable
	 */
	public static function init(): Contracts\Versionable {
		$model = config('versionable.base_class');

		return new $model();
	}

	/**
	 * TODO:
	 *
	 * @return string
	 */
	public function tableName(): string {
		return config('versionable.table', 'logs');
	}

	public function saving(Model $model)
	{

	}

	public function saved(Model $model)
	{
		$versionableType = get_class($model);
		$primaryKeyValue = $model->getKey();
		$groupId = $this->getGroupId();

		$dirty = Arr::except($model->getDirty(), $model->excludeColumns);

		foreach ($dirty as $column => $value) {
			Log::query()->create([
				'versionable_type' => $versionableType,
				'versionable_id' => $primaryKeyValue,
				'column' => $column,
				'current' => $value,
				'previous' => $this->getPreviousState($versionableType, $primaryKeyValue, $column),
				'group_id' => $groupId,
				'action' => $model->wasRecentlyCreated ? 'created' : 'updated'
			]);
		}

	}

	/**
	 * TODO:
	 *
	 * @param string $versionableType
	 * @param string $primaryKeyValue
	 * @param string $column
	 * @return string|null
	 */
	private function getPreviousState(string $versionableType, string $primaryKeyValue, string $column): ?string {
		$latest = Log::query()->where([
			'versionable_type' => $versionableType,
			'versionable_id' => $primaryKeyValue,
			'column' => $column
		])->latest()->first();

		if ( $latest ) {
			return $latest->current;
		}

		return null;
	}

	/**
	 * @return int
	 */
	private function getGroupId(): int {
		return (Log::query()
			->select('group_id')
			->orderByDesc('group_id')
			->first()
			->group_id ?? 0) + 1;
	}
}