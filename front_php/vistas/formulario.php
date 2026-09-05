<?php
/**
 * El formulario de una ficha: sirve para agregar y para editar.
 *
 * La diferencia entre los dos usos está en $editando, y se ve en dos sitios:
 * la llave va de solo lectura al editar, y aparecen DOS botones de guardar
 * en vez de uno.
 */
?>
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
  <div>
    <h1 class="h3 mb-1"><?= $editando ? 'Editar la ficha' : 'Agregar el área de conocimiento' ?></h1>
    <p class="text-body-secondary mb-0">
      <?php if ($editando): ?>
        La llave identifica la ficha y no se cambia. Si está mal, se agrega
        otra y se retira ésta.
      <?php else: ?>
        La llave la escribe usted y no se podrá cambiar después.
      <?php endif; ?>
    </p>
  </div>
  <a class="btn btn-outline-secondary" href="/areas-de-conocimiento">Volver al listado</a>
</div>

<div class="card shadow-sm" style="max-width: 46rem;">
  <div class="card-body p-4">
    <form method="post">

      <div class="mb-3">
        <label class="form-label" for="id">Código</label>
        <input class="form-control font-monospace" type="text" id="id" name="id"
               maxlength="6"
               value="<?= htmlspecialchars((string) ($ficha['id'] ?? '')) ?>"
               <?= $editando ? 'readonly' : 'required autofocus' ?>>
        <div class="form-text">Código alfanumérico, como <code>1A01</code>.</div>
      </div>

      <div class="mb-3">
        <label class="form-label" for="gran_area">Gran área</label>
        <input class="form-control" type="text" id="gran_area" name="gran_area"
               maxlength="60"
               value="<?= htmlspecialchars((string) ($ficha['gran_area'] ?? '')) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label" for="area">Área</label>
        <input class="form-control" type="text" id="area" name="area"
               maxlength="60"
               value="<?= htmlspecialchars((string) ($ficha['area'] ?? '')) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label" for="disciplina">Disciplina</label>
        <textarea class="form-control" id="disciplina" name="disciplina" rows="3"
                maxlength="150"><?= htmlspecialchars((string) ($ficha['disciplina'] ?? '')) ?></textarea>
      </div>

      <hr class="my-4">

      <?php /* ==============================================================
           LOS DOS BOTONES, QUE NO HACEN LO MISMO

             · «Guardar la ficha completa» manda todo, así que un dato
               obligatorio en blanco se rechaza.
             · «Guardar solo lo que cambié» manda únicamente lo diligenciado,
               así que el mismo formulario a medio llenar sí se guarda.

           El mismo formulario, dos comportamientos, y la diferencia no la
           decide ningún `if` de negocio: la decide QUÉ SE ENVÍA.
           ============================================================== */ ?>
      <?php if ($editando): ?>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-primary" type="submit" name="verbo" value="completa">
            Guardar la ficha completa
          </button>
          <button class="btn btn-outline-primary" type="submit" name="verbo" value="parcial">
            Guardar solo lo que cambié
          </button>
        </div>
        <div class="form-text mt-3">
          <strong>«La ficha completa»</strong> exige que todos los datos
          obligatorios estén diligenciados. <strong>«Solo lo que cambié»</strong>
          guarda lo que usted escribió y deja lo demás como estaba.
        </div>
      <?php else: ?>
        <button class="btn btn-primary" type="submit">Agregar</button>
      <?php endif; ?>

    </form>
  </div>
</div>
