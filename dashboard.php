<?php
session_start();
include 'database.php';
include 'userController.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

$db = (new Database())->getConnection();
$userController = new UserController($db);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["edit"])) {
    $id = $_GET["edit"];
    $user = $userController->read($id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $room = $_POST["room"];
    $userController->update($id, $name, $email, $room);
    header("location: dashboard.php");
    exit();
}

$users = $userController->readAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Dashboard</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            margin-top: 20px;
        }

        .form-container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>

        <div class="table-container">
            <h3 class="text-center mb-3">All Users</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Room</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user["name"]); ?></td>
                                    <td><?php echo htmlspecialchars($user["email"]); ?></td>
                                    <td><?php echo htmlspecialchars($user["room"]); ?></td>
                                    <td>
                                        <a href="dashboard.php?edit=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="dashboard.php?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (isset($_GET["edit"])): ?>
            <div class="form-container">
                <h3 class="text-center mb-3">Edit User</h3>
                <form action="dashboard.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="room" class="form-label">Room:</label>
                        <select id="room" name="room" class="form-select">
                            <option value="Application1" <?php echo $user['room'] == 'Application1' ? 'selected' : ''; ?>>Application1</option>
                            <option value="Application2" <?php echo $user['room'] == 'Application2' ? 'selected' : ''; ?>>Application2</option>
                            <option value="cloud" <?php echo $user['room'] == 'cloud' ? 'selected' : ''; ?>>Cloud</option>
                        </select>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>