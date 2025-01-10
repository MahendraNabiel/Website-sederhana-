<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Include the database connection
include 'db.php';

// Get the user's details from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

// Error checking for SQL preparation
if ($stmt === false) {
    die("Error preparing the SQL statement: " . $conn->error);
}

$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Error checking for query execution
if ($result === false) {
    die("Error executing the query: " . $stmt->error);
}

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Update profile if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate form data (you can add more validation here)
    if (empty($username) || empty($email)) {
        $error = "Please fill all fields.";
    } else {
        // Check if password is provided and update it
        if (!empty($password)) {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param('sssi', $username, $email, $hashed_password, $user_id);
        } else {
            // If no password change, update just username and email
            $update_sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param('ssi', $username, $email, $user_id);
        }

        // Error checking for SQL preparation
        if ($stmt === false) {
            die("Error preparing the SQL statement: " . $conn->error);
        }

        if ($stmt->execute()) {
            // Success message
            $success = "Profile updated successfully!";
            // Update the $user array with new data directly after update
            $user['username'] = $username;
            $user['email'] = $email;

            // If password was updated, make sure to refresh the session
            if (!empty($password)) {
                $_SESSION['user_id'] = $user_id; // Make sure session persists
            }
        } else {
            $error = "Error updating profile. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Toko Shoes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Your Profile</h2>

    <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
    <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

    <!-- Editable Profile Form -->
    <form method="POST" action="profile.php">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password (Leave empty if you don't want to change it)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Shop</a>
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
