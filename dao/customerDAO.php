<?php
require_once('abstractDAO.php');
require_once('./model/customer.php');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customerDAO
 *
 * @author Matt
 */
class customerDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    public function duplicateEmail($emailAddress){
        if (!$this->mysqli->connect_errno) {
            $query = 'SELECT * FROM mailinglist where emailAddress = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('s', $emailAddress);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return true;
            }
        }
    }

    public function getCustomers(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM mailingList');
        $customers = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new employee object, and add it to the array.
                $customer = new Customer($row['customerName'], $row['emailAddress'], $row['phoneNumber'], $row['referrer'], $row['_id']);
                $customers[] = $customer;
            }
            $result->free();
            return $customers;
        }
        $result->free();
        return false;
    }


    public function getCustomer($customerName){
        $query = 'SELECT * FROM mailingList WHERE _id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $customerName);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $customer = new Customer($temp['customerName'], $temp['phoneNumber'], $temp['emailAddress'], $temp['referrer'], $temp['_id']);
            $result->free();
            return $customer;
        }
        $result->free();
        return false;
    }

    public function addCustomer($customer){

        if(!$this->mysqli->connect_errno){

            $query = 'INSERT into mailingList (customerName, phoneNumber, emailAddress, referrer) VALUES (?,?,?,?)';

            $stmt = $this->mysqli->prepare($query);

            $stmt->bind_param('ssss',
                    $customer->getCustomerName(),
                    $customer->getPhoneNumber(),
                    $customer->getEmailAddress(),
                        $customer->getReferrer());
            $stmt->execute();

            if($stmt->error){
                return $stmt->error;
            } else {
                return $customer->getCustomerName() .' added successfully!';
            }
        } else {
            return 'Could not connect to Database.';
        }
    }
    
    public function deleteCustomer($customerId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM mailingList WHERE _id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $customerId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

     public function editCustomer($customerId, $customerName, $emailAddress, $phoneNumber){
           if(!$this->mysqli->connect_errno){
               $query = 'UPDATE mailingList SET customerName = ?, emailAddress = ?, phoneNumber = ? WHERE _id = ?';
               $stmt = $this->mysqli->prepare($query);
               $stmt->bind_param('sssi', $customerName, $emailAddress, $phoneNumber, $customerId);
               $stmt->execute();
               if($stmt->error){
                   return false;
               } else {
                   return $stmt->affected_rows;
               }
           } else {
               return false;
           }
       }
}

?>
