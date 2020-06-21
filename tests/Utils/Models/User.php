<?php

namespace Tests\Utils\Models;

use Illuminate\Database\Eloquent\Model;
use V1narth\Versionable\VersionableTrait;

class User extends Model
{
	use VersionableTrait;

	protected $guarded = [];

	/**
	 * Exclude column from being versioned.
	 *
	 * @var string[]
	 */
	public $excludeColumns = [
		'id', 'password', 'created_at', 'updated_at'
	];
}