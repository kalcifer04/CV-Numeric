<?php

    $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false );

    $emailTo = "r.calcifer@gmail.com";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $array["firstname"] = verifyInput($_POST["firstname"]);
        $array["name"] = verifyInput($_POST["name"]);
        $array["email"] = verifyInput($_POST["email"]);
        $array["phone"] = verifyInput($_POST["phone"]);
        $array["message"] = verifyInput($_POST["message"]);
        $array["isSuccess"] = true;
        $emailText = "";
        
        if(empty($array["name"])){
            $array["nameError"] = "Et oui je veux tout savoir, même ton nom !";
            $array["isSuccess"] = false;
        }
        else{
            $emailText .= "Nom: {$array["name"]}\n";
        }
        
        if(empty($array["firstname"])){
            $array["firstnameError"] = "Ton prénom est important pour moi !";
            $array["isSuccess"] = false;
        }
        else{
            $emailText .= "Prénom: {$array["firstname"]}\n";
        }
        
        if(!isPhone($array["phone"])){
            $array["phoneError"] = "Que des chiffres et des espaces, stp...";
            $array["isSuccess"] = false;
        }
        else{
            $emailText .= "Tel: {$array["phone"]}\n";
        }
        
        if(!isEmail($array["email"])){
            $array["emailError"] = "J'ai besoin de ton email, pour pouvoir te répondre !";
            $array["isSuccess"] = false;
        }
        else{
            $emailText .= "Email: {$array["email"]}\n";
        }
        
        if(empty($array["message"])){
            $array["messageError"] = "Que voulais tu me dire ?";
            $array["isSuccess"] = false;
        }
        else{
            $emailText .= "Message: {$array["message"]}\n";
        }
         
        if($array["isSuccess"]){
            $headers = "From: {$array["name"]} {$array["firstname"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}";
            mail($emailTo, "Message du cv en ligne", $emailText, $headers);
        }
        
        echo json_encode($array);
        
    }

    function isPhone($var){
        
        return preg_match("/^[0-9 ]*$/", $var);
    }

    function isEmail($var){
        
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function verifyInput($var){
        
        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var);
        return $var;
    }

?>

