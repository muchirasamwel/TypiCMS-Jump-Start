<?php

namespace TypiCMS\Modules\Profiles\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (Gate::denies('see-all-profiles')) {
            return;
        }
        $view->sidebar->group(__('Content'), function (SidebarGroup $group) {
            $group->id = 'content';
            $group->weight = 30;
            $group->addItem(__('Profiles'), function (SidebarItem $item) {
                $item->id = 'profiles';
                $item->icon = config('typicms.profiles.sidebar.icon');
                $item->weight = config('typicms.profiles.sidebar.weight');
                $item->route('admin::index-profiles');
                $item->append('admin::create-profile');
            });
        });
    }
}
