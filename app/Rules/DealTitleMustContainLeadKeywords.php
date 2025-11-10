<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Leads;

class DealTitleMustContainLeadKeywords implements ValidationRule
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
        if (!$this->leadId) {
            return;
        }

        $lead = Leads::find($this->leadId);
        if (!$lead) {
            return;
        }

        $leadKeywords = $this->extractKeywords($lead->lead_title);
        $titleKeywords = $this->extractKeywords($value);

        if (empty($leadKeywords) || empty($titleKeywords)) {
            return;
        }

        $matchedKeywords = array_intersect($leadKeywords, $titleKeywords);

        if (empty($matchedKeywords)) {
            $fail("The deal title must contain keywords from the associated lead: {$lead->lead_title}");
            return;
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

        return array_values($keywords);
    }
}
