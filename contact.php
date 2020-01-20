<?php include "header.php";
require_once('./dao/customerDAO.php');
require_once('./model/customer.php');

try {
     $customerDAO = new customerDAO();
    $hasError = false;
    $errorMessages = Array();

    if (isset($_POST['customerName']) ||
        isset($_POST['phoneNumber']) ||
        isset($_POST['referrer']) ||
        isset($_POST['emailAddress'])) {

        if ($_POST['customerName'] == "") {
            $hasError = true;
            $errorMessages['customerNameError'] = 'Please enter a Name.';
        }
        else if (!preg_match("/^[a-zA-Z ,.'\\-]+$/", $_POST['customerName'])){
            $hasError = true;
            $errorMessages['invalidName'] = 'Name can only contain alphabetic characters.';
        }

        if ($_POST['phoneNumber'] == "") {
            $errorMessages['phoneNumberError'] = "Please enter a Phone number.";
            $hasError = true;
        }
        else if (!preg_match("/(^[0-9]{10}$)/", $_POST['phoneNumber'])){
            $hasError = true;
            $errorMessages['invalidNumber'] = 'Phone Number is invalid.';
        }

        if ($_POST['emailAddress'] == "") {
            $errorMessages['emailAddressError'] = "Please enter a Email Address.";
            $hasError = true;
        }
        else if (!preg_match("/^([a-zA-Z0-9.])+\@([a-zA-Z0-9])+\.([a-zA-Z]{2,3})$/", $_POST['emailAddress'])){
            $hasError = true;
            $errorMessages['invalidEmail'] = 'Email is invalid.';
        }
        else if ($customerDAO->duplicateEmail($_POST['emailAddress'])){
        $hasError = true;
        $errorMessages['duplicateError'] = 'E-mail already registered';
        }

        // Reference: https://www.regular-expressions.info/email.html

        if (!$hasError) {
            $email = $_POST['emailAddress'];
            $emailhash = password_hash($email,PASSWORD_DEFAULT);
            $customer = new Customer($_POST['customerName'], $_POST['phoneNumber'], $emailhash , $_POST['referrer'], "");
            $addSuccess = $customerDAO->addCustomer($customer);
            echo '<p style="color:green; text-align:center">' . $addSuccess . '</p>';
        }
    }

    if(isset($_POST["fileSubmit"])){
        $path = 'files/';
        $upload_file = $path.basename($_FILES['fileup']['name']);

        if(move_uploaded_file($_FILES['fileup']['tmp_name'], $upload_file)){
            echo "<script>alert('File uploaded successfully!');</script>";
        } else {
            echo "<script>alert('Failed!');</script>";
        }
    }

}
catch (Exception $e){
    echo '<h3>Error on page.</h3>';
    echo '<p>' . $e->getMessage() . '</p>';
}

?>

                <aside>
                        <h2>Mailing Address</h2>
                        <h3>1385 Woodroffe Ave<br>
                            Ottawa, ON K4C1A4</h3>
                        <h2>Phone Number</h2>
                        <h3>(613)727-4723</h3>
                        <h2>Fax Number</h2>
                        <h3>(613)555-1212</h3>
                        <h2>Email Address</h2>
                        <h3>info@wpeatery.com</h3>
                </aside>
                <div class="main">
                    <h1>Sign up for our newsletter</h1>
                    <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
                    <form name="frmNewsletter" id="frmNewsletter" method="post" action="contact.php">
                        <table style="padding:10px;">
                            <tr>
                                <td>Name:</td>
                                <td><input type="text" name="customerName" id="customerName" size='40'>
                                <?php
                                if(isset($errorMessages['customerNameError'])){
                                    echo "<br><span style='color:red; font-size:12px'>" . $errorMessages['customerNameError'] . "</span>";
                                }
                                else if(isset($errorMessages['invalidName'])){
                                    echo "<br><span style='color:red; font-size:12px'>" . $errorMessages['invalidName'] . "</span>";
                                }
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td><input type="text" name="phoneNumber" id="phoneNumber" size='40'>
                                <?php
                                    if(isset($errorMessages['phoneNumberError'])){
                                        echo "<br><span style='color:red; font-size:12px'>" . $errorMessages['phoneNumberError'] . "</span>";
                                    }
                                    else if(isset($errorMessages['invalidNumber'])){
                                        echo "<br><span style='color:red; font-size:12px'>" . $errorMessages['invalidNumber'] . "</span>";
                                    }
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><input type="text" name="emailAddress" id="emailAddress" size='40'>
                                    <?php
                                        if(isset($errorMessages['emailAddressError'])){
                                            echo "<br><span style='color:red; font-size:12px'>" . $errorMessages['emailAddressError'] . "</span>";
                                        }
                                        else if(isset($errorMessages['invalidEmail'])){
                                            echo "<br><span style='color:red; font-size:12px'>" . $errorMessages['invalidEmail'] . "</span>";
                                        }
                                        else if(isset($errorMessages['duplicateError'])){
                                            echo "<br><span style='color:red; font-size:12px'>" . $errorMessages['duplicateError'] . "</span>";
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>How did you hear<br> about us?</td>
                                <td>Newspaper<input type="radio" name="referrer" id="referralNewspaper" value="newspaper">
                                    Radio<input type="radio" name='referrer' id='referralRadio' value='radio'>
                                    TV<input type='radio' name='referrer' id='referralTV' value='TV'>
                                    Other<input type='radio' name='referrer' id='referralOther' value='other' checked>
                                    <?php
/*                                    if(isset($errorMessages['referrerError'])){
                                        echo "<br><span style='color:red; font-size:12px'>" . $errorMessages['referrerError'] . "</span>";
                                    }
                                    */?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input type='reset' name="btnReset" id="btnReset" value="Reset Form"></td>
                            </tr>
                        </table>
                    </form>
                    <form action="contact.php" method="post" enctype="multipart/form-data">
                        <table>
                        <tr>
                            <td>Select files to upload: </td>
                            <td><input type="file" name="fileup" id="fileup"></td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Upload file" name="fileSubmit"></td>
                        </tr>
                        </table>
                    </form>
                </div><!-- End Main -->
				
<?php include "footer.php" ?>
           