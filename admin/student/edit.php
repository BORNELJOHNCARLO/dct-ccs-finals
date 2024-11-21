<?php
session_start();

// Initialize variables

$_SESSION['current_page']=$_SERVER['REQUEST_URI'];

require '../../functions.php';

$path=[
    'dashboard'=> '../dashboard.php',
    'logout'=> '../logout.php',
    'subject'=> '../subject/add.php',
    'student' => 'register.php',
];

// Check if studentId is provided
if (isset($_POST['studentId'])) {
    $studentId = trim($_POST['studentId']);
    // Find the student in the session
    $existingStudentIndex = array_search($studentId, array_column($_SESSION['students'], 'studentId'));

    if ($existingStudentIndex !== false) {
        // Retrieve the student data for editing
        $firstName = $_SESSION['students'][$existingStudentIndex]['firstName'];
        $lastName = $_SESSION['students'][$existingStudentIndex]['lastName'];
    } else {
        $errors[] = "Student not found.";
    }
}

// Handle form submission for updating student data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $studentId = trim($_POST['studentId']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);

    // Validate inputs
    if (empty($studentId)) {
        $errors[] = "Student ID is required.";
    }
    if (empty($firstName)) {
        $errors[] = "First Name is required.";
    }
    if (empty($lastName)) {
        $errors[] = "Last Name is required.";
    }

    // If there are no errors, update the student data
    if (empty($errors)) {
        $existingStudentIndex = array_search($studentId, array_column($_SESSION['students'], 'studentId'));
        if ($existingStudentIndex !== false) {
            // Update existing student
            $_SESSION['students'][$existingStudentIndex]['firstName'] = $firstName;
            $_SESSION['students'][$existingStudentIndex]['lastName'] = $lastName;

            // Redirect back to the main registration page or student list
            header("Location: register.php");
            exit;
        }
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-5">
<div class="container mt-5">
        <h3 class="card-title">Edit Student</h3><br>

        <!-- Display error messages -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Edit Form Card -->
        <div class="card shadow-sm border-0 mb-4">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="" >Registration Student</a></li>
                            <li class="breadcrumb-item active" aria-current="page">edit student</li>

                        </ol>
                    </nav>
                </div>
            </nav><br>
            <div class="card-body">
                <form method="POST" id="editForm">
                    <div class="mb-3">
                        <label for="studentId" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="studentId" name="studentId" value="<?php echo htmlspecialchars($studentId); ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>" placeholder="Enter First Name" required>
                    </div>

                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>" placeholder="Enter Last Name" required>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary w-100">Update Student</button>
                </form>
            </div>
        </div>
    </div>
</main>
    <?php require '../partials/footer.php'; ?>