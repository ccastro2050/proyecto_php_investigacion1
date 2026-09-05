<?php
/**
 * AreaConocimiento — el MODELO de la v1: la clase que representa una fila de la tabla
 * `area_conocimiento` como un objeto.
 *
 * Estilo clásico de P.O.O. (encapsulamiento):
 *   - las propiedades son PRIVADAS: nadie por fuera las toca directamente;
 *   - se LEEN con getters;
 *   - se CAMBIAN con setters;
 *   - `id` NO tiene setter: es la llave primaria — se fija al
 *     crear el objeto y no cambia nunca.
 *
 * Lo que este modelo NO tiene, y es a propósito: la columna `activo`. La
 * usa el repositorio para el borrado lógico, pero no es un dato del
 * área de conocimiento — es cómo la base recuerda que ya no está. Si estuviera
 * aquí, alguien terminaría mandándola en un PUT.
 */

// Modo estricto de tipos (ver explicación completa en index.php):
declare(strict_types=1);

class AreaConocimiento
{
    private string $id;  // Código alfanumérico, como `1A01`.
    private string $gran_area;
    private string $area;
    private string $disciplina;

    public function __construct(
        string $id,
        string $gran_area,
        string $area,
        string $disciplina,
    ) {
        $this->id = $id;
        $this->gran_area = $gran_area;
        $this->area = $area;
        $this->disciplina = $disciplina;
    }

    // ------------------------------------------------------------------
    // GETTERS — para LEER cada propiedad desde afuera
    // ------------------------------------------------------------------

    public function getId(): string
    {
        return $this->id;
    }

    public function getGranArea(): string
    {
        return $this->gran_area;
    }

    public function getArea(): string
    {
        return $this->area;
    }

    public function getDisciplina(): string
    {
        return $this->disciplina;
    }

    // ------------------------------------------------------------------
    // SETTERS — solo para lo que puede cambiar.
    // La llave no tiene: identificar y modificar son cosas distintas.
    // ------------------------------------------------------------------

    public function setGranArea(string $gran_area): void
    {
        $this->gran_area = $gran_area;
    }

    public function setArea(string $area): void
    {
        $this->area = $area;
    }

    public function setDisciplina(string $disciplina): void
    {
        $this->disciplina = $disciplina;
    }

    // ------------------------------------------------------------------
    // Conversión para la respuesta JSON
    // ------------------------------------------------------------------

    /**
     * Devuelve el área de conocimiento como array (columna => valor), listo
     * para que json_encode lo convierta en JSON. Hace falta porque las
     * propiedades son privadas: json_encode no las ve.
     */
    public function toArray(): array
    {
        return [
            'id'                     => $this->id,
            'gran_area'              => $this->gran_area,
            'area'                   => $this->area,
            'disciplina'             => $this->disciplina,
        ];
    }
}
