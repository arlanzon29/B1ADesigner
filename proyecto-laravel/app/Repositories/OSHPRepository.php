<?php

namespace App\Repositories;

use App\Interfaces\IOSHPRepository;
use App\Models\OSHP;

class OSHPRepository implements IOSHPRepository
{
    /**
     * Obtiene una clase de expedición por su clave primaria.
     *
     * @param string $code
     * @return array
     */
    public function getByKey(string $code): array
    {
        try {
            $elemento = OSHP::find($code);
            if ($elemento) {
                return [
                    'success' => true,
                    'data' => $elemento,
                    'message' => 'Clase de expedición encontrada'
                ];
            }
            return [
                'success' => false,
                'data' => null,
                'message' => 'Clase de expedición no encontrada'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Añade una nueva clase de expedición.
     *
     * @param OSHP $elemento
     * @return array
     */
    public function add(OSHP $elemento): array
    {
        try {
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Clase de expedición guardada correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al guardar: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Actualiza una clase de expedición existente.
     *
     * @param OSHP $elemento
     * @return array
     */
    public function update(OSHP $elemento): array
    {
        try {
            $existing = OSHP::find($elemento->Code);
            if (!$existing) {
                return [
                    'success' => false,
                    'data' => null,
                    'message' => 'Clase de expedición no encontrada'
                ];
            }
            $elemento->save();
            return [
                'success' => true,
                'data' => $elemento,
                'message' => 'Clase de expedición actualizada correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Elimina una clase de expedición por su clave.
     *
     * @param string $code
     * @return array
     */
    public function delete(string $code): array
    {
        try {
            $elemento = OSHP::find($code);
            if (!$elemento) {
                return [
                    'success' => false,
                    'data' => false,
                    'message' => 'Clase de expedición no encontrada'
                ];
            }
            $elemento->delete();
            return [
                'success' => true,
                'data' => true,
                'message' => 'Clase de expedición eliminada correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'data' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ];
        }
    }
}