<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactDuplicateChecker implements ValidationRule
{
    private $contactId = null;
    private $company = null;

    public function __construct($company = null, $contactId = null)
    {
        $this->company = $company;
        $this->contactId = $contactId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (empty($this->company)) {
            return;
        }


        $existingContact = Contact::where('user_id', Auth::id())
            ->where('name', $value)
            ->where('company', $this->company)
            ->when($this->contactId, function ($query) {
                return $query->where('id', '!=', $this->contactId);
            })
            ->first();

        if ($existingContact) {
            $fail("The contact '{$existingContact->name}' already exists in '{$existingContact->company}'.");
            return;
        }

        $existingContacts = Contact::where('user_id', Auth::id())
            ->when($this->contactId, function ($query) {
                return $query->where('id', '!=', $this->contactId);
            })
            ->get();

        $normalizedName = $this->normalizeName($value);

        foreach ($existingContacts as $contact) {
            $normalizedExistingName = $this->normalizeName($contact->name);

            if ($this->isSimilarName($normalizedName, $normalizedExistingName)) {
                $fail("The person already exists in the company '{$contact->company}'");
                return;
            }
        }
    }

    /**
     * Normalize name by converting to lowercase and removing extra spaces
     */
    private function normalizeName(string $name): string
    {
        return strtolower(trim(preg_replace('/\s+/', ' ', $name)));
    }

    /**
     * Normalize company name
     */
    private function normalizeCompany(string $company): string
    {
        return strtolower(trim(preg_replace('/\s+/', ' ', $company)));
    }

    /**
     * Check if two names are similar using keyword matching
     */
    private function isSimilarName(string $name1, string $name2): bool
    {
        // Extract keywords (typically first and last names)
        $keywords1 = array_filter(explode(' ', $name1));
        $keywords2 = array_filter(explode(' ', $name2));

        // If either is empty, they're not similar
        if (empty($keywords1) || empty($keywords2)) {
            return false;
        }

        // Check for exact match first
        if ($name1 === $name2) {
            return true;
        }

        // Check if all keywords from the shorter name appear in the longer name
        $shorter = count($keywords1) <= count($keywords2) ? $keywords1 : $keywords2;
        $longer = count($keywords1) > count($keywords2) ? $keywords1 : $keywords2;

        $matchCount = 0;
        foreach ($shorter as $keyword) {
            if (in_array($keyword, $longer)) {
                $matchCount++;
            }
        }

        // If 100% of shorter name keywords match, consider them similar
        return $matchCount === count($shorter) && count($shorter) > 0;
    }
}
