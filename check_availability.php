<?php
require_once 'connection.php';

// Set content type to JSON
header('Content-Type: application/json');

// Initialize response
$response = [
    'available' => false,
    'message' => '',
    'suggestions' => []
];

// Check if required parameters are provided
if (!isset($_POST['type']) || !isset($_POST['value']) || !isset($_POST['user_type'])) {
    $response['message'] = 'Missing required parameters';
    echo json_encode($response);
    exit;
}

$type = $_POST['type'];
$value = trim($_POST['value']);
$userType = $_POST['user_type'];

// Validate input
if (empty($value)) {
    $response['message'] = 'Value cannot be empty';
    echo json_encode($response);
    exit;
}

// Connect to database
$conn = Connect();

if (!$conn) {
    $response['message'] = 'Database connection failed';
    echo json_encode($response);
    exit;
}

// Sanitize input
$value = $conn->real_escape_string($value);

try {
    if ($type === 'username') {
        $available = checkUsernameAvailability($conn, $value, $userType);

        if ($available) {
            $response['available'] = true;
            $response['message'] = 'Username is available';
        } else {
            $response['available'] = false;
            $response['message'] = 'Username is already taken';
            $response['suggestions'] = generateUsernameSuggestions($conn, $value);
        }

    } elseif ($type === 'email') {
        $available = checkEmailAvailability($conn, $value, $userType);

        if ($available) {
            $response['available'] = true;
            $response['message'] = 'Email is available';
        } else {
            $response['available'] = false;
            $response['message'] = 'Email address is already registered';
        }

    } else {
        $response['message'] = 'Invalid type parameter';
    }

} catch (Exception $e) {
    $response['message'] = 'An error occurred while checking availability';
    error_log('Availability check error: ' . $e->getMessage());
} finally {
    $conn->close();
}

echo json_encode($response);

/**
 * Check if username is available across both customer and admin tables
 */
function checkUsernameAvailability($conn, $username, $userType) {
    // Check customers table
    $customerQuery = "SELECT customer_username FROM customers WHERE customer_username = ? LIMIT 1";
    $customerStmt = $conn->prepare($customerQuery);
    $customerStmt->bind_param("s", $username);
    $customerStmt->execute();
    $customerResult = $customerStmt->get_result();

    if ($customerResult->num_rows > 0) {
        $customerStmt->close();
        return false;
    }
    $customerStmt->close();

    // Check clients (admin) table
    $clientQuery = "SELECT client_username FROM clients WHERE client_username = ? LIMIT 1";
    $clientStmt = $conn->prepare($clientQuery);
    $clientStmt->bind_param("s", $username);
    $clientStmt->execute();
    $clientResult = $clientStmt->get_result();

    if ($clientResult->num_rows > 0) {
        $clientStmt->close();
        return false;
    }
    $clientStmt->close();

    return true;
}

/**
 * Check if email is available across both customer and admin tables
 */
function checkEmailAvailability($conn, $email, $userType) {
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Check customers table
    $customerQuery = "SELECT customer_email FROM customers WHERE customer_email = ? LIMIT 1";
    $customerStmt = $conn->prepare($customerQuery);
    $customerStmt->bind_param("s", $email);
    $customerStmt->execute();
    $customerResult = $customerStmt->get_result();

    if ($customerResult->num_rows > 0) {
        $customerStmt->close();
        return false;
    }
    $customerStmt->close();

    // Check clients (admin) table
    $clientQuery = "SELECT client_email FROM clients WHERE client_email = ? LIMIT 1";
    $clientStmt = $conn->prepare($clientQuery);
    $clientStmt->bind_param("s", $email);
    $clientStmt->execute();
    $clientResult = $clientStmt->get_result();

    if ($clientResult->num_rows > 0) {
        $clientStmt->close();
        return false;
    }
    $clientStmt->close();

    return true;
}

/**
 * Generate username suggestions when the requested username is taken
 */
function generateUsernameSuggestions($conn, $baseUsername, $count = 3) {
    $suggestions = [];
    $cleanBase = preg_replace('/[^a-zA-Z0-9_]/', '', $baseUsername);

    // If the base is too short, pad it
    if (strlen($cleanBase) < 3) {
        $cleanBase .= 'user';
    }

    // Generate suggestions with numbers
    for ($i = 1; $i <= $count * 2; $i++) {
        $suggestion = $cleanBase . rand(10, 999);

        if (checkUsernameAvailability($conn, $suggestion, 'any')) {
            $suggestions[] = $suggestion;

            if (count($suggestions) >= $count) {
                break;
            }
        }
    }

    // If we still don't have enough suggestions, try with different patterns
    if (count($suggestions) < $count) {
        $patterns = [
            $cleanBase . '_' . rand(10, 99),
            $cleanBase . date('y'),
            $cleanBase . '_user',
            'user_' . $cleanBase
        ];

        foreach ($patterns as $pattern) {
            if (checkUsernameAvailability($conn, $pattern, 'any')) {
                $suggestions[] = $pattern;

                if (count($suggestions) >= $count) {
                    break;
                }
            }
        }
    }

    return array_slice($suggestions, 0, $count);
}
?>
