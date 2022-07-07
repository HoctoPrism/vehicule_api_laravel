<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Travel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $travels = Travel::with(['personnes', 'vehicules'])->get();
        $travels->map(function ($travel){
            $travel['vehicules']->map(function ($voiture){
                $voiture['type'] = $voiture['types'];
                unset($voiture['types']);
            });
        });

        return response()->json([
            'status' => 'Success',
            'data' => $travels
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request ,[
            'lieu' => 'required|max:100',
        ]);

        $travel = Travel::create([
            'lieu' => $request->lieu
        ]);

        $travel->personnes()->attach($request->personnes);
        $travel->vehicules()->attach($request->vehicules);

        return response()->json([
            'status' => 'Success',
            'data' => $travel,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Travel $travel
     * @return JsonResponse
     */
    public function show(Travel $travel): JsonResponse
    {
        $travel->load(['vehicules', 'personnes']);
        $travel['vehicules']->map(function ($voiture){
            $voiture['type'] = $voiture['types'];
            unset($voiture['types']);
        });

        return response()->json($travel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Travel $travel
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Travel $travel): JsonResponse
    {
        $this->validate($request, [
            'lieu' => 'required|max:100',
        ]);

        $travel->update([
            'lieu' => $request->lieu
        ]);

        $travel->personnes()->sync($request->personnes);
        $travel->vehicules()->sync($request->vehicules);

        return response()->json([
            'status' => 'Mise à jour avec success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Travel $travel
     * @return JsonResponse
     */
    public function destroy(Travel $travel): JsonResponse
    {
        $travel->personnes()->detach();
        $travel->vehicules()->detach();
        $travel->delete();

        return response()->json([
            'status' => 'Supprimer avec succès avec succèss'
        ]);
    }
}
