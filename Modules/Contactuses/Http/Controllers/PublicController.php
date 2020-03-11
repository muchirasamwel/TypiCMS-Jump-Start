<?php

namespace TypiCMS\Modules\Contactuses\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Contactuses\Models\Contactus;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Contactus::published()->order()->with('image')->get();

        return view('contactuses::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Contactus::published()->whereSlugIs($slug)->firstOrFail();

        return view('contactuses::public.show')
            ->with(compact('model'));
    }
}
