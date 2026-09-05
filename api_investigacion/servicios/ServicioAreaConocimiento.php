<?php
/**
 * ServicioAreaConocimiento — la capa de NEGOCIO de la v1.
 *
 * Recibe POR CONSTRUCTOR la interfaz del repositorio (inversión de
 * dependencias): no sabe si detrás hay MariaDB o un falso en memoria para
 * pruebas — y así debe ser.
 *
 * No conoce HTTP: comunica los problemas con excepciones de negocio que el
 * controlador traduce a códigos (InvalidArgumentException → 400 ·
 * NoEncontradoExcepcion → 404).
 */

// Modo estricto de tipos (ver explicación completa en index.php):
declare(strict_types=1);

require_once __DIR__ . '/IServicioAreaConocimiento.php';
require_once __DIR__ . '/../repositorios/IRepositorioAreaConocimiento.php';
require_once __DIR__ . '/../excepciones/NoEncontradoExcepcion.php';
require_once __DIR__ . '/../modelos/AreaConocimiento.php';

class ServicioAreaConocimiento implements IServicioAreaConocimiento
{
    public function __construct(
        // Se guarda LA INTERFAZ, no una clase concreta: cualquier clase que
        // la implemente sirve — eso es el polimorfismo trabajando.
        private readonly IRepositorioAreaConocimiento $repositorio,
    ) {
    }

    // ------------------------------------------------------------------
    // Validaciones pequeñas y compartidas
    // ------------------------------------------------------------------

    private function validarClave(string $clave): string
    {
        $clave = trim($clave);
        if ($clave === '') {
            throw new InvalidArgumentException(
                'El campo id no puede estar vacío.');
        }
        return $clave;
    }

    // ------------------------------------------------------------------
    // Operaciones de negocio
    // ------------------------------------------------------------------

    public function listar(int $limite): array
    {
        // El contrato dice 400 (no 422) para límites inválidos: es una REGLA
        // DE NEGOCIO, no un problema de forma del cuerpo.
        if ($limite <= 0) {
            throw new InvalidArgumentException(
                'El límite debe ser un entero mayor que cero.');
        }
        return $this->repositorio->obtenerTodos($limite);
    }

    public function obtener(string $clave): AreaConocimiento
    {
        $clave = $this->validarClave($clave);
        $fila = $this->repositorio->obtenerPorClave($clave);
        // El repositorio devuelve null cuando no hay fila; el NEGOCIO decide
        // que eso es un error y lo dice con SU excepción (el repositorio no
        // opina, el controlador la vuelve 404):
        if ($fila === null) {
            throw new NoEncontradoExcepcion(
                "No existe el área de conocimiento con id = $clave");
        }
        return $fila;
    }

    public function crear(array $datos): void
    {
        // Los datos ya pasaron por la validación del controlador. Aquí el
        // NEGOCIO construye el objeto del MODELO: desde este punto el dato
        // deja de ser un array y viaja tipado.
        $entidad = new AreaConocimiento(
            $datos['id'],
            $datos['gran_area'],
            $datos['area'],
            $datos['disciplina'],
        );
        // Si la BD rechaza (llave duplicada), la PDOException sube tal cual
        // y el controlador la convierte en 500.
        $this->repositorio->crear($entidad);
    }

    public function actualizar(string $clave, array $datos): int
    {
        $clave = $this->validarClave($clave);
        // Un PATCH con cuerpo {} pasó la validación del controlador (nada
        // inválido)… pero no tiene sentido de negocio → 400.
        if ($datos === []) {
            throw new InvalidArgumentException(
                'No se envió ningún campo para actualizar.');
        }
        $filas = $this->repositorio->actualizar($clave, $datos);
        if ($filas === 0) {
            throw new NoEncontradoExcepcion(
                "No existe el área de conocimiento con id = $clave");
        }
        return $filas;
    }

    public function eliminar(string $clave): int
    {
        $clave = $this->validarClave($clave);
        $filas = $this->repositorio->eliminar($clave);
        // 0 filas = o nunca existió, o ya estaba inactiva. Para quien usa la
        // API son lo mismo: ese área de conocimiento ya no está.
        if ($filas === 0) {
            throw new NoEncontradoExcepcion(
                "No existe el área de conocimiento con id = $clave");
        }
        return $filas;
    }
}
