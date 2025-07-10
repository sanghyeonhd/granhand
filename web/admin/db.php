<?php
$host = 'localhost';
$db = 'granhand';
$user = 'gwontaegom';
$pass = 'cc159753';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        echo "🔄 테이블 처리: $table\n";

        try {
            // 테이블 엔진 변경
            $engineRes = $pdo->query("SHOW TABLE STATUS WHERE Name = '$table'")->fetch();
            if (strtolower($engineRes['Engine']) === 'myisam') {
                $pdo->exec("ALTER TABLE `$table` ENGINE=InnoDB");
                echo "✅ 엔진 변경: $table → InnoDB\n";
            }

            // 컬럼 확인
            $columns = $pdo->query("SHOW FULL COLUMNS FROM `$table`")->fetchAll();
            foreach ($columns as $column) {
                $field = $column['Field'];
                $type = strtolower($column['Type']);
                $collation = $column['Collation'];
                
                // ✅ index_no -> idx (AUTO_INCREMENT + PRIMARY KEY 가정)
                if ($field === 'index_no') {
                    $pdo->exec("ALTER TABLE `$table` CHANGE `index_no` `idx` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;");
                    echo "📝 필드명 변경: $table.index_no → idx (AUTO_INCREMENT + PK 유지)\n";
                }

                // ✅ TEXT 필드의 Collation 변경
                if (strpos($type, 'text') !== false && $collation !== 'utf8mb4_general_ci') {
                    $null = $column['Null'] === 'NO' ? 'NOT NULL' : 'NULL';
                    $default = $column['Default'] !== null ? "DEFAULT " . $pdo->quote($column['Default']) : '';
                    $extra = $column['Extra'];
                    $pdo->exec("ALTER TABLE `$table` MODIFY `$field` $type COLLATE utf8mb4_general_ci $null $default $extra");
                    echo "🔤 Collation 변경: $table.$field → utf8mb4_general_ci\n";
                }
            }

        } catch (PDOException $e) {
            echo "❌ 에러 (테이블 `$table`): " . $e->getMessage() . "\n";
        }
    }

    echo "\n🎉 모든 작업 완료!\n";

} catch (PDOException $e) {
    echo "❌ DB 접속 에러: " . $e->getMessage();
}
