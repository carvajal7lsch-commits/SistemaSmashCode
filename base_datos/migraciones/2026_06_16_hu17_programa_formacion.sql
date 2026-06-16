-- =============================================================
-- Migración: Sprint HU-17 — Gestión de Programas de Formación
-- Fecha: 2026-06-16
-- Descripción: Agrega columnas activo, eliminado y descripcion a
--              programa_formacion para soportar soft-delete y CRUD completo.
--
-- INSTRUCCIONES: Ejecutar este script en tu base de datos local
--                smash_code antes de probar la rama del sprint.
--
-- SEGURO: Usa ADD COLUMN IF NOT EXISTS, no rompe datos existentes.
-- =============================================================

USE smash_code;

ALTER TABLE programa_formacion
    ADD COLUMN IF NOT EXISTS descripcion VARCHAR(500)  NULL        AFTER nombre,
    ADD COLUMN IF NOT EXISTS activo      TINYINT(1)    NOT NULL DEFAULT 1  AFTER descripcion,
    ADD COLUMN IF NOT EXISTS eliminado   TINYINT(1)    NOT NULL DEFAULT 0  AFTER activo;

-- Verificación: debe mostrar las 5 columnas (id, nombre, descripcion, activo, eliminado)
DESCRIBE programa_formacion;
