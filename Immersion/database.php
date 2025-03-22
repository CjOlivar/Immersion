<?php
define('USERS_FILE', 'data/users.json');
define('USER_DETAILS_FILE', 'data/user_details.json');

function init_data_storage() {
    if (!file_exists('data')) {
        mkdir('data', 0755);
    }    
    if (!file_exists(USERS_FILE)) {   
        $default_user = [
            [
                'id' => 1,
                'username' => 'user',
                'password' => '$2y$10$V7rGl10HXW4mCg8PQa/8Jer1d8ZPZu6Py9NjnTBgQVcSPi8.e7/LO', 
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        file_put_contents(USERS_FILE, json_encode($default_user, JSON_PRETTY_PRINT));
        chmod(USERS_FILE, 0644);
    } 
    if (!file_exists(USER_DETAILS_FILE)) {
        file_put_contents(USER_DETAILS_FILE, json_encode([]));
        chmod(USER_DETAILS_FILE, 0644);
    }
}
function get_users() {
    init_data_storage();
    $json = file_get_contents(USERS_FILE);
    return json_decode($json, true) ?: [];
}
function save_users($users) {
    init_data_storage();
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
}
function get_user_by_username($username) {
    $users = get_users();
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return $user;
        }
    }
    return null;
}
function get_user_by_id($id) {
    $users = get_users();
    foreach ($users as $user) {
        if ($user['id'] === $id) {
            return $user;
        }
    }
    return null;
}
function get_user_details() {
    init_data_storage();
    $json = file_get_contents(USER_DETAILS_FILE);
    return json_decode($json, true) ?: [];
}
function save_user_details($details) {
    init_data_storage();
    file_put_contents(USER_DETAILS_FILE, json_encode($details, JSON_PRETTY_PRINT));
}
function get_details_by_user_id($user_id) {
    $details = get_user_details();
    foreach ($details as $detail) {
        if ($detail['user_id'] === $user_id) {
            return $detail;
        }
    }
    return null;
}
function save_user_detail($user_id, $full_name, $age, $gender, $email, $phone) {
    $details = get_user_details();
    $found = false;  
    foreach ($details as &$detail) {
        if ($detail['user_id'] === $user_id) {
            $detail['full_name'] = $full_name;
            $detail['age'] = $age;
            $detail['gender'] = $gender;
            $detail['email'] = $email;
            $detail['phone'] = $phone;
            $detail['updated_at'] = date('Y-m-d H:i:s');
            $found = true;
            break;
        }
    }    
    if (!$found) {
        
        $max_id = 0;
        foreach ($details as $detail) {
            if ($detail['id'] > $max_id) {
                $max_id = $detail['id'];
            }
        }
        $new_id = $max_id + 1;
        
        $details[] = [
            'id' => $new_id,
            'user_id' => $user_id,
            'full_name' => $full_name,
            'age' => $age,
            'gender' => $gender,
            'email' => $email,
            'phone' => $phone,
            'updated_at' => date('Y-m-d H:i:s')
        ];
    }  
    save_user_details($details);
    return true;
}
?>