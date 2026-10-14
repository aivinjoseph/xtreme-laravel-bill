<?php

$root = dirname(__DIR__);
$dumpPath = $root . DIRECTORY_SEPARATOR . 'xtreme_motors.sql';
$databasePath = $root . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'xtreme_motors_dump.sqlite';

$pdo = new PDO('sqlite:' . $databasePath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = OFF');

$sql = file_get_contents($dumpPath);
$statement = '';
$inString = false;
$length = strlen($sql);
$imported = 0;

function convertMySqlLiterals(string $statement): string
{
    $converted = '';
    $inString = false;

    for ($i = 0, $length = strlen($statement); $i < $length; $i++) {
        $character = $statement[$i];

        if (!$inString) {
            $converted .= $character;
            if ($character === "'") {
                $inString = true;
            }
            continue;
        }

        if ($character === '\\' && $i + 1 < $length) {
            $next = $statement[++$i];
            $converted .= match ($next) {
                "'" => "''",
                '0' => "\0",
                'b' => "\b",
                'n' => "\n",
                'r' => "\r",
                't' => "\t",
                'Z' => "\x1a",
                default => $next,
            };
            continue;
        }

        $converted .= $character;
        if ($character === "'") {
            $inString = false;
        }
    }

    return $converted;
}

for ($i = 0; $i < $length; $i++) {
    $character = $sql[$i];
    $statement .= $character;

    if ($inString && $character === '\\' && $i + 1 < $length) {
        $statement .= $sql[++$i];
        continue;
    }

    if ($character === "'") {
        $inString = !$inString;
        continue;
    }

    if ($character !== ';' || $inString) {
        continue;
    }

    $insertPosition = stripos($statement, 'INSERT INTO ');

    if ($insertPosition !== false) {
        $statement = substr($statement, $insertPosition);
        $statement = convertMySqlLiterals($statement);
        $statement = preg_replace('/^INSERT INTO/i', 'INSERT OR REPLACE INTO', $statement);
        $pdo->exec($statement);
        $imported++;
    }

    $statement = '';
}

$pdo->exec('PRAGMA foreign_keys = ON');
echo "Imported {$imported} INSERT statements into {$databasePath}" . PHP_EOL;
