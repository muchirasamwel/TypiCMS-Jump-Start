<?php

namespace App\Http\Controllers;

use App\Repositories\PagesRepository;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $pagesRepository;

    public function __construct(PagesRepository $pagesRepository)
    {
        $this->pagesRepository = $pagesRepository;
    }
    public function index(Request $request)
    {
        $pageInfo = $this->pagesRepository->getPageInformation(str_replace('en/','',$request->path()));
        return view('test_pages.about', [
            'page' => json_decode(json_encode($pageInfo)),
        ]);
   }
}
