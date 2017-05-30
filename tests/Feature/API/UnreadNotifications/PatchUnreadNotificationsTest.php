<?php

namespace Tests\Feature\API\Notification;

use App\Vote;
use App\Answer;
use App\Edition;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PatchUnreadNotificationTest extends TestCase
{
    use DatabaseMigrations;

    function test_patch_unread_notification()
    {
        factory(Edition::class)->states('answer')->create();
        $answer = Answer::first();
        $answer->votes()->save(factory(Vote::class)->make());
        $user = $answer->user;

        $response = $this
            ->actingAs($user, 'api')
            ->json('PATCH', '/api/unread_notifications');

        $response->assertStatus(204);
    }
}
