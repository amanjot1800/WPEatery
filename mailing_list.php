<?php include "header.php";

require_once('WebsiteUser.php');
require_once('./dao/customerDAO.php');
require_once('./model/customer.php');


session_start();
session_regenerate_id(false);
echo "Session ID: " . session_id() ;
echo "<br>";

if(isset($_SESSION['websiteUser'])){
    if(!$_SESSION['websiteUser']->isAuthenticated()){
        header('Location:login.php');
    }
    echo "Admin ID = ".$_SESSION['AdminID'];
    echo "<br>Last Login = ".$_SESSION['lastlogin'];

} else {
    header('Location:login.php');
}


try {
    $customerDAO = new customerDAO();
    $customers = $customerDAO->getCustomers();
    if ($customers) {

        if(isset($_GET['deleted'])){
            if($_GET['deleted'] == true){
                echo '<p style="text-align: center; color: green">Customer Deleted</p>';
            }
        }

        echo '<table style="margin:20px auto 20px auto; table-layout: fixed"  cellpadding="13" border=\'1\'>';
        echo '<tr><th>ID</th><th>Customer Name</th><th>Phone Number</th><th>Email Address</th><th>Referrer</th></tr>';
        foreach ($customers as $customer) {
            echo '<tr>';
            echo '<td><a href=\'edit_customer.php?customerId=' . $customer->getCustomerId() . '\'>' . $customer->getCustomerId() . '</a></td>';
            echo '<td>' . $customer->getCustomerName() . '</td>';
            echo '<td>' . $customer->getEmailAddress() . '</td>';
            echo '<td style="word-break:break-word";>' . $customer->getPhoneNumber() . '</td>';
            echo '<td>' . $customer->getReferrer() . '</td>';
            echo '</tr>';

        }
        echo '</table>';
        echo "<p style='text-align: center'><a href='logout.php'>Logout!</a></p>";

    }

}
catch (Exception $e){
    echo '<h3>Error on page.</h3>';
    echo '<p>' . $e->getMessage() . '</p>';
}

include "footer.php"

?>
