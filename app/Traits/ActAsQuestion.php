<?php

namespace App\Traits;

use App\Models\Question;

trait ActAsQuestion
{
    public function getSlugAttribute()
    {
        return $this->text;
    }

    public function getBodyAttribute()
    {
        return $this
            ->question
            ->editions()
            ->inLanguage($this->language)
            ->accepted()
            ->latest()
            ->first()
            ->text;
    }

    public function getHasDetailAttribute()
    {
        if (! $this->question->hasDetail) {
            return false;
        }

        return $this
            ->question
            ->detail
            ->editions()
            ->inLanguage($this->language)
            ->accepted()
            ->exists();
    }

    public function getDetailAttribute()
    {
        if (! $this->hasDetail) {
            return null;
        }

        return $this
            ->question
            ->detail
            ->editions()
            ->inLanguage($this->language)
            ->accepted()
            ->latest()
            ->first()
            ->text;
    }

    public function getVotesCountAttribute()
    {
        return $this->question->votesCount;
    }

    public function getHasVoteFromCurrentUserAttribute()
    {
        return $this->question->hasVoteFromCurrentUser;
    }

    public function getVoteFromCurrentUserAttribute()
    {
        return $this->question->voteFromCurrentUser;
    }

    public function getAnswersCountAttribute()
    {
        return $this
            ->question
            ->answers()
            ->hasEditionInLanguage($this->language)
            ->count();
    }

    public function getAnswersAttribute()
    {
        return $this
            ->question
            ->answers()
            ->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->hasEditionInLanguage($this->language)
            ->limit(5)
            ->get()
            ->transform(function ($answer) {
                return collect([
                    'id' => $answer->id,
                    'body' => $answer
                        ->editions()
                        ->inLanguage($this->language)
                        ->accepted()
                        ->latest()
                        ->first()
                        ->text,
                    'updatedAt' => $answer->updated_at->toDateTimeString(),
                    'votesCount' => $answer->votesCount,
                    'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
                    'voteFromCurrentUser' => $answer->voteFromCurrentUser,
                    'user' => $answer->user,
                    'shareUrl' => urlencode(url($this->slug.'#'.'answer-'.$answer->id)),
                ]);
            });
    }

    public function getTagsAttribute()
    {
        return $this
            ->question
            ->tags()
            ->hasEditionInLanguage($this->language)
            ->get()
            ->transform(function ($tag) {
                return collect([
                    'id' => $tag->id,
                    'body' => $tag
                        ->editions()
                        ->inLanguage($this->language)
                        ->accepted()
                        ->latest()
                        ->first()
                        ->text,
                ]);
            });
    }

    public function getHasTagsAttribute()
    {
        return $this->question->hasTags;
    }

    public function getHasAnswerFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return false;
        }

        return $this
            ->question
            ->answers()
            ->from(auth('api')->user())
            ->hasEditionInLanguage($this->language)
            ->exists();
    }

    public function getAnswerFromCurrentUserAttribute()
    {
        if (auth('api')->guest()) {
            return;
        }

        if (! $this->hasAnswerFromCurrentUser) {
            return;
        }

        $answer = $this
            ->question
            ->answers()
            ->from(auth('api')->user())
            ->hasEditionInLanguage($this->language)
            ->first();

        return collect([
            'id' => $answer->id,
            'body' => $answer
                ->editions()
                ->inLanguage($this->language)
                ->accepted()
                ->latest()
                ->first()
                ->text,
            'updatedAt' => $answer->updated_at->toDateTimeString(),
            'votesCount' => $answer->votesCount,
            'hasVoteFromCurrentUser' => $answer->hasVoteFromCurrentUser,
            'user' => $answer->user,
            'shareUrl' => urlencode(url($this->slug.'#'.'answer-'.$answer->id)),
        ]);
    }

    public function getShareUrlAttribute()
    {
        return urlencode(url($this->slug));
    }

    public function getRelatedQuestionsAttribute($value = '')
    {
        return Question::where('id', '<>', $this->question->id)
            ->hasEditionInLanguage($this->language)
            ->whereHas('tags', function ($query) {
                $query->whereIn('tag_id', $this->tags->pluck('id'));
            })
            ->with([
                'editions' => function ($query) {
                    $query
                        ->inLanguage($this->language)
                        ->accepted()
                        ->latest();
                },
                'tags' => function ($query) {
                    $query->whereIn('tag_id', $this->tags->pluck('id'));
                },
                'slugs' => function ($query) {
                    $query->inLanguage($this->language);
                },
            ])
            ->paginate(5)
            ->sortByDesc(function ($question) {
                return $question->tags->count();
            })
            ->transform(function ($question) {
                return [
                    'text' => $question->editions->first()->text,
                    'url' => url($question->slugs->first()->text),
                ];
            })
            ->values();
    }
}
