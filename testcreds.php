<?php
// Emma Thompson
$email1 = 'emma.thompson@techuniv.edu';
$password1 = 'SecurePass123!';
$hashed1 = password_hash($password1, PASSWORD_DEFAULT);

// Liam Chen
$email2 = 'liam.chen@techuniv.edu';
$password2 = 'CyberSecure@2023';
$hashed2 = password_hash($password2, PASSWORD_DEFAULT);

// Ava Rodriguez
$email3 = 'ava.rodriguez@techuniv.edu';
$password3 = 'DataScienceRocks#';
$hashed3 = password_hash($password3, PASSWORD_DEFAULT);

// Output for Emma
echo "<div class='student-creds'>";
echo "<h3>Emma Thompson</h3>";
echo "<p><strong>Email:</strong> " . $email1 . "</p>";
echo "<p><strong>Password:</strong> " . $password1 . "</p>";
echo "<p><strong>Hashed Password:</strong> " . $hashed1 . "</p>";
echo "<p><strong>Phone:</strong> +1 (555) 123-4567</p>";
echo "<p><strong>Course:</strong> Artificial Intelligence</p>";
echo "<hr>";

// Output for Liam
echo "<h3>Liam Chen</h3>";
echo "<p><strong>Email:</strong> " . $email2 . "</p>";
echo "<p><strong>Password:</strong> " . $password2 . "</p>";
echo "<p><strong>Hashed Password:</strong> " . $hashed2 . "</p>";
echo "<p><strong>Phone:</strong> +1 (555) 987-6543</p>";
echo "<p><strong>Course:</strong> Cybersecurity</p>";
echo "<hr>";

// Output for Ava
echo "<h3>Ava Rodriguez</h3>";
echo "<p><strong>Email:</strong> " . $email3 . "</p>";
echo "<p><strong>Password:</strong> " . $password3 . "</p>";
echo "<p><strong>Hashed Password:</strong> " . $hashed3 . "</p>";
echo "<p><strong>Phone:</strong> +1 (555) 456-7890</p>";
echo "<p><strong>Course:</strong> Data Science</p>";
echo "</div>";

// CSS for better display
echo "<style>
    .student-creds {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 800px;
        margin: 30px auto;
        padding: 25px;
        border: 1px solid #e1e4e8;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .student-creds h3 {
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 10px;
        margin-top: 0;
    }
    .student-creds p {
        margin: 12px 0;
        line-height: 1.7;
        font-size: 16px;
    }
    .student-creds strong {
        display: inline-block;
        width: 160px;
        color: #2c3e50;
        font-weight: 600;
    }
    hr {
        margin: 25px 0;
        border: 0;
        border-top: 1px solid #ecf0f1;
    }
    body {
        background-color: #f8f9fa;
        color: #343a40;
        padding: 20px;
    }
</style>";
?>