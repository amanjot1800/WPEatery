<?php
require_once('./dao/customerDAO.php');
if(isset($_GET['action'])){
    if($_GET['action'] == "edit"){
        if(isset($_POST['customerId']) && 
                isset($_POST['customerName']) &&
            isset($_POST['emailAddress']) &&
            isset($_POST['phoneNumber'])){
        
        if(is_numeric($_POST['customerId']) &&
                $_POST['customerName'] != "" &&
                $_POST['emailAddress'] != "" &&
                $_POST['phoneNumber'] != ""){
               
                $customerDAO = new customerDAO();
                $result = $customerDAO->editCustomer($_POST['customerId'], 
                        $_POST['customerName'], $_POST['emailAddress'], $_POST['phoneNumber']);
                

                if($result > 0){
                    header('Location:edit_customer.php?recordsUpdated='.$result.'&customerId=' . $_POST['customerId']);
                } else {
                    header('Location:edit_customer.php?customerId=' . $_POST['customerId']);
                }
            } else {
                header('Location:edit_customer.php?missingFields=true&customerId=' . $_POST['customerId']);
            }
        } else {
            header('Location:edit_customer.php?error=true&customerId=' . $_POST['customerId']);
        }
    }
    
    if($_GET['action'] == "delete"){
        if(isset($_GET['customerId']) && is_numeric($_GET['customerId'])){
            $customerDAO = new customerDAO();
            $success = $customerDAO->deleteCustomer($_GET['customerId']);
            echo $success;
            if($success){
                header('Location:mailing_list.php?deleted=true');
            } else {
                header('Location:mailing_list.php?deleted=false');
            }
        }
    }
}
?>
