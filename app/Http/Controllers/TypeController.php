<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequest;
use App\Http\Resources\TypeResource;
use App\Models\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
