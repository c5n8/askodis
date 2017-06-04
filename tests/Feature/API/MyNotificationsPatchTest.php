<?php

namespace Tests\Feature\API;

use App\Answer;
use App\Edition;
use App\Notifications\AnswerEditionCreated;
use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MyNotificationsPatchTest extends TestCase
{
    use DatabaseMigrations;

    function test_my_notifications_patch()
    {
        $answer = factory(Answer::class)->create();
        $edition = $answer->editions()->save(factory(Edition::class)->make());
        $user = $answer->user;
        $user->notify(new AnswerEditionCreated($edition));

        $response = $this
            ->actingAs($user, 'api')
            ->json('PATCH', '/api/my/notifications');

        $response->assertStatus(204);
    }
}
