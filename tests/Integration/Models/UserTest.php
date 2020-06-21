<?php

namespace Tests\Integration\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\Utils\Models\User;
use V1narth\Versionable\Support\Utils\Models\Log;

class UserTest extends TestCase
{
	use RefreshDatabase;

	public function testCanInsertRecordsIntoTestDB(): void
	{
		factory(User::class, 2)->create();

		$this->assertCount(2, DB::table('users')->get());
	}

	public function testRefreshesDB(): void
	{
		$this->assertCount(0, DB::table('users')->get());
	}

	public function testVersionEntryOnCreate() {
		$user = factory(User::class)->create();

		$this->assertCount(1, Log::getVersions($user)->get());
	}
}