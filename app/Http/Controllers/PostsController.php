<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Http\Requests\StorePostsRequest;
use App\Http\Requests\UpdatePostsRequest;


class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * @OA\Get(
     *  path="/api/v1/posts",
     *  summary="Posts",
     *  description="Posts list",
     *  tags={"Posts"},
     *  @OA\Parameter(
     *     name="page",
     *     in="path",
     *     description="A list of posts.",
     *     required=false,
     *     @OA\Schema(
     *         type="string",
     *     )
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="current_page", type="number", example=1),
     *        @OA\Property(property="data", type="array",
     *              example={{
     *                  "id": 12,
     *                  "title": "Первый пост",
     *                  "content": "Текст поста",
     *                  "poster": "/storage/images/poster_img.jpg",
     *                  "created_at": "2023-06-25 00:58:50"
     *                  },
     *                  {
     *                  "id": 13,
     *                  "title": "Первый пост 2",
     *                  "content": "Текст поста",
     *                  "created_at": "2023-06-25 00:59:47"
     *                  }},
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="content",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="created_at",
     *                         type="number",
     *                         example=""
     *                      ),
     *                ),
     *        ),
     *        @OA\Property(property="first_page_url", type="string", example="https://ovva.local/api/v1/posts?page=1"),
     *        @OA\Property(property="from", type="number", example=1),
     *        @OA\Property(property="last_page", type="number", example=3),
     *        @OA\Property(property="last_page_url", type="string", example="https://ovva.local/api/v1/posts?page=3"),
     *        @OA\Property(property="links", type="array",
     *                  example={{
     *                  "url": "https://ovva.local/api/v1/posts?page=1",
     *                  "label": "« Previous",
     *                  "active": false
     *                  },
     *                  {
     *                  "url": "https://ovva.local/api/v1/posts?page=1",
     *                  "label": "1",
     *                  "active": false
     *                  },
     *                  {
     *                  "url": "https://ovva.local/api/v1/posts?page=2",
     *                  "label": "2",
     *                  "active": true
     *                  },
     *                  {
     *                  "url": "https://ovva.local/api/v1/posts?page=3",
     *                  "label": "3",
     *                  "active": false
     *                  },
     *                  {
     *                  "url": "https://ovva.local/api/v1/posts?page=3",
     *                  "label": "Next »",
     *                  "active": false
     *                  }},
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="url",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="label",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="active",
     *                         type="boolean",
     *                         example=""
     *                      ),
     *                ),
     *        ),
     *        @OA\Property(property="next_page_url", type="string", example="https://ovva.local/api/v1/posts?page=3"),
     *        @OA\Property(property="path", type="string", example="https://ovva.local/api/v1/posts"),
     *        @OA\Property(property="per_page", type="number", example=2),
     *        @OA\Property(property="prev_page_url", type="string", example="https://ovva.local/api/v1/posts?page=1"),
     *        @OA\Property(property="to", type="number", example=4),
     *        @OA\Property(property="total", type="number", example=6),
     *     )
     *  ),
     * )
     *
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $posts = Posts::paginate(10);

        return $posts->toJson();
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
     *  path="/api/v1/posts",
     *  summary="Creat post",
     *  description="Creat post",
     *  tags={"Posts"},
     *  @OA\SecurityScheme(
     *  securityScheme="bearerAuth",
     *  type="http",
     *  scheme="bearer"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          required={"title","content"},
     *          @OA\Property(property="title", type="string", example="Первый Пост"),
     *          @OA\Property(property="content", type="string", example="Описание первого поста"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="title", type="string", example="Первый Пост"),
     *        @OA\Property(property="content", type="string", example="Описание первого поста"),
     *        @OA\Property(property="id", type="number", example=16),
     *     )
     *  ),
     *  @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(property="errors", type="object",
     *                  @OA\Property(property="title", type="array",
     *                      @OA\Items(type="string", example="Поле 'title' обязательное!"),
     *                  ),
     *                  @OA\Property(property="content", type="array",
     *                      @OA\Items(type="string", example="Поле 'content' обязательное!")
     *                  ),
     *              )
     *          )
     *  )
     * )
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePostsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePostsRequest $request)
    {
        try {
            $result = Posts::create($request->all());
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'message' => $exception->errorInfo,
            ], 204);
        }
        return $result->toJson();
    }

    /**
     * @OA\Get(
     *  path="/api/v1/posts/{id}",
     *  summary="Post",
     *  description="Post data",
     *  tags={"Posts"},
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="id", type="number", example=15),
     *        @OA\Property(property="title", type="string", example="Первый пост"),
     *        @OA\Property(property="content", type="string", example="Описание первого поста"),
     *        @OA\Property(property="created_at", type="string", example="2023-06-26 15:26:01"),
     *        @OA\Property(property="comments", type="array",
     *              example={{
     *                    "id": 2,
     *                    "posts_id": 15,
     *                    "author": "admin",
     *                    "text": "Комментарийnew2",
     *                    "created_at": "2023-06-26 15:30:46"
     *                    },
     *                    {
     *                    "id": 3,
     *                    "posts_id": 15,
     *                    "author": "admin",
     *                    "text": "Комментарий",
     *                    "created_at": "2023-06-26 15:30:57"
     *                    }},
     *                @OA\Items(
     *                      @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="posts_id",
     *                         type="number",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="text",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="author",
     *                         type="string",
     *                         example=""
     *                      ),
     *                      @OA\Property(
     *                         property="created_at",
     *                         type="number",
     *                         example=""
     *                      ),
     *                ),
     *        ),
     *     )
     *  ),
     * )
     * Display the specified resource.
     *
     * @param \App\Models\Posts $posts
     * @return \Illuminate\Http\Response|string
     */
    public function show(Posts $post)
    {
        $post->comments;
        return $post->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Posts $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Posts $post)
    {
        //
    }

    /**
     * @OA\PUT(
     *  path="/api/v1/posts/{id}",
     *  summary="Edit post",
     *  description="Edit post",
     *  tags={"Posts"},
     *  @OA\SecurityScheme(
     *  securityScheme="bearerAuth",
     *  type="http",
     *  scheme="bearer"
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          @OA\Property(property="title", type="string", example="Первый Пост NEW"),
     *          @OA\Property(property="content", type="string", example="Описание первого поста NEW"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *        @OA\Property(property="id", type="number", example=16),
     *        @OA\Property(property="title", type="string", example="Первый Пост NEW"),
     *        @OA\Property(property="content", type="string", example="Описание первого поста NEW"),
     *        @OA\Property(property="created_at", type="string", example="2023-06-26 15:26:01"),
     *     )
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
     * @param \App\Http\Requests\UpdatePostsRequest $request
     * @param \App\Models\Posts $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostsRequest $request, Posts $post)
    {
        try {
            $post->update($request->all());
        } catch (\Illuminate\Database\QueryException $exception) {
            return response()->json([
                'message' => $exception->errorInfo,
            ], 204);
        }
        return $post->toJson();
    }

    /**
     * @OA\Delete(
     *  path="/api/v1/posts/{id}",
     *  summary="Remove post",
     *  description="Remove post",
     *  tags={"Posts"},
     *  @OA\SecurityScheme(
     *  securityScheme="bearerAuth",
     *  type="http",
     *  scheme="bearer"
     *  ),
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
     * @param \App\Models\Posts $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Posts $post)
    {
        if (!$post->delete()) {
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
