<?php

namespace V1narth\Versionable\Support;

use Illuminate\Database\Eloquent\Model;
use V1narth\Versionable\Support\Contracts\Versionable;
use V1narth\Versionable\Support\Utils\Models\Log;

abstract class BaseVersionable implements Versionable
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
		if ( $model->wasRecentlyCreated ) {
			$versionableType = get_class($model);
			$primaryKeyValue = $model->getKey();

			foreach ($model->getDirty() as $column => $value) {
				$entry = Log::query()->create([
					'versionable_type' => $versionableType,
					'versionable_id' => $primaryKeyValue,
					'column' => $column,
					'current' => $value,
					'previous' => $this->getPreviousState($versionableType, $primaryKeyValue, $column),
					'action' => 'created'
				]);
			}
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
		$previous = Log::query()->where([
			'versionable_type' => $versionableType,
			'versionable_id' => $primaryKeyValue
		])->latest()->first();

		if ( $previous ) {
			return $previous->previous;
		}

		return null;
	}
}