<?php
// /config/session.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}

function getUserId(): ?int {
    return $_SESSION['user_id'] ?? null;
}

function getUserName(): string {
    return $_SESSION['user_name'] ?? 'Invité';
}

function getUserEmail(): string {
    return $_SESSION['user_email'] ?? '';
}

function login(int $userId, string $userName, string $userEmail): void {
    $_SESSION['user_id']    = $userId;
    $_SESSION['user_name']  = $userName;
    $_SESSION['user_email'] = $userEmail;
}

function logout(): void {
    session_destroy();
    header('Location: /index.php');
    exit();
}
