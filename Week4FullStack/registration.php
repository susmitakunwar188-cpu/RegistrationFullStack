<?php
// Initialize variables
$name = $email = "";
$nameErr = $emailErr = $passErr = $confirmErr = "";
$successMsg = "";
$clearFields = false; // NEW FLAG

// Check submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // NAME VALIDATION
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    // EMAIL VALIDATION
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = htmlspecialchars($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // PASSWORD VALIDATION
    if (empty($_POST["password"])) {
        $passErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 6) {
            $passErr = "Password must be at least 6 characters";
        }
    }

    // CONFIRM PASSWORD VALIDATION
    if (empty($_POST["confirm"])) {
        $confirmErr = "Please confirm password";
    } else {
        $confirm = $_POST["confirm"];
        if ($confirm !== $password) {
            $confirmErr = "Passwords do not match";
        }
    }

    // If all validations pass
    if ($nameErr == "" && $emailErr == "" && $passErr == "" && $confirmErr == "") {
        $successMsg = "Registration Successful!";
        $clearFields = true; // Clear form fields
    }
}

// Clear fields after success
if ($clearFields) {
    $name = "";
    $email = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM REGISTRATION</title>

    <style>
        body{
            background-color: #f7f1e3; /* cream */
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #formContainer{
            background: #fff;
            padding: 30px;
            width: 330px;
            border-radius: 15px;
            border: 2px solid maroon;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h1{
            color: maroon;
            text-align: center;
        }

        label{
            font-weight: bold;
            color: maroon;
        }

        input{
            width: 85%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 12px;
            border: 1px solid maroon;
            border-radius: 8px;
        }

        .password-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .toggle-btn{
            margin-left: 8px;
            font-size: 13px;
            cursor: pointer;
            color: maroon;
            font-weight: bold;
        }

        #btn{
            width: 100%;
            background: maroon;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        #btn:hover{
            background: #8b0000;
        }

        .error{
            color: red;
            font-size: 14px;
        }

        #success{
            text-align: center;
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div id="formContainer">
<h1>Fill the form</h1>

<?php if($successMsg != ""): ?>
    <p id="success"><?php echo $successMsg; ?></p>
<?php endif; ?>

<form method="POST" action="">
    
    <!-- NAME -->
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $name; ?>">
    <span class="error"><?php echo $nameErr; ?></span><br>

    <!-- EMAIL -->
    <label>Email Address:</label><br>
    <input type="text" name="email" value="<?php echo $email; ?>">
    <span class="error"><?php echo $emailErr; ?></span><br>

    <!-- PASSWORD -->
    <label>Password:</label><br>
    <div class="password-container">
        <input type="password" id="password" name="password">
        <span class="toggle-btn" onclick="togglePass('password')">Show</span>
    </div>
    <span class="error"><?php echo $passErr; ?></span><br>

    <!-- CONFIRM PASSWORD -->
    <label>Confirm Password:</label><br>
    <div class="password-container">
        <input type="password" id="confirm" name="confirm">
        <span class="toggle-btn" onclick="togglePass('confirm')">Show</span>
    </div>
    <span class="error"><?php echo $confirmErr; ?></span><br>

    <button id="btn" type="submit">Submit</button>

</form>
</div>

<script>
// Show/Hide Password Function
function togglePass(id){
    let input = document.getElementById(id);
    let btn = input.nextElementSibling;

    if (input.type === "password") {
        input.type = "text";
        btn.textContent = "Hide";
    } else {
        input.type = "password";
        btn.textContent = "Show";
    }
}

// Auto-hide success message after 3 seconds
setTimeout(() => {
    let msg = document.getElementById("success");
    if (msg) {
        msg.style.display = "none";
    }
}, 3000);
</script>

</body>
</html>
