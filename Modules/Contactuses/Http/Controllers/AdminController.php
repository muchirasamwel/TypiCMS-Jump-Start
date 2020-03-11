<?php

namespace TypiCMS\Modules\Contactuses\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Contactuses\Http\Requests\FormRequest;
use TypiCMS\Modules\Contactuses\Models\Contactus;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('contactuses::admin.index');
    }

    public function create(): View
    {
        $model = new Contactus();

        return view('contactuses::admin.create')
            ->with(compact('model'));
    }

    public function edit(Contactus $contactus): View
    {
        return view('contactuses::admin.edit')
            ->with(['model' => $contactus]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $contactus = Contactus::create($request->all());

        return $this->redirect($request, $contactus);
    }

    public function update(Contactus $contactus, FormRequest $request): RedirectResponse
    {
        $contactus->update($request->all());

        return $this->redirect($request, $contactus);
    }
}
