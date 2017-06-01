<?php

namespace App\Observers;

use App\Slug;
use App\Edition;
use App\Notifications\AnswerEditionCreated;

class EditionObserver
{
    function creating(Edition $edition)
    {
        switch ($edition->editable_type) {
            case 'answer':
                $answer = $edition->editable;
                $edition->status = $edition->user->id == $answer->user->id ? 'accepted' : 'pending';

                break;

            default:
                $edition->status = 'accepted';

                break;
        }
    }

    function created(Edition $edition) {
        switch ($edition->editable_type) {
            case 'question':
                $question    = $edition->editable;
                $language    = $edition->language;
                $slug        = $question->slugs()->inLanguage($language)->first();


                if (is_null($slug)) {
                    $slug = new Slug;
                    $slug->question()->associate($question);
                    $slug->language()->associate($language);
                }

                $slug->text = str_slug($edition->text);
                $slug->save();

                break;

            case 'answer':
                $answer = $edition->editable;

                if ($edition->user->id != $answer->user->id) {
                    $answer->user->notify(new AnswerEditionCreated($edition));
                }

                break;
        }
    }

    function saved(Edition $edition)
    {
        if ($edition->status == 'accepted') {
            $edition->editable->touch();
        }
    }
}
