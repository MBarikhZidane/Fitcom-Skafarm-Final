<?php

?>

<div class="topbar">
    <button class="hamburger-btn" id="toggleSidebar">
        <i class="bi bi-list"></i>
    </button>

    <div class="topbar-actions">
        <div class="profile-dropdown">
            <button class="profile-btn" onclick="toggleProfileDropdown()">
                <div class="user-avatar">
                    <?= getInitials($_SESSION['username'] ?? "User") ?>
                </div>
            </button>
            <div class="dropdown-menu" id="profileDropdown">
                <a href="index.php?controller=auth&action=logout" class="dropdown-item">
                    <i class="bi bi-box-arrow-right"></i>
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>