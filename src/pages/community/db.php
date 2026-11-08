<?php
// src/pages/community/db.php

// 1) 공통 DB 설정 불러오기
$cfgPath = __DIR__ . '/../../shared/api/db_config.php';

if (!file_exists($cfgPath)) {
    throw new RuntimeException('DB 설정 파일을 찾을 수 없습니다: ' . $cfgPath);
}

include_once $cfgPath;

// 2) db_config.php 에서 $conn(PDO) 이 생성된다고 가정
if (!isset($conn) || !($conn instanceof PDO)) {
    throw new RuntimeException('db_config.php 에서 $conn(PDO) 이 정상적으로 생성되지 않았습니다.');
}

// 3) 커뮤니티 코드에서 편하게 쓸 수 있도록 별칭
$pdo = $conn;
