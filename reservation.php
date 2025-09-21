<!--this is my reservation page that will handle form and submission-->
<?php
//including my database and my header
require_once 'db_connect.php';
include 'includes/header.php';

//this variable will messages for the user
$message = '';

//checking if the form was submitted by POST methods
//this is checked only after the user submits a form, if it passes it inserts the reservation into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    //each form field is placed into a variable
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];
    $requests = $_POST['special_requests'];
    
    //if statement to check if the field is empty, and displays message to fill the field
    if (empty($name) || empty($email) || empty($date) || empty($time) || empty($guests)) 
    {
        //error message if it fails
        $message = '<div class="error">Please fill all required fields.</div>';
    } 
    else 
    {
        //if validation passes, creates an sql insert statement
        $sql = "INSERT INTO reservations (customer_name, email, phone, reservation_date, reservation_time, party_size, special_requests) 
                VALUES ('$name', '$email', '$phone', '$date', '$time', $guests, '$requests')";
        //checking if query is successful
        if ($conn->query($sql) === TRUE) 
        {
            //if its successful, displays this message
            $message = '<div class="success">Your reservation has been submitted! We will contact you to confirm.</div>';
        } else 
        {
            //if not successful, displays this message
            $message = '<div class="error">Error: ' . $conn->error . '</div>';
        }
    }
}
?>

<!--container for whole reservation section -->
<section class="reservation-page">
    <h2>Make a Reservation</h2>
    
    <!--this displays any success or error messages -->
    <?php echo $message; ?>
    
    <!--creating a form that will submit to the same page -->
    <form method="POST" action="" class="reservation-form">

        <!-- forms fields for name, email,phone,date,time,numberofguests and special requests -->
         <!-- each group has a lbel and is in a form-group for styling -->
        <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone">
        </div>
        
        <div class="form-group">
            <label for="date">Date *</label>
            <!-- required, to prevent submission if field is empty-->
            <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
        </div>
        
        <div class="form-group">
            <label for="time">Time *</label>
            <select id="time" name="time" required>
                <option value="">Select a time</option>
                <option value="17:00">5:00 PM</option>
                <option value="17:30">5:30 PM</option>
                <option value="18:00">6:00 PM</option>
                <option value="18:30">6:30 PM</option>
                <option value="19:00">7:00 PM</option>
                <option value="19:30">7:30 PM</option>
                <option value="20:00">8:00 PM</option>
                <option value="20:30">8:30 PM</option>
                <option value="21:00">9:00 PM</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="guests">Number of Guests *</label>
            <!-- i placed a minumum and maximum number of guests-->
            <input type="number" id="guests" name="guests" min="1" max="20" required>
        </div>
        
        <div class="form-group">
            <label for="special_requests">Special Requests</label>
            <textarea id="special_requests" name="special_requests" rows="4"></textarea>
        </div>
        
        <button type="submit" class="btn">Submit Reservation</button>
    </form>
    
    <!--information about the reservation policies, just made them up-->
    <div class="reservation-info">
        <h3>Reservation Information</h3>
        <p>Please note that reservations are held for 15 minutes past the reservation time.</p>
        <p>For parties larger than 8, please call us directly at (353) 456-7890.</p>
        <p>We require 24-hour notice for cancellations.</p>
    </div>
</section>

<!-- including the footer-->
<?php include 'includes/footer.php'; ?>