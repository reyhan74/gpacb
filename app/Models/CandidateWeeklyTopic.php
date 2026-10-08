<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['week_number', 'activity_date', 'title', 'description', 'is_active'])]
class CandidateWeeklyTopic extends Model
{
    protected $table = 'candidate_weekly_topics';

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'is_active' => 'boolean',
        ];
    }
}
