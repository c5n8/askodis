<?php

namespace App\Http\Controllers\API;

use App\Tag;
use App\Slug;
use App\Answer;
use App\Detail;
use App\Edition;
use App\Language;
use Illuminate\Validation\Rule;

class QuestionEditionController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    function store(Slug $slug)
    {
        $question = $slug->question;
        $language = Language::where('code', request('language'))->first();

        $this->authorize('create', [Edition::class, $question, $language]);

        $this->validate(request(), [
            'body' => 'required|string|unique_question|not_reserved',
            'detail' => 'string|nullable',
            'tags' => 'array|max:5',
            'tags.*.id' => [
                'exists:tags,id',
                Rule::exists('taggables', 'tag_id')->where(function ($query) use ($question) {
                    $query
                        ->where('taggable_id', $question->id)
                        ->where('taggable_type', 'question');
                }),
            ],
            'tags.*.body' => 'string|max:25',
            'language' => 'required|exists:languages,code',
        ]);

        $edition = new Edition();
        $edition->text = request('body');
        $edition->language()->associate($language);
        $edition->user()->associate(auth()->user());
        $edition->editable()->associate($question);
        $edition->save();

        if (request()->has('detail')) {
            if ($question->hasDetail) {
                $detail = $question->detail;
            } else {
                $detail = $question->detail()->save(new Detail);
            }

            $edition = new Edition;
            $edition->text = request('detail');
            $edition->language()->associate($language);
            $edition->user()->associate(auth()->user());
            $edition->editable()->associate($detail);
            $edition->save();
        }

        $tags = Tag::whereIn('id', collect(request('tags'))->pluck('id'))->get();

        foreach ($tags as $tag) {
            if ($tag->editions()->inLanguage($language)->exists()) {
                continue;
            }

            $requestTag = collect(request('tags'))->first(function ($requestTag) use ($tag) {
                return $requestTag['id'] == $tag->id;
            });

            $edition = new Edition;
            $edition->text = $requestTag['body'];
            $edition->language()->associate($language);
            $edition->user()->associate(auth()->user());
            $edition->editable()->associate($tag);
            $edition->save();
        }

        // dd($question->slugs()->inLanguage($language)->first()->toArray());

        return $question->slugs()->inLanguage($language)->first();
    }
}
