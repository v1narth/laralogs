<?php

namespace Tests\Utils\Models;

use Illuminate\Database\Eloquent\Model;
use V1narth\Versionable\VersionableTrait;

class User extends Model
{
	use VersionableTrait;
}