#!/bin/sh
set -eu

SOURCE_DIR=/opt/source

mkdir -p \
    "$SOURCE_DIR/storage/framework/cache/data" \
    "$SOURCE_DIR/storage/framework/sessions" \
    "$SOURCE_DIR/storage/framework/views" \
    "$SOURCE_DIR/bootstrap/cache"
chown -R www-data:www-data "$SOURCE_DIR/storage" "$SOURCE_DIR/bootstrap/cache" || true

exec "$@"
