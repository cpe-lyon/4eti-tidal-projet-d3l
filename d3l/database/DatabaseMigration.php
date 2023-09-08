<?php

class DatabaseMigration {

    function clearMigrationFolder() {
        $files = glob('./app/database/migrations/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}