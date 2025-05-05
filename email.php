<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $content = htmlspecialchars($_POST["content"]);
    
    // Basic validation
    $errors = [];
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address";
    }
    
    if (empty($content)) {
        $errors[] = "Message content is required";
    }
    
    // Process if no errors
    if (empty($errors)) {
        // Email recipient (your email)
        $to = "olya@olya.org"; // REPLACE WITH YOUR EMAIL
        
        // Email subject
        $subject = "New Form Submission from Website";
        
        // Email content
        $message = "You have received a new form submission:\n\n";
        $message .= "Name: " . $name . "\n\n";
        $message .= "Email: " . $email . "\n\n";
        $message .= "Message: " . $content . "\n";
        
        $message .= "Event name: " . $eventname . "\n";
        $message .= "Event type: " . $type . "\n";
        
        // Email headers
        $headers = "From: webform@" . $_SERVER['HTTP_HOST'] . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        // Send email
        if (mail($to, $subject, $message, $headers)) {
            echo json_encode(["success" => true, "message" => "Thank you! Your message has been sent."]);
        } else {
            echo json_encode(["success" => false, "message" => "Sorry, there was an error sending your message."]);
        }
    } else {
        // Return validation errors
        echo json_encode(["success" => false, "message" => implode("<br>", $errors)]);
    }
} else {
    // Not a POST request
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>