<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinica;

class ClinicaController extends Controller
{
    /**
     * Retorna todas las clínicas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clinicas = Clinica::paginate(10);
        return response()->json($clinicas);
    }

    /**
     * Almacena una nueva clínica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electronico' => 'required|email|max:255|unique:clinicas,correo_electronico',
            'telefono' => 'required|string|max:255',
        ]);

        try {
            $clinica = Clinica::create($validated);
            return response()->json($clinica, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la clínica', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Retorna la clínica específica por su ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clinica = Clinica::findOrFail($id);

        return response()->json($clinica);
    }

    /**
     * Actualiza la clínica específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo_electronico' => 'required|email|max:255|unique:clinicas,correo_electronico,' . $id,
            'telefono' => 'required|string|max:255',
        ]);

        $clinica = Clinica::findOrFail($id);
        $clinica->update($validated);

        return response()->json($clinica, 200);
    }
    /**
     * Elimina la clínica específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $clinica = Clinica::findOrFail($id);
            $clinica->delete();

            return response()->json(['message' => 'Clinica eliminada exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la clínica'], 500);
        }
    }


    public function empleadosPorClinica($id, Request $request)
    {
        $clinica = Clinica::find($id);
        if (!$clinica) {
            return response()->json(['error' => 'Clínica no encontrada.'], 404);
        }

        $empleados = $clinica->empleados()->paginate(10); 

        return response()->json($empleados);
    }
}
