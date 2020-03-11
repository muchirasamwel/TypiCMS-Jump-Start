<?php

namespace TypiCMS\Modules\Profiles\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Profiles\Models\Profile;

class PublicController extends BasePublicController
{
    public function index(): View
    {
        $models = Profile::published()->order()->with('image')->get();

        return view('profiles::public.index')
            ->with(compact('models'));
    }

    public function show($slug): View
    {
        $model = Profile::published()->whereSlugIs($slug)->firstOrFail();

        return view('profiles::public.show')
            ->with(compact('model'));
    }
}
