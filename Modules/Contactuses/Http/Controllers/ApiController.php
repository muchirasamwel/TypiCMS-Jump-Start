<?php

namespace TypiCMS\Modules\Contactuses\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Contactuses\Models\Contactus;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Contactus::class)
            ->selectFields($request->input('fields.contactuses'))
            ->allowedSorts(['status_translated', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Contactus $contactus, Request $request): JsonResponse
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
            $contactus->$key = $value;
        }
        $saved = $contactus->save();

        return response()->json([
            'error' => !$saved,
        ]);
    }

    public function destroy(Contactus $contactus): JsonResponse
    {
        $deleted = $contactus->delete();

        return response()->json([
            'error' => !$deleted,
        ]);
    }

    public function files(Contactus $contactus): Collection
    {
        return $contactus->files;
    }

    public function attachFiles(Contactus $contactus, Request $request): JsonResponse
    {
        return $contactus->attachFiles($request);
    }

    public function detachFile(Contactus $contactus, File $file): void
    {
        $contactus->detachFile($file);
    }
}
