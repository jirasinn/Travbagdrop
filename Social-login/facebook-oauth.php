<?php

// Database connection variables
$db_host = 'localhost';
$db_name = 'bagdrop';
$db_user = 'root';
$db_pass = '';
// Attempt to connect to database
try {
    // Connect to the MySQL database using PDO...
    $pdo = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    // Could not connect to the MySQL database, if this error occurs make sure you check your db settings are correct!
    exit('Failed to connect to database!');
}

session_start();
// Update the following variables
$facebook_oauth_app_id = '453019957227165';
$facebook_oauth_app_secret = '529ba3b791436b78584b632f8fb13b25';
// Must be the direct URL to the facebook-oauth.php file
$facebook_oauth_redirect_uri = 'http://localhost/travbagdrop/Social-login/facebook-oauth.php';
$facebook_oauth_version = 'v19.0';

// If the captured code param exists and is valid
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Execute cURL request to retrieve the access token
    $params = [
        'client_id' => $facebook_oauth_app_id,
        'client_secret' => $facebook_oauth_app_secret,
        'redirect_uri' => $facebook_oauth_redirect_uri,
        'code' => $_GET['code']
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/oauth/access_token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response, true);
} else {
    // Define params and redirect to Facebook OAuth page
    $params = [
        'client_id' => $facebook_oauth_app_id,
        'redirect_uri' => $facebook_oauth_redirect_uri,
        'response_type' => 'code',
        'scope' => 'email'
    ];
    header('Location: https://www.facebook.com/dialog/oauth?' . http_build_query($params));
    exit;
}

// Make sure access token is valid
if (isset($response['access_token']) && !empty($response['access_token'])) {
    // Execute cURL request to retrieve the user info associated with the Facebook account
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/' . $facebook_oauth_version . '/me?fields=name,email,picture');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
    $response = curl_exec($ch);
    curl_close($ch);
    $profile = json_decode($response, true);
    // Make sure the profile data exists
    if (isset($profile['email'])) {
        // Check if the account exists in the database
        $stmt = $pdo->prepare('SELECT * FROM register WHERE m_email = ?');
        $stmt->execute([$profile['email']]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);
        // If the account does not exist in the database, insert the account into the database
        if (!$account) {
            // Download and store the profile picture locally
            $imgData = file_get_contents($profile['picture']['data']['url']);
            $imgName = 'profile_picture_' . $profile['id'] . '.jpg'; // Generate a unique image name
            file_put_contents('../images/usr_img/' . $imgName, $imgData); // Replace 'path_to_store/' with the directory where you want to store the image
            $imgPath = $imgName; // Store the image path in the database

            // Insert the account into the database
            $stmt = $pdo->prepare('INSERT INTO register (m_email, name, urole , usr_img, registered, method) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$profile['email'], $profile['name'], 'member', $imgPath, date('Y-m-d H:i:s'), 'facebook']);
            $id = $pdo->lastInsertId();

            session_regenerate_id();
            $_SESSION['facebook_loggedin'] = TRUE;
            $_SESSION['bagdrop_member_id'] = $id;
            $_SESSION['bagdrop_member_id_type'] = 'member';
            // Redirect to the add-information page with the inserted ID
            header('Location: /travbagdrop/?page=add-information&id=' . $id);
            exit; // Make sure to exit after header redirect
        } else {
            $id = $account['m_id'];
            $urole = $account['urole'];
        }
        // Authenticate the account
        session_regenerate_id();
        $_SESSION['facebook_loggedin'] = TRUE;
        $_SESSION['bagdrop_member_id'] = $id;
        $_SESSION['bagdrop_member_id_type'] = $urole;
        // Redirect to the home page
        header('Location: /travbagdrop/?page=home');
        exit; // Make sure to exit after header redirect
    } else {
        exit('Could not retrieve profile information! Please try again later!');
    }
}
