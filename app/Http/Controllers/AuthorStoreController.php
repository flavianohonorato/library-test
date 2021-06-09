<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorStoreRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\MessageResource;
use App\Services\AuthorCreateService;

class AuthorStoreController extends Controller
{
    /**
     * @OA\Post(
     *   tags={"authors"},
     *   path="/authors",
     *    @OA\RequestBody(
     *       required=true,
     *       description="Create author",
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/AuthorStoreRequest")
     *       )
     *   ),
     *   summary="Create author",
     *    @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/AuthorResource"),
     *     ),
     *   @OA\Response(
     *     response="400",
     *     description="Bad request"
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Internal Server Error"
     *   )
     * )
     */
    public function __invoke(AuthorStoreRequest $request, AuthorCreateService $service)
    {
        $data = $request->validated();

        $author = $service->handle($data);

        if (!$author) {
            return MessageResource::make((object) ['message' => 'Internal Server Error'])
                ->response()
                ->setStatusCode(500);
        }

        return AuthorResource::make($author);
    }
}
