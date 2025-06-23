<?php
require_once 'connection.php';

class RegistrationValidator {
    private $conn;

    public function __construct() {
        $this->conn = Connect();
    }

    /**
     * Validate customer registration data
     * @param array $data - Registration data
     * @return array - Validation result with status and errors
     */
    public function validateCustomerRegistration($data) {
        $errors = [];
        $warnings = [];

        // Basic field validation
        $requiredFields = ['customer_name', 'customer_username', 'customer_email', 'customer_phone', 'customer_address', 'customer_password'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst(str_replace('customer_', '', $field)) . ' is required.';
            }
        }

        // If basic validation fails, return early
        if (!empty($errors)) {
            return [
                'status' => 'error',
                'errors' => $errors,
                'warnings' => $warnings
            ];
        }

        // Sanitize input data
        $customer_name = $this->conn->real_escape_string(trim($data['customer_name']));
        $customer_username = $this->conn->real_escape_string(trim($data['customer_username']));
        $customer_email = $this->conn->real_escape_string(trim($data['customer_email']));
        $customer_phone = $this->conn->real_escape_string(trim($data['customer_phone']));
        $customer_address = $this->conn->real_escape_string(trim($data['customer_address']));
        $customer_password = $this->conn->real_escape_string($data['customer_password']);

        // Advanced field validation
        if (!$this->validateEmail($customer_email)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if (!$this->validateUsername($customer_username)) {
            $errors[] = 'Username must be at least 3 characters long and contain only letters, numbers, and underscores.';
        }

        if (!$this->validatePassword($customer_password)) {
            $errors[] = 'Password must be at least 6 characters long.';
        }

        if (!$this->validatePhone($customer_phone)) {
            $warnings[] = 'Phone number format may be invalid. Please verify it\'s correct.';
        }

        if (!$this->validateName($customer_name)) {
            $errors[] = 'Name must contain only letters and spaces and be at least 2 characters long.';
        }

        // Check for existing username in customers table
        if ($this->checkCustomerUsernameExists($customer_username)) {
            $errors[] = 'This username is already taken. Please choose a different username.';
        }

        // Check for existing email in customers table
        if ($this->checkCustomerEmailExists($customer_email)) {
            $errors[] = 'An account with this email address already exists. Please use a different email or try logging in.';
        }

        // Check if username exists in admin table (to prevent conflicts)
        if ($this->checkAdminUsernameExists($customer_username)) {
            $errors[] = 'This username is not available. Please choose a different username.';
        }

        // Check if email exists in admin table (to prevent conflicts)
        if ($this->checkAdminEmailExists($customer_email)) {
            $errors[] = 'An account with this email address already exists in the system.';
        }

        return [
            'status' => empty($errors) ? 'success' : 'error',
            'errors' => $errors,
            'warnings' => $warnings,
            'data' => [
                'customer_name' => $customer_name,
                'customer_username' => $customer_username,
                'customer_email' => $customer_email,
                'customer_phone' => $customer_phone,
                'customer_address' => $customer_address,
                'customer_password' => $customer_password
            ]
        ];
    }

    /**
     * Validate admin registration data
     * @param array $data - Registration data
     * @return array - Validation result with status and errors
     */
    public function validateAdminRegistration($data) {
        $errors = [];
        $warnings = [];

        // Basic field validation
        $requiredFields = ['client_name', 'client_username', 'client_email', 'client_phone', 'client_address', 'client_password'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst(str_replace('client_', '', $field)) . ' is required.';
            }
        }

        // If basic validation fails, return early
        if (!empty($errors)) {
            return [
                'status' => 'error',
                'errors' => $errors,
                'warnings' => $warnings
            ];
        }

        // Sanitize input data
        $client_name = $this->conn->real_escape_string(trim($data['client_name']));
        $client_username = $this->conn->real_escape_string(trim($data['client_username']));
        $client_email = $this->conn->real_escape_string(trim($data['client_email']));
        $client_phone = $this->conn->real_escape_string(trim($data['client_phone']));
        $client_address = $this->conn->real_escape_string(trim($data['client_address']));
        $client_password = $this->conn->real_escape_string($data['client_password']);

