<?php
$db = new SQLite3(__DIR__ . '/database/database.sqlite');
$res = $db->query("SELECT id, name, kepala_cabang FROM cabangs LIMIT 10");
while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
    echo "ID={$row['id']} | NAME={$row['name']} | KEPALA={$row['kepala_cabang']}\n";
}
echo "DONE\n";
