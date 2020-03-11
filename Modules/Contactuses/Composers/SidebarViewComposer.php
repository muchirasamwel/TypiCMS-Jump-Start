<?php

namespace TypiCMS\Modules\Contactuses\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('see-all-contactuses')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Contactuses'), function (SidebarItem $item) {
                $item->id = 'contactuses';
                $item->icon = config('typicms.contactuses.sidebar.icon');
                $item->weight = config('typicms.contactuses.sidebar.weight');
                $item->route('admin::index-contactuses');
                $item->append('admin::create-contactus');
            });
        });
    }
}
