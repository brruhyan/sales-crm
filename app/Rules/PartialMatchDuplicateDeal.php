<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;

class PartialMatchDuplicateDeal implements ValidationRule
{
    private $dealId = null;

    public function __construct($dealId = null)
    {
        $this->dealId = $dealId;
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

        $existingDeals = Deal::when($this->dealId, function ($query) {
                return $query->where('id', '!=', $this->dealId);
            })
            ->with('user')
            ->get();

        foreach ($existingDeals as $existingDeal) {
            $existingKeywords = $this->extractKeywords($existingDeal->title);
            $matchedKeywords = array_intersect($inputKeywords, $existingKeywords);

            $matchPercentage = count($matchedKeywords) / max(count($inputKeywords), count($existingKeywords));

            if ($matchPercentage >= 0.5) {
                $fail("A similar deal — {$existingDeal->title} — already exists.");
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

        return array_values($keywords); 
    }
}
