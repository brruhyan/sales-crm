<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Leads;
use Illuminate\Support\Facades\Auth;

class PartialMatchDuplicate implements ValidationRule
{
    private $leadId = null;

    public function __construct($leadId = null)
    {
        $this->leadId = $leadId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $inputKeywords = $this->extractKeywords($value);

        if (empty($inputKeywords)) {
            return;
        }

        $existingLeads = Leads::where('user_id', Auth::id())
            ->when($this->leadId, function ($query) {
                return $query->where('id', '!=', $this->leadId);
            })
            ->pluck('lead_title');

        foreach ($existingLeads as $existingTitle) {
            $existingKeywords = $this->extractKeywords($existingTitle);
            $matchedKeywords = array_intersect($inputKeywords, $existingKeywords);

            $matchPercentage = count($matchedKeywords) / max(count($inputKeywords), count($existingKeywords));

            if ($matchPercentage >= 0.5) {
                $fail("A similar lead '{$existingTitle}' already exists. This may be a duplicate based on matching keywords.");
                return;
            }
        }
    }

    private function extractKeywords(string $text): array
    {
        $stopWords = [
            'the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for',
            'of', 'with', 'by', 'from', 'is', 'are', 'was', 'were', 'be', 'been',
            'being', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would',
            'could', 'should', 'may', 'might', 'can', 'it', 'its', 'that', 'this',
            'which', 'who', 'whom', 'what', 'when', 'where', 'why', 'how'
        ];

        $cleaned = strtolower(preg_replace('/[^a-z0-9\s]/i', '', $text));
        $words = array_filter(explode(' ', $cleaned));

        $keywords = array_filter($words, function ($word) use ($stopWords) {
            return !in_array($word, $stopWords) && strlen($word) > 2;
        });

        return array_values($keywords); // Re-index the array
    }
}
