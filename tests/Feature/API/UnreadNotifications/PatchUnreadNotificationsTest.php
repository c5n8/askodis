<?php

namespace Tests\Feature\API\Notification;

use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PatchUnreadNotificationTest extends TestCase
{
    use DatabaseMigrations;

    function test_patch_unread_notification()
    {
        $user = factory(Vote::class)
            ->states('answer')
            ->create()
            ->votable
            ->user;

        $response = $this
            ->actingAs($user, 'api')
            ->json('PATCH', '/api/unread_notifications');

        $response->assertStatus(204);
    }
}
