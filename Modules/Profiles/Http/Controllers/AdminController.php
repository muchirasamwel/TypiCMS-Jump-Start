<?php

namespace TypiCMS\Modules\Profiles\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Profiles\Http\Requests\FormRequest;
use TypiCMS\Modules\Profiles\Models\Profile;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('profiles::admin.index');
    }

    public function create(): View
    {
        $model = new Profile();

        return view('profiles::admin.create')
            ->with(compact('model'));
    }

    public function edit(Profile $profile): View
    {
        return view('profiles::admin.edit')
            ->with(['model' => $profile]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $profile = Profile::create($request->all());

        return $this->redirect($request, $profile);
    }

    public function update(Profile $profile, FormRequest $request): RedirectResponse
    {
        $profile->update($request->all());

        return $this->redirect($request, $profile);
    }
}
