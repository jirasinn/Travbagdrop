<?php
include('../libs/connect.class.php');
    $db = new ConnectDb();
    $conn = $db->getConn();

// Attempt to connect to database
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// Update the following variables
$google_oauth_client_id = '936643781090-ui8cunu4fc8k3qn8et0d1h3hvgg8mhfh.apps.googleusercontent.com';
$google_oauth_client_secret = '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';
$google_oauth_redirect_uri = 'http://localhost/travbagdrop/Social-login/google-oauth.php';
$google_oauth_version = 'v3';

// If the captured code param exists and is valid
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Execute cURL request to retrieve the access token
    $params = [
        'code' => $_GET['code'],
        'client_id' => $google_oauth_client_id,
        'client_secret' => $google_oauth_client_secret,
        'redirect_uri' => $google_oauth_redirect_uri,
        'grant_type' => 'authorization_code'
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response, true);
    // Make sure access token is valid
    if (isset($response['access_token']) && !empty($response['access_token'])) {
        // Execute cURL request to retrieve the user info associated with the Google account
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/' . $google_oauth_version . '/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
        $response = curl_exec($ch);
        curl_close($ch);
        $profile = json_decode($response, true);
        // Make sure the profile data exists
        if (isset($profile['email'])) {
            // Check if the account exists in the database
            $sql = "SELECT * FROM register WHERE m_email = '" . $profile['email'] . "'";
            $result = mysqli_query($conn, $sql);
            $account = mysqli_fetch_assoc($result);

            // If the account does not exist in the database, insert the account into the database
            if (!$account) {
                $google_name_parts = [];
                $google_name_parts[] = isset($profile['given_name']) ? preg_replace('/[^a-zA-Z0-9]/s', '', $profile['given_name']) : '';
                $google_name_parts[] = isset($profile['family_name']) ? preg_replace('/[^a-zA-Z0-9]/s', '', $profile['family_name']) : '';

                $image_filename = '';

                if (isset($profile['picture'])) {
                    // Download image and store locally
                    $image_url = $profile['picture'];
                    $image_data = file_get_contents($image_url);
                    $image_info = getimagesizefromstring($image_data);

                    if ($image_info !== false) {
                        $image_extension = image_type_to_extension($image_info[2]); // Get file extension from image type
                        $image_filename = uniqid() . $image_extension; // Append extension to filename
                        $image_path = '../images/usr_img/' . $image_filename;
                        file_put_contents($image_path, $image_data);
                    } else {
                        // Handle case where image info cannot be retrieved
                        // For example, if the URL does not point to a valid image
                        echo "Error: Unable to retrieve image information.";
                    }
                }

                $sql = "INSERT INTO register (m_email, name, urole, usr_img, registered, method) VALUES ('" . $profile['email'] . "', '" . implode(' ', $google_name_parts) . "', 'member', '" . $image_filename . "', '" . date('Y-m-d H:i:s') . "', 'google')";
                if (mysqli_query($conn, $sql)) {
                    $id = mysqli_insert_id($conn);

                    session_regenerate_id();
                    $_SESSION['facebook_loggedin'] = TRUE;
                    $_SESSION['bagdrop_member_id'] = $id;
                    $_SESSION['bagdrop_member_id_type'] = 'member';
                    // Redirect to the add-information page with the inserted ID
                    header('Location: /travbagdrop/?page=add-information&id=' . $id);
                    exit; // Make sure to exit after header redirect
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                $id = $account['m_id'];
                $urole = $account['urole'];
            }

            // Authenticate the account
            session_regenerate_id();
            $_SESSION['google_loggedin'] = TRUE;
            $_SESSION['bagdrop_member_id'] = $id;
            $_SESSION['bagdrop_member_id_type'] = $urole;

            // Redirect to profile page
            header('Location: /travbagdrop/?page=home');
            exit;
        } else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {
    // Define params and redirect to Google Authentication page
    $params = [
        'response_type' => 'code',
        'client_id' => $google_oauth_client_id,
        'redirect_uri' => $google_oauth_redirect_uri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    exit;
}

mysqli_close($conn);