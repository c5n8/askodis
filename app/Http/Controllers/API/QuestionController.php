<?php

namespace App\Http\Controllers\API;

use App\Language;
use App\Slug as Question;
use App\Tag;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api')->only(['store']);
    }

    function store()
    {
        $this->validate(request(), [
            'body' => 'required|string|unique_question|not_reserved',
            'detail' => 'string|nullable',
            'tags' => 'array|max:5',
            'topics.*' => 'string',
            'language' => 'required|exists:languages,code',
        ]);

        $language = Language::where('code', request('language'))->first();

        $question = \App\Question::create();

        $translation = $question->translations()->make();
        $translation->translatable()->associate($question);
        $translation->language()->associate($language);
        $translation->save();

        $edition = $translation->editions()->make();
        $edition->text = request('body');
        $edition->translation()->associate($translation);
        $edition->save();

        if (request()->has('detail')) {
            $detail = $question->detail()->make();
            $detail->question()->associate($question);
            $detail->save();

            $translation = $detail->translations()->make();
            $translation->translatable()->associate($detail);
            $translation->language()->associate($language);
            $translation->save();

            $edition = $translation->editions()->make();
            $edition->text = request('detail');
            $edition->translation()->associate($translation);
            $edition->save();
        }

        $existingTags = Tag::whereHas('translations', function ($query) use ($language) {
                $query
                    ->inLanguage($language)
                    ->whereHas('editions', function ($query) {
                        $query->whereIn('text', request('tags'));
                    });
            })
            ->with('translations.editions')
            ->get();

        $newTags = collect(request('tags'))->diff($existingTags->pluck('translations.0.editions.0.text'));

        $tags = collect($existingTags);

        foreach ($newTags as $tagText) {
            $tag = Tag::create();

            $translation = $tag->translations()->make();
            $translation->translatable()->associate($tag);
            $translation->language()->associate($language);
            $translation->save();

            $edition = $translation->editions()->make();
            $edition->text = $tagText;
            $edition->translation()->associate($translation);
            $edition->save();

            $tags->push($tag);
        }

        $question->tags()->sync($tags->pluck('id'));

        return $question->slugs()->inLanguage($language)->first();
    }

    function show(Question $question)
    {
        return $question;
    }
}
