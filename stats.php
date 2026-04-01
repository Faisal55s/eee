<?php
/**
 * ARMAX - Authentication API
 * Login, logout, and session management
 */

session_start();
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$conn = getDBConnection();

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $action = isset($data['action']) ? $data['action'] : '';
        
        switch ($action) {
            case 'login':
                // Login
                if (!isset($data['username']) || !isset($data['password'])) {
                    sendError('Username and password are required');
                }
                
                $username = $conn->real_escape_string($data['username']);
                $password = $data['password'];
                
                $stmt = $conn->prepare("SELECT id, username, email, password_hash, role, avatar, is_active FROM users WHERE username = ? OR email = ?");
                $stmt->bind_param("ss", $username, $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows === 0) {
                    sendError('Invalid username or password', 401);
                }
                
                $user = $result->fetch_assoc();
                
                if (!$user['is_active']) {
                    sendError('Account is deactivated', 403);
                }
                
                if (!password_verify($password, $user['password_hash'])) {
                    sendError('Invalid username or password', 401);
                }
                
                // Update last login
                $updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $updateStmt->bind_param("i", $user['id']);
                $updateStmt->execute();
                
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Remove password_hash from response
                unset($user['password_hash']);
                
                sendResponse([
                    'success' => true,
                    'message' => 'Login successful',
                    'user' => $user
                ]);
                break;
                
            case 'register':
                // Register new user (admin only can create accounts)
                if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
                    sendError('Username, email, and password are required');
                }
                
                $username = $conn->real_escape_string($data['username']);
                $email = $conn->real_escape_string($data['email']);
                $password = password_hash($data['password'], PASSWORD_DEFAULT);
                $role = isset($data['role']) && in_array($data['role'], ['admin', 'moderator', 'user']) ? $data['role'] : 'user';
                
                // Check if username exists
                $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
                $checkStmt->bind_param("s", $username);
                $checkStmt->execute();
                if ($checkStmt->get_result()->num_rows > 0) {
                    sendError('Username already exists');
                }
                
                // Check if email exists
                $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $checkStmt->bind_param("s", $email);
                $checkStmt->execute();
                if ($checkStmt->get_result()->num_rows > 0) {
                    sendError('Email already exists');
                }
                
                $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $username, $email, $password, $role);
                
                if ($stmt->execute()) {
                    sendResponse(['success' => true, 'message' => 'User registered successfully', 'id' => $stmt->insert_id], 201);
                } else {
                    sendError('Failed to register user: ' . $stmt->error);
                }
                break;
                
            case 'logout':
                // Logout
                session_destroy();
                sendResponse(['success' => true, 'message' => 'Logout successful']);
                break;
                
            case 'change_password':
                // Change password
                if (!isset($_SESSION['user_id'])) {
                    sendError('Not authenticated', 401);
                }
                
                if (!isset($data['old_password']) || !isset($data['new_password'])) {
                    sendError('Old password and new password are required');
                }
                
                $userId = $_SESSION['user_id'];
                $oldPassword = $data['old_password'];
                $newPassword = password_hash($data['new_password'], PASSWORD_DEFAULT);
                
                // Verify old password
                $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                
                if (!password_verify($oldPassword, $user['password_hash'])) {
                    sendError('Old password is incorrect');
                }
                
                $updateStmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $updateStmt->bind_param("si", $newPassword, $userId);
                
                if ($updateStmt->execute()) {
                    sendResponse(['success' => true, 'message' => 'Password changed successfully']);
                } else {
                    sendError('Failed to change password: ' . $updateStmt->error);
                }
                break;
                
            default:
                sendError('Invalid action');
        }
        break;
        
    case 'GET':
        // Check session
        if (isset($_SESSION['user_id'])) {
            $stmt = $conn->prepare("SELECT id, username, email, role, avatar, is_active, last_login, created_at FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            
            if ($user) {
                sendResponse(['success' => true, 'authenticated' => true, 'user' => $user]);
            }
        }
        
        sendResponse(['success' => true, 'authenticated' => false]);
        break;
        
    default:
        sendError('Method not allowed', 405);
}

$conn->close();
?>
