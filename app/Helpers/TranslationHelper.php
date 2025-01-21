<?php

namespace App\Helpers;

use App\Models\Translation;

class TranslationHelper
{
    public static function translate($shortWord)
    {
        $translation = Translation::where('short_word', $shortWord)->first();
        return $translation ? $translation->translation : $shortWord;
    }
}
