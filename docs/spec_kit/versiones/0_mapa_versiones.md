# Mapa de versiones — Módulo de Investigación (PHP)

Cada versión entrega **su API y su pantalla**. No hay una versión final que
«agregue el front» (Artículo 1.1).

| Versión | Alcance | Estado |
|---|---|---|
| **v1** | `area_conocimiento` de punta a punta: los 5 verbos, el borrado lógico, la pantalla y la prueba de capas | **hecha** |
| v2 | Las demás tablas sin clave foránea del módulo, cada una con su ruta y su pantalla | pendiente |
| v3 | Las tablas CON clave foránea: maestro-detalle, y los rechazos de integridad traducidos a 409 | pendiente |
| v4 | Autenticación (las tablas `usuario`, `rol` y `rol_usuario` ya están creadas) y consultas de varias tablas | pendiente |

## Por qué la v1 es `area_conocimiento`

De las tablas **sin clave foránea** del módulo, es la que más enseña:

- tiene **4 columnas** —suficientes para que el
  contraste entre PUT y PATCH se note— y **ninguna clave foránea**, así que
  la v1 no tiene que hablar de integridad referencial todavía;
- su llave es `id`, un texto:
  llega lista de la URL, sin conversiones;
- y arranca **con 218 filas**, así que la pantalla tiene qué
  mostrar desde el primer arranque.

Las 19 tablas del módulo **se crean todas** en el primer
arranque: la base es infraestructura dada (Artículo 5). Lo que crece por
versiones es la API, no el esquema.

## Y el gemelo

[`proyecto_paradigmas_investigacion1`](../../../../proyecto_paradigmas_investigacion1) construye esta
misma v1 sobre la misma tabla, en Python y PostgreSQL. Compararlos es parte
del ejercicio: mismo contrato, dos maneras de cumplirlo.
