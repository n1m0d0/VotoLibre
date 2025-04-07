<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoteStoreRequest;
use App\Http\Resources\RecordResource;
use App\Http\Resources\VoteCollection;
use App\Http\Resources\VoteResource;
use App\Models\Record;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Vote::paginate(50);
        return new VoteCollection($records);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VoteStoreRequest $request)
    {
        $record = Vote::create($request->all());
        return (new VoteResource($record))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $record = Vote::findOrFail($id);
            return new VoteResource($record);
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
    public function update(VoteStoreRequest $request, string $id)
    {
        try {
            $record = Vote::findOrFail($id);
            $record->update($request->all());
            return new VoteResource($record);
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
            $record = Vote::findOrFail($id);
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

    public function storeRecordWithVotes(Request $request)
    {
        // Validar los datos de entrada
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'station_id' => 'required|integer|exists:stations,id',
            'image' => 'required|string',
            'votes' => 'required|array',
            'votes.*.party_id' => 'required|integer|exists:parties,id',
            'votes.*.amount' => 'required|integer|min:0',
        ]);

        try {
            // Usar una transacción DB
            return DB::transaction(function () use ($data) {
                // Crear el registro principal

                $imagePath = $this->saveBase64Image($data['image']);

                $record = Record::create([
                    'user_id' => $data['user_id'],
                    'station_id' => $data['station_id'],
                    'image' => $imagePath,
                ]);

                // Preparar datos de votos para createMany
                $votesData = collect($data['votes'])->map(function ($voteData) {
                    return [
                        'party_id' => $voteData['party_id'],
                        'amount' => $voteData['amount'],
                    ];
                })->all();

                // Crear los votos a través de la relación
                $record->votes()->createMany($votesData);

                // Cargar la relación para el recurso
                $record->load('votes');

                return response()->json([
                    'is_success' => true,
                    'message' => 'Record and votes created successfully',
                    'data' => new RecordResource($record),
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'is_success' => false,
                'message' => 'Failed to create record and votes',
                'error' => app()->environment('production') ? 'Server error' : $e->getMessage(),
            ], 500);
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
