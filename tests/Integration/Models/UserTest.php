<?php

namespace Tests\Integration\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\Utils\Models\User;

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

		$this->assertEquals(1, $user->revisionsCount());
	}

	public function testVersionEntryOnUpdate() {
		$user = factory(User::class)->create();

		$user->update([
			'name' => 'Updated name'
		]);

		$this->assertEquals(2, $user->revisionsCount());
	}

	public function testCanRevertToPreviousVersion() {
		$user = factory(User::class)->create();

		$updatedUser = User::query()->find($user->id);

		/** @var User $updatedUser */
		$updatedUser->update([
			'name' => 'Updated name'
		]);

		$updatedUser->revertVersion();

		$this->assertTrue($updatedUser->name === $user->name);
	}
}