        // Advanced field validation
        if (!$this->validateEmail($client_email)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if (!$this->validateUsername($client_username)) {
            $errors[] = 'Username must be at least 3 characters long and contain only letters, numbers, and underscores.';
        }

        if (!$this->validatePassword($client_password)) {
            $errors[] = 'Password must be at least 8 characters long for admin accounts.';
        }

        if (!$this->validatePhone($client_phone)) {
            $warnings[] = 'Phone number format may be invalid. Please verify it\'s correct.';
        }

        if (!$this->validateName($client_name)) {
            $errors[] = 'Name must contain only letters and spaces and be at least 2 characters long.';
        }

        // Check for existing username in admin table
        if ($this->checkAdminUsernameExists($client_username)) {
            $errors[] = 'This username is already taken. Please choose a different username.';
        }

        // Check for existing email in admin table
        if ($this->checkAdminEmailExists($client_email)) {
            $errors[] = 'An admin account with this email address already exists. Please use a different email.';
        }

        // Check if username exists in customer table (to prevent conflicts)
        if ($this->checkCustomerUsernameExists($client_username)) {
            $errors[] = 'This username is not available. Please choose a different username.';
        }

        // Check if email exists in customer table (to prevent conflicts)
        if ($this->checkCustomerEmailExists($client_email)) {
            $errors[] = 'An account with this email address already exists in the system.';
        }

        return [
            'status' => empty($errors) ? 'success' : 'error',
            'errors' => $errors,
            'warnings' => $warnings,
            'data' => [
                'client_name' => $client_name,
                'client_username' => $client_username,
                'client_email' => $client_email,
                'client_phone' => $client_phone,
                'client_address' => $client_address,
                'client_password' => $client_password
            ]
        ];
    }

    /**
     * Check if customer username already exists
     */
    private function checkCustomerUsernameExists($username) {
        $query = "SELECT customer_username FROM customers WHERE customer_username = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    /**
     * Check if customer email already exists
     */
    private function checkCustomerEmailExists($email) {
        $query = "SELECT customer_email FROM customers WHERE customer_email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    /**
     * Check if admin username already exists
     */
    private function checkAdminUsernameExists($username) {
        $query = "SELECT client_username FROM clients WHERE client_username = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    /**
     * Check if admin email already exists
     */
    private function checkAdminEmailExists($email) {
        $query = "SELECT client_email FROM clients WHERE client_email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    /**
     * Validate email format
     */
    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate username format
     */
    private function validateUsername($username) {
        return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username);
    }

    /**
     * Validate password strength
     */
    private function validatePassword($password) {
        return strlen($password) >= 6;
    }

    /**
     * Validate phone number format
     */
    private function validatePhone($phone) {
        // Basic phone validation - adjust regex as needed for your region
        return preg_match('/^[\+]?[0-9\-\(\)\s]{10,20}$/', $phone);
    }

    /**
     * Validate name format
     */
    private function validateName($name) {
        return preg_match('/^[a-zA-Z\s]{2,50}$/', $name);
    }

    /**
     * Get user-friendly field name
     */
    private function getFieldDisplayName($fieldName) {
        $fieldNames = [
            'customer_name' => 'Full Name',
            'customer_username' => 'Username',
            'customer_email' => 'Email Address',
            'customer_phone' => 'Phone Number',
            'customer_address' => 'Address',
            'customer_password' => 'Password',
            'client_name' => 'Full Name',
            'client_username' => 'Username',
            'client_email' => 'Email Address',
            'client_phone' => 'Phone Number',
            'client_address' => 'Address',
            'client_password' => 'Password'
        ];

        return isset($fieldNames[$fieldName]) ? $fieldNames[$fieldName] : ucfirst($fieldName);
    }

    /**
     * Check if a value exists in any user table (comprehensive check)
     */
    public function checkValueExists($field, $value, $excludeTable = null) {
        $exists = false;

        // Check customers table
        if ($excludeTable !== 'customers') {
            $customerField = str_replace('client_', 'customer_', $field);
            $query = "SELECT $customerField FROM customers WHERE $customerField = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $value);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $exists = true;
            }
        }

        // Check clients table
        if (!$exists && $excludeTable !== 'clients') {
            $clientField = str_replace('customer_', 'client_', $field);
            $query = "SELECT $clientField FROM clients WHERE $clientField = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $value);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $exists = true;
            }
        }

        return $exists;
    }

    /**
     * Generate suggestions for alternative usernames
     */
    public function suggestAlternativeUsernames($baseUsername, $count = 3) {
        $suggestions = [];
        $base = preg_replace('/[^a-zA-Z0-9_]/', '', $baseUsername);

        for ($i = 1; $i <= $count; $i++) {
            $suggestion = $base . rand(10, 99);
            if (!$this->checkValueExists('username', $suggestion)) {
                $suggestions[] = $suggestion;
            }
        }

        return $suggestions;
    }

    /**
     * Hash password securely
     */
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Close database connection
     */
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
