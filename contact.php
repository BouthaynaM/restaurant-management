<!--this page will handle the display and processing of the contact form-->
<?php
//including the database and the header
require_once 'db_connect.php';
include 'includes/header.php';

//variable to display the messages to the user
$message = '';

//form submission are processed using POST method
//this will only execute once the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    //getting the inputs from the form and placing them in variables
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $msg = $_POST['message'];
    
    //checking if the fields are empty
    if (empty($name) || empty($email) || empty($msg)) 
    {
        $message = '<div class="error">Please fill all required fields.</div>';
    } 
    else 
    {
        //if the fields arent empty, it stores it into the contact_messages table
        $sql = "INSERT INTO contact_messages (name, email, subject, message) 
                VALUES ('$name', '$email', '$subject', '$msg')";
        
        //if it was succesful, it displays a sucess message
        if ($conn->query($sql) === TRUE) 
        {
            $message = '<div class="success">Your message has been sent! We will get back to you soon.</div>';
        }
        //if it was unsuccessful it displays an error message
        else 
        {
            $message = '<div class="error">Error: ' . $conn->error . '</div>';
        }
    }
}
?>

<!--this contact section will have the information such as the address,hours,phone,email-->
<section class="contact-page">
    <!--main page heading-->
    <h2 class="section-header">Contact Us</h2>
    
    <!--outputs any success or error message-->
    <?php echo $message; ?>
    
    <!--contact container that will hold the two column layout-->
    <div class="contact-container">
        <!--left column-->
        <div class="contact-info">
            <h3>Our Information</h3>
            
            <!-- organising sections with info-item for each type of information-->
            <div class="info-item">
                <h4>Address</h4>
                <p>123 Main Street<br>Ireland, D12 MYHI</p>
            </div>
            
            <div class="info-item">
                <h4>Hours</h4>
                <p>Monday - Friday: 11:00 AM - 10:00 PM<br>
                Saturday - Sunday: 10:00 AM - 11:00 PM</p>
            </div>
            
            <div class="info-item">
                <h4>Contact</h4>
                <p>Phone: (353) 456-7890<br>
                Email: BouResturaunt@gmail.com</p>
            </div>
        </div>
        
        <!-- right column containing the form-->
        <div class="contact-form-container">
            <h3>Send Us a Message</h3>
            
            <!--creates a form that submits to the same page-->
            <!--form field has name,email,subject and message-->
            <form method="POST" action="" class="contact-form">
                <div class="form-group">
                    <!--required field are makred with an astericks-->
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject">
                </div>
                
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </div>
</section>

<!--including the footer-->
<?php include 'includes/footer.php'; ?>