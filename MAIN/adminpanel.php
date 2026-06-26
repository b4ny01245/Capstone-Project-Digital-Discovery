<?php
session_start();

// if no session, redirect to login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --bgcol: #a86c3e;
            --hov: #7c4f2c;
            /* header */
            --accent-color: #A3C1AD;
            /* soft green */
            --waray: #258300;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #ffffff;
            color: var(--hov);
            display: flex;
            justify-content: center;
            /* para palaging nasa gitna */
        }

        .container {
            width: 100%;
            /* palaging sakto sa screen */
            max-width: 1400px;
            /* optional limit sa sobrang laking screen */
            margin: 0 auto;
        }

        a.button-link,
        .box {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
        }

        .bttn {
            display: flex;
            gap: 1rem;
        }

        /* Header */
        header {
            background: var(--bgcol);
            padding: 1rem 2rem;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        .logo img {
            width: 70px;
            height: auto;
            border-radius: 50%;
            margin-right: 20px;
            flex-wrap: nowrap;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        h1 {
            font-size: xx-large;
            font-weight: 600;
        }

        /* Navbar palaging below ng h1 at naka-left align */
        .navbar {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            margin-left: auto;
            /* itulak sa kanan kung may space */
            flex-wrap: wrap;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            font-size: large;
            padding: 0.8rem 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            border-radius: 1rem;
        }

        .navbar a:hover {
            background-color: var(--hov);
            border: 2px solid #fff;
            /* border on hover */
            border-radius: 1rem;
        }

        /* Admin Container Styles */
        .admin-container {
            display: flex;
            min-height: calc(100vh - 90px);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: var(--bgcol);
            color: #fff;
            padding: 20px;
            position: fixed;
            height: calc(100vh - 90px);
            overflow-y: auto;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 5px 0;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            border-radius: 5px;
            transition: all 0.3s;
            position: relative;
        }

        .sidebar ul li a:hover {
            background-color: var(--hov);
            padding-left: 20px;
        }

        .sidebar ul li a::before {
            position: absolute;
            left: 15px;
            opacity: 0.7;
            transition: all 0.3s;
        }

        .sidebar ul li a:hover::before {
            left: 10px;
            opacity: 1;
        }

        .sidebar ul li ul {
            padding-left: 20px;
            display: none;
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 5px;
        }

        .sidebar ul li:hover ul {
            display: block;
        }

        .sidebar ul li ul li a {
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .sidebar ul li ul li a::before {
            left: 10px;
        }

        .logout-btn {
            background-color: var(--hov);
            color: white;
            padding: 12px;
            text-align: center;
            display: block;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 30px;
            font-weight: 600;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .logout-btn:hover {
            background-color: #fff;
            color: var(--hov);
            border: 2px solid var(--hov);
        }

        /* Main Content */
        .admin-main {
            margin-left: 260px;
            padding: 30px;
            flex-grow: 1;
            background-color: #f9f9f9;
            min-height: calc(100vh - 90px);
            overflow-y: auto;
        }

        .admin-main h1 {
            color: var(--hov);
            margin-bottom: 20px;
            font-size: 2.2rem;
            position: relative;
            padding-bottom: 10px;
        }

        .admin-main h1::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }

        /* Back Button */
        .bttn1 {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .bttn1:hover {
            transform: scale(1.1);
            background-color: var(--accent-color);
        }

        .bttn1 button {
            background: none;
            border: none;
            font-size: 1.4rem;
            color: var(--bgcol);
            cursor: pointer;
        }

        .bttn1:hover button {
            color: white;
        }

        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1002;
            background: var(--bgcol);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                width: 220px;
            }

            .admin-main {
                margin-left: 220px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .navbar a {
                padding: 0.6rem 1.2rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
                padding: 20px;
            }

            .header-top {
                justify-content: center;
                text-align: center;
            }

            h1 {
                font-size: 1.5rem;
                margin: 1rem 0;
            }

            .navbar {
                width: 100%;
                justify-content: center;
                margin-top: 1rem;
            }

            .bttn1 {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <header id="home">
            <div class="header-top" data-step="1"
                data-intro="Here you can see the Logo, Name and Menu of our website. This is what we call the HEADER.<br><br> <hr> Dinhi po makikita itun Logo, ngaran, ngan Menu hitun amun website. Tinatawag po ine natun nga HEADER">
                <div class="logo">
                    <img src="xFiles/xlogo.jpg" alt="Logo">
                </div>
                <h1>DIGITAL DISCOVERY FOR ELDERLY PEOPLE</h1>
                <nav class="navbar" id="navbar">
                    <a href="user.php"><span><i class="fas fa-home"></i> View User Page</span></a>
                    <a href="adminpanel.php?page=comments"><span><i class="fas fa-message"></i> Notifications</span></a>
                </nav>
            </div>
        </header>

        <!-- Mobile Menu Toggle -->
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <div class="admin-container">
            <!-- Sidebar -->
            <nav class="sidebar" id="sidebar">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <ul>
                    <li><a href="adminpanel.php?page=modules"><i class="fas fa-book"></i> Modules</a></li>
                    <li> <a href="adminpanel.php?page=admin_cyber"><i class="fas fa-shield-alt"></i> Cybersecurity</a>
                    </li>
                    <li> <a href="adminpanel.php?page=admin_device"><i class="fas fa-mobile-alt"></i> Device
                            Learning</a>
                    </li>
                    <li> <a href="adminpanel.php?page=admin_social"><i class="fas fa-share-alt"></i> Social Media
                            Learning</a>
                    </li>
                    <li> <a href="adminpanel.php?page=admin_banks"><i class="fas fa-university"></i> Online Banks</a>
                    </li>
                </ul> <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
            <!-- Main Content -->
            <main class="admin-main">
                <?php
            $page = $_GET['page'] ?? 'modules, admin_banks';
            // Check if the file exists before including
            $file_path = "$page.php";
            if (file_exists($file_path)) {
                include($file_path);
            } else {
                echo '<div class="error-message">
                    <h2>Page Not Found</h2>
                    <p>The requested page could not be found.</p>
                </div>';
            }
            ?>
            </main>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('menuToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');

            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                !menuToggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Handle window resize
        window.addEventListener('resize', function () {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
            }
        });
    </script>

    <style>
        .error-message {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            margin: 50px auto;
        }

        .error-message h2 {
            color: #e74c3c;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .error-message p {
            color: #666;
            font-size: 1.1rem;
        }
    </style>
</body>

</html>