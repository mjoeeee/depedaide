<?php
require_once 'config.php';
require_once 'query/login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepAIDE</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/login.css">
    <style>


    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <a class="navbar-brand" href="#">
            <img src="image/logo (1).png" alt="Logo" title="Department of Education Portal for Assisting ICT Diagnosis and Enhancement">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <script>
function showMessage() {

    if (window.innerWidth > 768) {
        var messageDiv = document.getElementById("toggleMessage");
        messageDiv.style.display = "block";
    }
}


setTimeout(showMessage, 500);
</script>
    <div id="toggleMessage">
        <h5>
            Department of Education Portal for Assisting 
            <span class="highlight">ICT Diagnosis</span> and 
            <span class="highlight">Enhancement</span>
        </h5>
    </div>
    <div class="login-container">
        <img src="image/deped-ozamiz-2.png" alt="Logo" class="logo">
        <h2>Log in to your account</h2>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login" method="POST">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Log in</button>
        </form>
    </div>
    
        <!-- Footer -->
        <footer class="footer">
            <small>&copy; <?php echo date("Y"); ?> DepAIDE. All Rights Reserved. | DepEdOzamiz ICT Services</small>
        </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.navbar-toggler').click(function() {
                $('#toggleMessage').toggle(); // Show or hide the message
            });
        });
    </script>
</body>
</html>