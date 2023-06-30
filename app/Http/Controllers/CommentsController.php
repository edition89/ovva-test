<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Http\Requests\StoreCommentsRequest;
use App\Http\Requests\UpdateCommentsRequest;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(): string
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *  path="/api/v1/comments",
     *  summary="Creat comment",
     *  description="Creat comment",
     *  tags={"Comments"},
     *  security={{"bearerAuth":{}}},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"text","posts_id"},
     *          @OA\Property(property="text", type="string", example="Первый Комментарий"),
     *          @OA\Property(property="posts_id", type="number", example=15),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="posts_id", type="string", example="15"),
     *        @OA\Property(property="text", type="string", example="Первый Комментарий"),
     *        @OA\Property(property="author", type="string", example="admin"),
     *        @OA\Property(property="id", type="number", example=12),
     *     )
     *  ),
     *  @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="text", type="array",
     *                      @OA\Items(type="string", example="Поле 'text' обязательное!"),
     *                  ),
     *                  @OA\Property(property="posts_id", type="array",
     *                      @OA\Items(type="string", example="Поле 'posts_id' обязательное!")
     *                  ),
     *              )
     *          )
     *  ),
     *  @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="message", type="string", example="Unauthenticated"),
     *              @OA\Property(property="Description", type="string", example="Missing or Invalid Access Token"),
     *          )
     *  )
     * )
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCommentsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCommentsRequest $request)
    {
        try {
            $requestData = $request->all();
            $requestData['author'] = auth('sanctum')->user()->name;
            $comment = Comments::create($requestData);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'message' => $exception->errorInfo,
            ], 204);
        }
        return $comment->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Comments $comments
     * @return \Illuminate\Http\Response
     */
    public function show(Comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Comments $comments
     * @return \Illuminate\Http\Response
     */
    public function edit(Comments $comments)
    {
        //
    }

    /**
     * @OA\Put(
     *  path="/api/v1/comments/{id}",
     *  summary="Edit comment",
     *  description="Edit comment",
     *  tags={"Comments"},
     *  security={{"bearerAuth":{}}},
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"text"},
     *          @OA\Property(property="text", type="string", example="Первый Комментарий NEW"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="posts_id", type="string", example="15"),
     *        @OA\Property(property="text", type="string", example="Первый Комментарий NEW"),
     *        @OA\Property(property="author", type="string", example="admin"),
     *        @OA\Property(property="id", type="number", example=12),
     *     )
     *  ),
     *  @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="text", type="array",
     *                      @OA\Items(type="string", example="Поле 'text' обязательное!"),
     *                  )
     *              )
     *          )
     *  ),
     *  @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="message", type="string", example="Unauthenticated"),
     *              @OA\Property(property="Description", type="string", example="Missing or Invalid Access Token"),
     *          )
     *  )
     * )
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCommentsRequest $request
     * @param \App\Models\Comments $comment
     * @return string
     */
    public function update(UpdateCommentsRequest $request, Comments $comment)
    {
        self::checkUser($comment);
        try {
            $comment->update(['text' => $request->get('text')]);
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'message' => $exception->errorInfo,
            ], 204);
        }
        return $comment->toJson();
    }

    /**
     * @OA\Delete(
     *  path="/api/v1/comments/{id}",
     *  summary="Remove comment",
     *  description="Remove comment",
     *  tags={"Comments"},
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="succses"),
     *     )
     *  ),
     *  @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="message", type="string", example="Unauthenticated"),
     *              @OA\Property(property="Description", type="string", example="Missing or Invalid Access Token"),
     *          )
     *  ),
     *  @OA\Response(
     *          response=204,
     *          description="No Content",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="message", type="string", example="fail"),
     *          )
     *  )
     * )
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Comments $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comments $comment)
    {
        self::checkUser($comment);
        if (!$comment->delete()) {
            return response()->json([
                'message' => 'fail',
            ], 204);
        } else {
            return response()->json([
                'message' => 'succses',
            ], 200);
        }
    }
}
