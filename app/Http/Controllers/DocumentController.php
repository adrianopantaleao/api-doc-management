<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\ColumnDocument;
use App\Models\Document;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Showing all Documents',
            'data' => DocumentResource::collection(Document::all()),
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
    public function store(DocumentRequest $request)
    {
        try{
            $model = Document::create($request->only(['name', 'active', 'type_id']));
            if ($request->has('content') && is_array($request->content)){
                foreach($request->content as $content){
                    $documentContent[$content['column_id']] = ['content' => $content['text']];
                }
                $model->columns()->sync($documentContent);
            }
            return response()->json([
                'message' => 'Document created successfully.',
                'data' => new DocumentResource($model),
            ], 200);
        } catch (\Exception $e){
            log::error('Store Document Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $model = Document::findOrFail($id);
            return response()->json([
                'message' => 'Document retrieved successfully.',
                'data' => new DocumentResource($model),
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'Document not found'], 400);
        } catch (\Exception $e){
            log::error('Update Document Exception - '. $e);
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
    public function update(DocumentRequest $request, string $id)
    {
        try{
            $model = Document::findOrFail($id);
            $model->fill($request->only(['name', 'active', 'type_id']))->update();
            if ($request->has('content') && is_array($request->content)){
                foreach($request->content as $content){
                    $documentContent[$content['column_id']] = ['content' => $content['text']];
                }
                $model->columns()->sync($documentContent);
            }
            return response()->json([
                'message' => 'Document updated successfully.',
                'data' => new DocumentResource($model),
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'Document not found'], 400);
        } catch (\Exception $e){
            log::error('Update Document Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $model = Document::findOrFail($id);
            $model->columns->detach();
            $model->delete();
            return response()->json([
                'message' => 'Document deleted successfully.',
                'data' => new DocumentResource($model),
            ], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'Document not found'], 400);
        } catch (QueryException $e){
            log::error('Delete Document Exception - '. $e);
            return response()->json(['errors' => "Couldn't delete the Document with id {$model->id}"], 400);
        } catch (\Exception $e){
            log::error('Delete Document Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }
    }

    public function download($id)
    {
        try{
            $data = [
                'document' => Document::findOrFail($id)
            ];
            
            $pdf = PDF::loadView('pdf-document',$data);
            return $pdf->download('pdf-document.pdf');
        } catch(ModelNotFoundException $e){
            return response()->json(['errors' => 'Document not found'], 400);
        } catch (\Exception $e){
            log::error('Update Document Exception - '. $e);
            return response()->json(['errors' => 'server error, try again'], 500);
        }

    }
}
