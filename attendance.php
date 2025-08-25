<?php
header("Content-Type: application/json");

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "projectcs";
$STUDENT_TABLE = "students";
$ATT_TABLE     = "attendanceTBL";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
  echo json_encode(["success" => false, "message" => "Database connection failed"]);
  exit;
}
$conn->set_charset("utf8mb4");

$studentId = $_POST["studentId"] ?? "";

if (!$studentId) {
  echo json_encode(["success" => false, "message" => "No Student ID provided"]);
  exit;
}

// Check if student exists
$stmt = $conn->prepare("SELECT studentID, name, course, year_level FROM {$STUDENT_TABLE} WHERE studentID = ?");
$stmt->bind_param("s", $studentId);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) {
  echo json_encode(["success" => false, "message" => "Student not found"]);
  exit;
}

// Check today's attendance
$stmt = $conn->prepare("
  SELECT attendanceID, timeIN, timeOUT 
  FROM {$ATT_TABLE} 
  WHERE studentID = ? AND DATE(timeIN) = CURDATE()
  ORDER BY attendanceID DESC LIMIT 1
");
$stmt->bind_param("s", $studentId);
$stmt->execute();
$attendance = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($attendance && is_null($attendance["timeOUT"])) {
  // Time OUT
  $upd = $conn->prepare("UPDATE {$ATT_TABLE} SET timeOUT = NOW() WHERE attendanceID = ?");
  $upd->bind_param("i", $attendance["attendanceID"]);
  $upd->execute();
  $upd->close();

  echo json_encode([
    "success" => true,
    "name" => $student["name"],
    "course" => $student["course"],
    "year_level" => $student["year_level"],
    "status" => "Checked OUT",
    "time_in" => $attendance["timeIN"],
    "time_out" => date("H:i:s")
  ]);
} else {
  // Time IN
  $ins = $conn->prepare("INSERT INTO {$ATT_TABLE} (studentID, timeIN) VALUES (?, NOW())");
  $ins->bind_param("s", $studentId);
  $ins->execute();
  $ins->close();

  echo json_encode([
    "success" => true,
    "name" => $student["name"],
    "course" => $student["course"],
    "year_level" => $student["year_level"],
    "status" => "Checked IN",
    "time_in" => date("H:i:s"),
    "time_out" => null
  ]);
}

$conn->close();
?>
