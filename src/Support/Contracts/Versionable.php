<?php

namespace V1narth\Versionable\Support\Contracts;


use Illuminate\Database\Eloquent\Model;

interface Versionable
{
	public static function init(): self;

	public function saving(Model $model);
	public function saved(Model $model);
}