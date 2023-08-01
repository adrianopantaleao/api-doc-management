<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequest;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

    /**
    * @OA\Schema(
    *    schema="TypeRequest",
    *        @OA\Property(
    *            property="id",
    *            description="id",
    *            type="integer",
    *            nullable="false",
    *            example="1"
    *        ),
    *        @OA\Property(
    *            property="name",
    *            description="name",
    *            type="string",
    *            nullable="false",
    *            example="string"
    *        ),
    * )
    */

class TypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/types/",
     *     summary="List types",
     *     operationId="list_types",
     *     description="Returns a list of all document types registered",
     *     @OA\Response(
     *         response=200,
     *         description="Showing all document types",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
    */
    public function index()
    {
        return response()->json([
            'message' => 'Showing all document types',
            'data' => TypeResource::collection(Type::all()),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json('not found', 404);
    }

    /**
    * @OA\Post(
    *     path="/api/types",
    *     summary="create a document types",
    *     description="create a document types",
    *     operationId="new_Type",
    *     @OA\RequestBody(
    *        @OA\JsonContent(ref="#/components/schemas/TypeRequest")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="document types created successfully",
    *         @OA\JsonContent(
    *             ref="#/components/schemas/TypeSchema"
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="server error, try again"
    *     )
    * )
    */
    public function store(TypeRequest $request)
    {
        try{
            $model = Type::create($request->only(['name', 'active']));
            return response()->json([
                'message' => 'Document type created successfully.',
                'data' => new TypeResource($model),
            ], 200);
        } catch (\Exception $e){
            log::error('Store Type Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }

    /**
    * @OA\GET(
    *     path="/api/types/{id}",
    *     summary="Get document type",
    *     description="Returns information about document type by id",
    *     operationId="get_Type_by_id",
    *     @OA\Parameter(
    *         name="id",
    *         description="id",
    *         in="path",
    *         required=true,
    *         example="1"
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="document types retrieved successfully",
    *         @OA\JsonContent(
    *             ref="#/components/schemas/TypeSchema"
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="server error, try again",
    *     )
    * )
    */
    public function show(string $id)
    {
        try{
            $model = Type::findOrFail($id);
            return response()->json([
                'message' => 'Document type retrieved successfully.',
                'data' => new TypeResource($model),
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'document type not found'], 400);
        } catch (\Exception $e){
            log::error('Update Type Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->json('not found', 404);
    }

    /**
    * @OA\Put(
    *     path="/api/types/{id}",
    *     summary="update a document types",
    *     description="update a document types",
    *     operationId="update_Type",
    *     @OA\RequestBody(
    *        @OA\JsonContent(ref="#/components/schemas/TypeRequest")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="document types updated successfully",
    *         @OA\JsonContent(
    *             ref="#/components/schemas/TypeSchema"
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="server error, try again"
    *     )
    * )
    */
    public function update(TypeRequest $request, string $id)
    {
        try{
            $model = Type::findOrFail($id);
            $model->fill($request->only(['name', 'active']))->update();
            return response()->json([
                'message' => 'Document type updated successfully.',
                'data' => new TypeResource($model),
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'document type not found'], 400);
        } catch (\Exception $e){
            log::error('Update Type Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }

    /**
    * @OA\Delete(
    *     path="/api/types/{id}",
    *     summary="delete a document types",
    *     description="delete a document types",
    *     operationId="delete_Type",
    *     @OA\RequestBody(
    *        @OA\JsonContent(ref="#/components/schemas/TypeRequest")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="document type deleted successfully",
    *         @OA\JsonContent(
    *             ref="#/components/schemas/TypeSchema"
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="server error, try again"
    *     )
    * )
    */
    public function destroy(string $id)
    {
        try{
            $model = Type::findOrFail($id);
            $model->delete();
            return response()->json([
                'message' => 'Document type deleted successfully.',
                'data' => new TypeResource($model),
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'document type not found'], 400);
        } catch (QueryException $e){
            log::error('Delete Type Exception - '. $e);
            return response()->json(['errors' => "Couldn't delete the document type with id {$model->id}"], 400);
        } catch (\Exception $e){
            log::error('Delete Type Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }
}
