<?php

namespace TypiCMS\Modules\Profiles\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Profiles\Models\Profile;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Profile::class)
            ->selectFields($request->input('fields.profiles'))
            ->allowedSorts(['status_translated', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Profile $profile, Request $request): JsonResponse
    {
        $data = [];
        foreach ($request->all() as $column => $content) {
            if (is_array($content)) {
                foreach ($content as $key => $value) {
                    $data[$column.'->'.$key] = $value;
                }
            } else {
                $data[$column] = $content;
            }
        }

        foreach ($data as $key => $value) {
            $profile->$key = $value;
        }
        $saved = $profile->save();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Profile $profile): JsonResponse
    {
        $deleted = $profile->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(Profile $profile): Collection
    {
        return $profile->files;
    }

    public function attachFiles(Profile $profile, Request $request): JsonResponse
    {
        return $profile->attachFiles($request);
    }

    public function detachFile(Profile $profile, File $file): void
    {
        $profile->detachFile($file);
    }
}
