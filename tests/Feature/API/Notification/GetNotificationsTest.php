<?php

namespace Tests\Feature\API\Notification;

use App\Vote;
use App\Answer;
use App\Edition;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GetNotificationsTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_a_notification()
    {
        factory(Edition::class)->states('answer')->create();
        $answer = Answer::first();
        $answer->votes()->save(factory(Vote::class)->make());
        $user = $answer->user;

        $notification = $user->notifications()->first();

        $response = $this
            ->actingAs($user, 'api')
            ->json('GET', '/api/notifications/'. $notification->id);

        $response
            ->assertStatus(200)
            ->assertJson($notification->toArray());
    }
}
