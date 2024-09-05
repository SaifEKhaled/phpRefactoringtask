<?php
include 'database.php';
include 'userController.php';

$db = (new Database())->getConnection();
$userController = new UserController($db);

$name = $email = $password = $confirm_password = $room = "";
$name_err = $email_err = $password_err = $confirm_password_err = $room_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm your password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Passwords do not match.";
        }
    }

    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $userController->create($name, $email, $password, $room);
        header("location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Register</title>
</head>

<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow border-0 rounded-lg">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Register</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control" id="floatingName" placeholder="Name" value="<?php echo htmlspecialchars($name); ?>">
                                <label for="floatingName">Name</label>
                                <div class="text-danger"><?php echo $name_err; ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="email" class="form-control" id="floatingEmail" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                                <label for="floatingEmail">Email</label>
                                <div class="text-danger"><?php echo $email_err; ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                <div class="text-danger"><?php echo $password_err; ?></div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" name="confirm_password" class="form-control" id="floatingConfirmPassword" placeholder="Confirm Password">
                                <label for="floatingConfirmPassword">Confirm Password</label>
                                <div class="text-danger"><?php echo $confirm_password_err; ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="room" class="form-label">Room:</label>
                                <select id="room" name="room" class="form-select">
                                    <option value="Application1">Application1</option>
                                    <option value="Application2">Application2</option>
                                    <option value="cloud">Cloud</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-lg" type="submit">Register</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Already have an account? <a href="login.php">Login here</a>.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
