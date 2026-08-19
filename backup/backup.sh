#!/bin/bash

set -e

FECHA=$(date +"%Y-%m-%d_%H-%M-%S")
ARCHIVO="/tmp/lucky_${FECHA}.sql.gz"

echo "========================================"
echo "     BACKUP LUCKY INVENTARIO"
echo "========================================"
echo "Fecha: $FECHA"

echo ""
echo "1. Generando backup MySQL..."

mysqldump \
    --protocol=TCP \
    -h "$DB_HOST" \
    -P "$DB_PORT" \
    -u "$DB_USER" \
    --password="$DB_PASSWORD" \
    "$DB_DATABASE" \
    | gzip > "$ARCHIVO"

echo "Backup generado:"
ls -lh "$ARCHIVO"

echo ""
echo "2. Subiendo a Google Drive..."

DESTINO="gdrive_lucky:Lucky_Backups/${BACKUP_DESTINO}"

rclone copy \
    "$ARCHIVO" \
    "$DESTINO" \
    --config=/config/rclone/rclone.conf \
    --progress

echo ""
echo "3. Backup subido correctamente."

rm -f "$ARCHIVO"

echo ""
echo "4. Archivo temporal eliminado."

echo ""
echo "========================================"
echo "       BACKUP COMPLETADO"
echo "========================================"