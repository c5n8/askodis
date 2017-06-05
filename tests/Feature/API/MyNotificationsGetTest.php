<?php

namespace Tests\Feature\API;

use App\Answer;
use App\Edition;
use App\Notifications\AnswerEditionCreated;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MyNotificationsGetTest extends TestCase
{
    use DatabaseMigrations;

    function test_my_notifications_get()
    {
        $answer = factory(Answer::class)->create();
        $edition = $answer->editions()->save(factory(Edition::class)->make());
        $user = $answer->user;
        $user->notify(new AnswerEditionCreated($edition));

        $response = $this
            ->actingAs($user, 'api')
            ->json('GET', '/api/my/notifications');

        $response
            ->assertStatus(200)
            ->assertJson($user->notifications->toArray());
    }
}
