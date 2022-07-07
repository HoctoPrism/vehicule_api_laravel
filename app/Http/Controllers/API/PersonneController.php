<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Personne;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PersonneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $personnes = DB::table('personnes')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success',
            'data' => $personnes
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
            'lastname' => 'required|max:100',
            'firstname' => 'required|max:100',
        ]);

/*        $filename = "";
        if ($request->hasFile('photoPersonne')) {
            $filenameWithExt = $request->file('photoPersonne')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photoPersonne')->getClientOriginalExtension();
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
            $path = $request->file('photoPersonne')->storeAs('public/uploads', $filename);
        } else {
            $filename = Null;
        }*/

        $personne = Personne::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $personne,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Personne $personne
     * @return JsonResponse
     */
    public function show(Personne $personne): JsonResponse
    {
        $personne->club = $personne->TravelList()->get();
        return response()->json($personne);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Personne $personne
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Personne $personne): JsonResponse
    {
        $this->validate($request, [
            'firstname' => 'required|max:100',
            'lastname' => 'required|max:100',
        ]);

        $personne->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);

        return response()->json([
            'status' => 'Mise à jour avec success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Personne $personne
     * @return JsonResponse
     */
    public function destroy(Personne $personne): JsonResponse
    {
        $personne->delete();

        return response()->json([
            'status' => 'Supprimer avec succès avec succèss'
        ]);
    }
}
