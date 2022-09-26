<?php

class UserController{
    
    //Proprieties

    //Methods
    function signup(){
        // Allow only POST method
        $route = new Router();
        $route->allowedMethod('POST');

        // Get the entries
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = sha1($_POST['pass']);
        $avatar = $_POST['avatar'];
        
        // Validate the entries

        // Execute the query
        $user = new User(null, $name, $email, $pass, $avatar);
        $id = $user->create();

        // Return the result
        $result["success"]["message"] = "User created successfully!";

        $result["user"]["id"] = $id;
        $result["user"]["name"] = $name;
        $result["user"]["email"] = $email;
        $result["user"]["pass"] = $pass;
        $result["user"]["avatar"] = $avatar;

        // Give the html output
        Output::response($result);
    }

    function list(){
        // Allow only GET method
        $route = new Router();
        $route->allowedMethod('GET');

        // Get the entries
        // Validate the entries

        // Execute the query
        $user = new User(null, null, null, null, null);
        $listUsers = $user->list();

        // Return the result
        $result["success"]["message"] = "User list has been successfully listed!";
        $result["data"] = $listUsers;

        // Give the html output
        Output::response($result);
    }

    function byId(){
        // Allow only GET method
        $route = new Router();
        $route->allowedMethod('GET');

        // Validate the entries
        if(isset($_GET['id'])){
            // Get the entries
            $id = $_GET['id'];
        } else {
            // Return error
            $result['error']['message'] = "Parameter ID is required";
            Output::response($result, 406);
        }
        // Execute the query
        $user = new User($id, null, null, null, null);
        $userById = $user->byId();

        // Return the result
        if($userById){
            $result["success"]["message"] = "User has been successfully listed!";
            $result['data'] = $userById;
            Output::response($result);
        } else {
            $result['error']['message'] = "User not found";
            Output::response($result, 404);
        }

    }

    function delete(){
        $route = new Router();
        $route->allowedMethod('DELETE');
        
        //get json input by body json
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);

        if(isset($data['id'])){
            $id = $data['id'];
        } else {
            $result['error']['message'] = "Id parameter required!";
            Output::response($result, 406);
        }

        $user = new User($id, null, null, null, null);
        $deleted = $user->delete();

        if($deleted){
            $result["success"]["message"] = "User $id deleted successfully!";
            Output::response($result);
        } else {
            $result["error"]["message"] = "User $id not found to be deleted!";
            Output::response($result, 404);
        }
    }
    
}

?>