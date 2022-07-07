<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $vehicules = Vehicule::with('types')->get();

        return response()->json([
            'status' => 'Success',
            'data' => $vehicules
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
            'name' => 'required|max:100',
        ]);

        $filename = "";
        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('public/uploads', $filename);
        } else {
            $filename = Null;
        }

        $vehicule = Vehicule::create([
            'name' => $request->name,
            'type' => $request->type,
            'image' => $filename
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $vehicule,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Vehicule $vehicule
     * @return JsonResponse
     */
    public function show(Vehicule $vehicule): JsonResponse
    {
        $vehicule->type = $vehicule->types()->get();
        return response()->json($vehicule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Vehicule $vehicule
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Vehicule $vehicule, int $id): JsonResponse
    {
        $updateVehicule = $this->validate($request, [
            'name' => 'required|max:100',
            'image' => 'image|nullable|max: 1999'
        ]);

        $filename = "";
        if ($request->hasFile('image')) {
            if (Vehicule::findOrFail($id)->image){
                Storage::delete("/public/uploads/".Vehicule::findOrFail($id)->image);
            }
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
            $path = $request->file('image')->storeAs('public/uploads', $filename);
            $updateVehicule['image'] = $filename;
        }

        Vehicule::whereId($id)->update($updateVehicule);

        return response()->json([
            'status' => 'Mise à jour avec success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Vehicule $vehicule
     * @return JsonResponse
     */
    public function destroy(Vehicule $vehicule): JsonResponse
    {
        $vehicule->delete();

        return response()->json([
            'status' => 'Supprimer avec succès avec succèss'
        ]);
    }
}
