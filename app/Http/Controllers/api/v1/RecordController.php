<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecordStoreRequest;
use App\Http\Requests\RecordUpdateRequest;
use App\Http\Resources\RecordCollection;
use App\Http\Resources\RecordResource;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Record::paginate(50);
        return new RecordCollection($records);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RecordStoreRequest $request)
    {
        try {
            $data = $request->all();

            $imagePath = $this->saveBase64Image($request->image);
            $data['image'] = $imagePath;

            $record = Record::create($data);

            return (new RecordResource($record))
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message' => 'Error creating record',
                'errors' => ['server' => ['Internal server error']],
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $record = Record::findOrFail($id);
            return new RecordResource($record);
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message'   => 'Data not found',
                'errors'  => [
                    'id' => ['Id not found!']
                ],
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecordUpdateRequest $request, string $id)
    {
        try {
            $record = Record::findOrFail($id);
            $data = $request->except('image');

            if ($request->has('image') && !empty($request->image)) {
                if ($record->image && Storage::disk('public')->exists($record->image)) {
                    Storage::disk('public')->delete($record->image);
                }

                $imagePath = $this->saveBase64Image($request->image);
                $data['image'] = $imagePath;
            } else {
                $data['image'] = $record->image;
            }

            $record->update($data);

            return new RecordResource($record);
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message'   => 'Data not found',
                'errors'  => [
                    'id' => ['Id not found!']
                ],
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $record = record::findOrFail($id);
            $record->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message'   => 'Data not found',
                'errors'  => [
                    'id' => ['Id not found!']
                ],
            ], 404);
        }
    }

    private function saveBase64Image($base64Image)
    {
        try {
            // Extraer la parte base64 del string (eliminar el prefijo data:image/...)
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
                $imageType = $matches[1];
                $base64String = substr($base64Image, strpos($base64Image, ',') + 1);
            } else {
                $imageType = 'png'; // tipo por defecto si no se especifica
                $base64String = $base64Image;
            }

            $decodedImage = base64_decode($base64String);

            if ($decodedImage === false) {
                throw new \Exception('Failed to decode base64 image');
            }

            $fileName = 'images/' . uniqid() . '.' . $imageType;

            Storage::disk('public')->put($fileName, $decodedImage);

            return $fileName;
        } catch (\Exception $e) {
            return null;
        }
    }
}
