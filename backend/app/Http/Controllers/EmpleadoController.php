<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Clinica;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of all employees.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Configura la paginación
        $perPage = $request->input('per_page', 10); 
        $currentPage = $request->input('page', 1);
        
        // Obtiene los empleados paginados
        $empleados = Empleado::paginate($perPage);

        // Devuelve la respuesta en formato JSON
        return response()->json($empleados, 200);
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Valida los datos recibidos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:255|unique:empleados',
            'clinica_id' => 'required|exists:clinicas,id',
            'correo_electronico' => 'required|email|max:255|unique:empleados',
            'telefono' => 'required|string|max:255',
        ]);


        $validated['clinica_id'] = $request->input('clinica_id');

        // Crea el nuevo empleado
        $empleado = Empleado::create($validated);

        // Devuelve el empleado creado con código de estado 201 (Creado)
        return response()->json($empleado, 201);
    }

    /**
     * Display the specified employee.
     *
     * @param  Empleado  $empleado
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Empleado $empleado)
    {
        // Devuelve el empleado especificado en formato JSON
        return response()->json($empleado, 200);
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Empleado  $empleado
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Empleado $empleado)
    {
        // Valida los datos recibidos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:255|unique:empleados,dni,' . $empleado->id,
            'clinica_id' => 'required|exists:clinicas,id',
            'correo_electronico' => 'required|email|max:255|unique:empleados,correo_electronico,' . $empleado->id,
            'telefono' => 'required|string|max:255',
        ]);

        // Actualiza el empleado con los datos validados
        $empleado->update($validated);

        // Devuelve el empleado actualizado
        return response()->json($empleado, 200);
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param  Empleado  $empleado
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return response()->json(['message' => 'Empleado eliminado exitosamente.'], 200);
    }

    /**
     * Retrieve employees associated with a specific clinic.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function empleadosPorClinica($id, Request $request)
    {
        try {
            $clinica = Clinica::findOrFail($id);

            // Obtiene los empleados asociados a la clínica con paginación
            $empleados = $clinica->empleados()->paginate(10); // Pagina con 10 empleados por página
            return response()->json($empleados, 200);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener empleados: ' . $e->getMessage()], 500);
        }
    }
}
