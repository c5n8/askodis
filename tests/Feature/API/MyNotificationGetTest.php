<?php

namespace Tests\Feature\API;

use App\Answer;
use App\Edition;
use App\Notifications\AnswerEditionCreated;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MyNotificationGetTest extends TestCase
{
    use DatabaseMigrations;

    function test_my_notification_get()
    {
        $answer = factory(Answer::class)->create();
        $edition = $answer->editions()->save(factory(Edition::class)->make());
        $user = $answer->user;
        $user->notify(new AnswerEditionCreated($edition));
        $notification = $user->notifications()->first();

        $response = $this
            ->actingAs($user, 'api')
            ->json('GET', '/api/my/notifications/'. $notification->id);

        $response
            ->assertStatus(200)
            ->assertJson($notification->toArray());
    }
}
