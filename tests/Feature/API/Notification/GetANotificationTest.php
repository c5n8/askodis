<?php

namespace Tests\Feature\API\Notification;

use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GetANotificationTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_a_notification()
    {
        $user = factory(Vote::class)->states('answer')->create()->votable->user;

        $response = $this
            ->actingAs($user, 'api')
            ->json('GET', '/api/notifications');

        $response
            ->assertStatus(200)
            ->assertJson($user->notifications->toArray());
    }
}
