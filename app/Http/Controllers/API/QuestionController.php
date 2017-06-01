<?php

namespace App\Http\Controllers\API;

use App\Detail;
use App\Edition;
use App\Language;
use App\Question;
use App\Slug;
use App\Tag;
use App\Vote;

class QuestionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api')->only(['store']);
    }

    function store()
    {
        $this->validate(request(), [
            'body' => 'required|string|unique_question|not_reserved|max:160',
            'detail' => 'string|nullable|max:480',
            'tags' => 'array|max:5',
            'topics.*' => 'string',
            'language' => 'required|exists:languages,code',
        ]);

        $language = Language::where('code', request('language'))->first();

        $question = Question::create();

        $edition = new Edition;
        $edition->text = request('body');
        $edition->language()->associate($language);
        $edition->user()->associate(auth()->user());
        $edition->editable()->associate($question);
        $edition->save();

        if (request()->has('detail')) {
            $detail = $question->detail()->save(new Detail);

            $edition = new Edition;
            $edition->text = request('detail');
            $edition->language()->associate($language);
            $edition->user()->associate(auth()->user());
            $edition->editable()->associate($detail);
            $edition->save();
        }

        $existingTags = Tag::whereHas('editions', function ($query) use ($language) {
                $query
                    ->inLanguage($language)
                    ->whereIn('text', request('tags'));
            })
            ->with('editions')
            ->get();

        $newTags = collect(request('tags'))->diff($existingTags->pluck('editions.0.text'));

        $tags = collect($existingTags);

        foreach ($newTags as $tagText) {
            $tag = Tag::create();

            $edition = new Edition;
            $edition->text = $tagText;
            $edition->language()->associate($language);
            $edition->user()->associate(auth()->user());
            $edition->editable()->associate($tag);
            $edition->save();

            $tags->push($tag);
        }

        $question->tags()->sync($tags->pluck('id'));

        $vote = new Vote;
        $vote->votable()->associate($question);
        $vote->user()->associate(auth()->user());
        $vote->save();

        return $question->slugs()->inLanguage($language)->first();
    }

    function show(Slug $slug)
    {
        return $slug;
    }
}
