<?php
ob_start(); 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../shared/api/db_config.php'; 
header('Content-Type: application/json'); 
$ai_id = $_POST['id'] ?? null; 

if ($ai_id === null || !is_numeric($ai_id)) { 
    $response = ['success' => false, 'message' => 'Invalid AI ID']; 
    ob_end_clean();
    echo json_encode($response);
    exit;
}

// 💡 DB 연결 확인 (PDO)
if (!isset($conn) || !$conn instanceof PDO) {
    $response = ['success' => false, 'message' => 'DB Connection Failed'];
    ob_end_clean();
    echo json_encode($response);
    exit;
}
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "UPDATE ai_programs SET views = views + 1 WHERE id = :ai_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':ai_id' => $ai_id]);
    $response = ['success' => true, 'message' => 'View incremented'];
} catch (PDOException $e) { 
    error_log("View Increment Error: " . $e->getMessage());
    $response = ['success' => false, 'message' => 'DB Update Failed: ' . $e->getMessage()];
}

ob_end_clean();
echo json_encode($response);
exit;
?>