<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$error = "";
$success = "";

// Fetch student data
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);
    
    // Handle file upload
    $profile_photo = $student['profile_photo'];
    if (!empty($_FILES['profile_photo']['name'])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
        $filename = "student_" . $student_id . "_" . time() . "." . $file_ext;
        $target_file = $target_dir . $filename;
        
        // Check image file
        $check = getimagesize($_FILES['profile_photo']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
                $profile_photo = $target_file;
            } else {
                $error = "Error uploading file";
            }
        } else {
            $error = "File is not an image";
        }
    }
    
    // Update database
    $sql = "UPDATE students SET full_name=?, phone=?, course=?, profile_photo=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $full_name, $phone, $course, $profile_photo, $student_id);
    
    if ($stmt->execute()) {
        $success = "Profile updated successfully!";
        // Refresh student data
        $sql = "SELECT * FROM students WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();
    } else {
        $error = "Error updating profile: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Student Portal</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($student['profile_photo']): ?>
                            <img src="<?= $student['profile_photo'] ?>" class="img-fluid rounded-circle mb-3" alt="Profile" style="width: 150px; height: 150px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; margin: 0 auto;">
                                <span class="text-white">No Photo</span>
                            </div>
                        <?php endif; ?>
                        <h4><?= htmlspecialchars($student['full_name']) ?></h4>
                        <p class="text-muted"><?= htmlspecialchars($student['course']) ?></p>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-envelope me-2"></i><?= htmlspecialchars($student['email']) ?></li>
                            <li><i class="bi bi-phone me-2"></i><?= htmlspecialchars($student['phone'] ?? 'N/A') ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Update Profile</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="dashboard.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($student['phone'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label for="course" class="form-label">Course</label>
                                <input type="text" class="form-control" id="course" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">Profile Photo</label>
                                <input class="form-control" type="file" id="profile_photo" name="profile_photo" accept="image/*">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer bg-light mt-5 py-3">
        <div class="container text-center">
            <span class="text-muted">&copy; 2025 Aman Shah - Student Portal</span>
        </div>
    </footer>
</body>
</html>