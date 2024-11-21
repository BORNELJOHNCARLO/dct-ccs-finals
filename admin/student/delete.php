<?php
session_start();

// Initialize variables
$studentId = $firstName = $lastName = '';

// Check if a student ID is provided
if (isset($_POST['studentId'])) {
    $studentId = trim($_POST['studentId']);
    
    // Find the student in the session array
    $existingStudentIndex = array_search($studentId, array_column($_SESSION['students'], 'studentId'));
    
    if ($existingStudentIndex !== false) {
        // Get the student's details
        $firstName = $_SESSION['students'][$existingStudentIndex]['firstName'];
        $lastName = $_SESSION['students'][$existingStudentIndex]['lastName'];
    } else {
        // Redirect to the main page if the student is not found
        header("Location: index.php");
        exit;
    }
}

// Handle confirmation of deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmDelete'])) {
    // Remove the student from the session array
    unset($_SESSION['students'][$existingStudentIndex]);
    // Re-index the array to maintain sequential keys
    $_SESSION['students'] = array_values($_SESSION['students']);
    
    // Redirect back to the main page after deletion
    header("Location: register.php");
    exit;
}
?>


    <div class="container mt-5">
        <h3 class="card-title">Delete a Student</h3><br>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="" >Registration Student</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>

                        </ol>
                    </nav>
                </div>
            </nav>
        <div class="alert alert-warning">
            <p>Are you sure you want to delete the following student record?</p>
            <p><strong>Student ID:</strong> <?php echo htmlspecialchars($studentId); ?></p>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($firstName); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($lastName); ?></p>
        </div>

        <form method="POST">
            <input type="hidden" name="studentId" value="<?php echo htmlspecialchars($studentId); ?>">
            <a href="register.php" class="btn btn-secondary">Cancel</a>
            <button type="submit" name="confirmDelete" class="btn btn-danger">Delete student record</button>
        </form>
    </div>
