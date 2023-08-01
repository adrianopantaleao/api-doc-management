<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColumnRequest;
use App\Http\Resources\ColumnResource;
use App\Models\Column;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

    /**
    * @OA\Schema(
    *    schema="ColumnRequest",
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
    *        @OA\Property(
    *            property="type_id",
    *            description="Type id",
    *            type="integer",
    *            nullable="false",
    *            example="1"
    *        ),
    * )
    */

class ColumnController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/columns/",
     *     summary="List columns",
     *     operationId="list_columns",
     *     description="Returns a list of all colunms registered",
     *     @OA\Response(
     *         response=200,
     *         description="Showing all Column types",
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
            'message' => 'Showing all Column types',
            'data' => ColumnResource::collection(Column::all()),
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
    *     path="/api/columns",
    *     summary="create a column",
    *     description="create a column",
    *     operationId="new_column",
    *     @OA\RequestBody(
    *        @OA\JsonContent(ref="#/components/schemas/ColumnRequest")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Column type created successfully",
    *         @OA\JsonContent(
    *             ref="#/components/schemas/ColumnSchema"
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="server error, try again"
    *     )
    * )
    */
    public function store(ColumnRequest $request)
    {
        try{
            $model = Column::create($request->only(['name', 'active', 'type_id']));
            return response()->json([
                'message' => 'Column type created successfully.',
                'data' => new ColumnResource($model),
            ], 200);
        } catch (\Exception $e){
            log::error('Store Column Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }

    /**
    * @OA\GET(
    *     path="/api/columns/{id}",
    *     summary="Get columns",
    *     description="Returns information about column by id",
    *     operationId="get_column_by_id",
    *     @OA\Parameter(
    *         name="id",
    *         description="id",
    *         in="path",
    *         required=true,
    *         example="1"
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Column type retrieved successfully",
    *         @OA\JsonContent(
    *             ref="#/components/schemas/ColumnSchema"
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
            $model = Column::findOrFail($id);
            return response()->json([
                'message' => 'Column type retrieved successfully.',
                'data' => new ColumnResource($model),
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'Column type not found'], 400);
        } catch (\Exception $e){
            log::error('Update Column Exception - '. $e);
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
    *     path="/api/columns/{id}",
    *     summary="update a column",
    *     description="update a column",
    *     operationId="update_column",
    *     @OA\RequestBody(
    *        @OA\JsonContent(ref="#/components/schemas/ColumnRequest")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Column type updated successfully",
    *         @OA\JsonContent(
    *             ref="#/components/schemas/ColumnSchema"
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="server error, try again"
    *     )
    * )
    */
    public function update(ColumnRequest $request, string $id)
    {
        try{
            $model = Column::findOrFail($id);
            $model->fill($request->only(['name', 'active', 'type_id']))->update();
            return response()->json([
                'message' => 'Column type updated successfully.',
                'data' => new ColumnResource($model),
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'Column type not found'], 400);
        } catch (\Exception $e){
            log::error('Update Column Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }

    /**
    * @OA\Delete(
    *     path="/api/columns/{id}",
    *     summary="delete a column",
    *     description="delete a column",
    *     operationId="delete_column",
    *     @OA\RequestBody(
    *        @OA\JsonContent(ref="#/components/schemas/ColumnRequest")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Column type deleted successfully",
    *         @OA\JsonContent(
    *             ref="#/components/schemas/ColumnSchema"
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
            $model = Column::findOrFail($id);
            $model->delete();
            return response()->json([
                'message' => 'Column type deleted successfully.',
                'data' => new ColumnResource($model),
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'Column type not found'], 400);
        } catch (QueryException $e){
            log::error('Delete Column Exception - '. $e);
            return response()->json(['errors' => "Couldn't delete the Column type with id {$model->id}"], 400);
        } catch (\Exception $e){
            log::error('Delete Column Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }
}
