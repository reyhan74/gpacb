<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['candidate_registration_id', 'topic_id', 'week_date', 'activity_type', 'material', 'activity', 'notes', 'attended', 'submitted_at'])]
class CandidateWeeklyLog extends Model
{
    protected function casts(): array
    {
        return ['week_date' => 'date', 'attended' => 'boolean', 'submitted_at' => 'datetime'];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(CandidateWeeklyTopic::class, 'topic_id');
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(CandidateRegistration::class, 'candidate_registration_id');
    }
}
