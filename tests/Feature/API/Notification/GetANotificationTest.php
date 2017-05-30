<?php

namespace Tests\Feature\API\Notification;

use App\Vote;
use App\Answer;
use App\Edition;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GetANotificationTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_a_notification()
    {
        factory(Edition::class)->states('answer')->create();
        $answer = Answer::first();
        $answer->votes()->save(factory(Vote::class)->make());
        $user = $answer->user;

        $response = $this
            ->actingAs($user, 'api')
            ->json('GET', '/api/notifications');

        $response
            ->assertStatus(200)
            ->assertJson($user->notifications->toArray());
    }
}
