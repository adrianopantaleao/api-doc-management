<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColumnRequest;
use App\Http\Resources\ColumnResource;
use App\Models\Column;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
