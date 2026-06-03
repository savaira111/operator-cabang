<?php
$db = new SQLite3(__DIR__ . '/database/database.sqlite');
$tables = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
while ($table = $tables->fetchArray(SQLITE3_ASSOC)) {
    $tname = $table['name'];
    try {
        $res = $db->query("SELECT * FROM \"$tname\"");
        if (!$res) continue;
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            foreach ($row as $col => $val) {
                if (is_string($val) && stripos($val, 'sachan') !== false) {
                    echo "TABLE=$tname | COL=$col | ID=" . ($row['id'] ?? 'N/A') . " | VAL=$val\n";
                }
            }
        }
    } catch(Exception $e) {}
}
echo "DONE\n";
