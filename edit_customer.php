<?php include "header.php";
require_once('./dao/customerDAO.php');
require_once('WebsiteUser.php');

session_start();
session_regenerate_id(false);
//echo "Session ID: " . session_id() . "\n";

if(isset($_SESSION['websiteUser'])){
    if(!$_SESSION['websiteUser']->isAuthenticated()){
        header('Location:login.php');
    }
} else {
    header('Location:login.php');
}


if (!isset($_GET['customerId'])) {
    header("Location: index.php");
    exit;

} else {
    $customerDAO = new customerDAO();
    $customer = $customerDAO->getCustomer($_GET['customerId']);
    if ($customer) {
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Week 11 - Edit Customer - <?php echo $customer->getCustomerName(); ?></title>
            <script type="text/javascript">
                function confirmDelete(customerName) {
                    return confirm("Do you wish to delete " + customerName + "?");
                }
            </script>
        </head>
        <body>

        <?php
        if (isset($_GET['recordsUpdated'])) {
            if (is_numeric($_GET['recordsUpdated'])) {
                echo '<p style="color: green; text-align: center"> ' . $_GET['recordsUpdated'] . ' Customer Record Updated.</p>';
            }
        }
        if (isset($_GET['missingFields'])) {
            if ($_GET['missingFields']) {
                echo '<h3 style="color:red;"> Please enter both first and last names.</h3>';
            }
        }
        ?>
        <br>
        <h3 style="text-align: center">Edit Customer</h3>

        <?php

        $errorMessages = Array();
        $hasError = false;

        if (isset($_POST['customerName']) ||
            isset($_POST['phoneNumber']) ||
            isset($_POST['emailAddress'])) {

            $action = '';
            $redirect = 'f';



            if ($_POST['customerName'] == "") {
                $hasError = true;
                $errorMessages['customerNameError'] = 'Please enter a Name.';
            } else if (!preg_match("/^[a-zA-Z ,.'\\-]+$/", $_POST['customerName'])) {
                $hasError = true;
                $errorMessages['invalidName'] = 'Name can only contain alphabetic characters.';
            }

            if ($_POST['phoneNumber'] == "") {
                $errorMessages['phoneNumberError'] = "Please enter a Phone number.";
                $hasError = true;
            } else if (!preg_match("/(^[0-9]{10}$)/", $_POST['phoneNumber'])) {
                $hasError = true;
                $errorMessages['invalidNumber'] = 'Phone Number is invalid.';
            }

            if ($_POST['emailAddress'] == "") {
                $errorMessages['emailAddressError'] = "Please enter a Email Address.";
                $hasError = true;
            }

        }
            if($hasError){
                $redirect = "t";
            }
            else{
                $redirect = "f";
            }

        if(isset($redirect) && $redirect == "t") {
            $action = "process_customer.php?action=edit";
        } else {
            $action = "#";
        }

        ?>


        <form name="editCustomer" method="post" action="<?php echo $action; ?>">
            <table style="margin:20px auto 20px auto">
                <tr>
                    <td>Customer ID:</td>
                    <td><input type="hidden" name="customerId" id="customerId"
                               value="<?php echo $customer->getCustomerId(); ?>"><?php echo $customer->getCustomerId(); ?>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td><input type="text" name="customerName" id="customerName"
                               value="<?php echo $customer->getCustomerName(); ?>">
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
                    <td><input type="text" name="phoneNumber" id="phoneNumber"
                               value="<?php echo $customer->getPhoneNumber(); ?>">
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
                    <td><input type="text" name="emailAddress" id="emailAddress"
                               value="<?php echo $customer->getEmailAddress(); ?>">
                        <?php
                        if(isset($errorMessages['emailAddressError'])){
                            echo "<br><span style='color:red; font-size:12px'>" . $errorMessages['emailAddressError'] . "</span>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><a onclick="return confirmDelete('<?php echo $customer->getCustomerName(); ?>')"
                                       href="process_customer.php?action=delete&customerId=<?php echo $customer->getCustomerId(); ?>">DELETE <?php echo $customer->getCustomerName(); ?></a>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Update Customer"></td>
                    <td><input type="reset" name="btnReset" id="btnReset" value="Reset to original"></td>
                </tr>
            </table>
        </form>
        <p style="text-align: center; font-size: 15px"><a href="index.php">Back to main page</a></p>
        <p style='text-align: center'><a href='logout.php'>Logout!</a></p>
        </body>
        </html>
        <?php

    } else {
        header("Location: index.php");
        exit;
    }

} ?>
<?php include "footer.php" ?>
