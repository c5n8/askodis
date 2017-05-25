<?php

namespace Tests\Feature\API\Notification;

use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GetNotificationsTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_a_notification()
    {
        $user = factory(Vote::class)
            ->states('answer')
            ->create()
            ->votable
            ->user;

        $notification = $user->notifications()->first();

        $response = $this
            ->actingAs($user, 'api')
            ->json('GET', '/api/notifications/'. $notification->id);

        $response
            ->assertStatus(200)
            ->assertJson($notification->toArray());
    }
}
