<?php

namespace App\Repositories;

use Psy\Util\Json;
use TypiCMS\Modules\Pages\Models\Page;

class PagesRepository
{
    /*
     * Cache Minutes
     */
    public $cacheMinutes = 60;

    /*PageSectionsRepository
     * Check the uri of the current page and which page it links to
     */
    public function getPageInformation($uri)
    {
        //Cache Here
        return \Cache::remember('page'.$uri, $this->cacheMinutes, function () use($uri) {
            $pageInfo = Page::where('uri->en', $uri)->where('status->en', 1)->first();
            //dd($pageInfo->body);
            if (is_null($pageInfo)) {
                return null;
            }

            return  [
                'uri' => $pageInfo->uri,
                'body' => $pageInfo->body,
                'title' => $pageInfo->title,
                'bannerImage' => '/uploads/pages/' . $pageInfo->image_id,
                'meta_title' => $pageInfo->meta_title,
                'meta_keywords' => $pageInfo->meta_keywords,
                'meta_description' => $pageInfo->meta_description,
//                'og_type' => $pageInfo->og_type,
//                'og_description' => $pageInfo->og_description,
                'image' => $pageInfo->image_id,
                'css' => $pageInfo->css,
                'js' => $pageInfo->js,
                'id' => $pageInfo->id,
                'module' => $pageInfo->module,
            ];
        });
    }
}
