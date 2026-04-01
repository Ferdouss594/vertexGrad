<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        $supportedLocales = ['en', 'ar'];

        abort_unless(in_array($locale, $supportedLocales, true), 404);

        session(['backend_locale' => $locale]);

        return redirect()->back();
    }
}