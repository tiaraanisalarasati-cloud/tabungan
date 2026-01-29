<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Aplikasi Tabungan'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #7dd3fc;
            --primary-dark: #38bdf8;
            --primary-light: #bae6fd;
            --secondary-color: #0ea5e9;
            --accent-color: #0284c7;
            --bg-color: #f0f9ff;
            --card-bg: #ffffff;
            --text-dark: #0c4a6e;
            --text-light: #075985;
            --border-color: #e0f2fe;
            --shadow-sm: 0 2px 8px rgba(14, 165, 233, 0.1);
            --shadow-md: 0 4px 16px rgba(14, 165, 233, 0.15);
            --shadow-lg: 0 8px 24px rgba(14, 165, 233, 0.2);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--text-dark);
            min-height: 100vh;
        }
        
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: linear-gradient(180deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
            color: #ffffff;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(14, 165, 233, 0.3);
            z-index: 1000;
        }
        
        #sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        #sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        
        #sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        
        #sidebar .sidebar-header {
            padding: 30px 20px;
            background: rgba(0, 0, 0, 0.15);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        #sidebar .sidebar-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #ffffff;
        }
        
        #sidebar .sidebar-header h3 i {
            font-size: 1.8rem;
            margin-right: 10px;
            color: #bae6fd;
        }
        
        #sidebar .sidebar-header small {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 300;
        }
        
        #sidebar ul.components {
            padding: 20px 0;
            list-style: none;
        }
        
        #sidebar ul li {
            margin: 5px 10px;
        }
        
        #sidebar ul li a {
            padding: 14px 20px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 10px;
            font-weight: 500;
        }
        
        #sidebar ul li a i {
            margin-right: 12px;
            width: 24px;
            font-size: 1.1rem;
            text-align: center;
        }
        
        #sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        #sidebar ul li a.active {
            background: linear-gradient(135deg, #bae6fd 0%, #7dd3fc 100%);
            color: #0369a1;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(125, 211, 252, 0.4);
        }
        
        #sidebar ul li a.active i {
            color: #0284c7;
        }
        
        #sidebar hr {
            border: none;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            margin: 15px 20px;
        }
        
        /* Content Area */
        #content {
            width: 100%;
            margin-left: var(--sidebar-width);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            background: transparent;
        }
        
        /* Top Navbar */
        .top-navbar {
            background: var(--card-bg);
            padding: 20px 35px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 30px;
            border-bottom: 3px solid var(--primary-light);
            position: sticky;
            top: 0;
            z-index: 999;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .top-navbar h4 {
            color: var(--text-dark);
            font-weight: 600;
            font-size: 1.5rem;
            margin: 0;
        }
        
        .top-navbar h4 i {
            color: var(--secondary-color);
            margin-right: 10px;
        }
        
        .top-navbar .text-muted {
            color: var(--text-light) !important;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .top-navbar i {
            color: var(--secondary-color);
            margin-right: 5px;
        }
        
        /* Main Content */
        .main-content {
            padding: 0 35px 35px 35px;
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
            transition: all 0.3s ease;
            background: var(--card-bg);
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            border: none;
            font-weight: 600;
            color: var(--accent-color);
            padding: 18px 25px;
            font-size: 1.1rem;
        }
        
        .card-header i {
            margin-right: 8px;
        }
        
        .card-body {
            padding: 25px;
        }
        
        /* Stat Cards */
        .stat-card {
            border-left: 5px solid;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(125, 211, 252, 0.05) 100%);
            pointer-events: none;
        }
        
        .stat-card.primary {
            border-left-color: #0ea5e9;
        }
        
        .stat-card.success {
            border-left-color: #10b981;
        }
        
        .stat-card.info {
            border-left-color: #06b6d4;
        }
        
        .stat-card.warning {
            border-left-color: #f59e0b;
        }
        
        .stat-icon {
            font-size: 2.5em;
            opacity: 0.15;
        }
        
        .text-primary {
            color: #0ea5e9 !important;
        }
        
        .text-success {
            color: #10b981 !important;
        }
        
        .text-info {
            color: #06b6d4 !important;
        }
        
        .text-warning {
            color: #f59e0b !important;
        }
        
        .text-xs {
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        /* Table Styles */
        .table {
            font-size: 0.9em;
            color: var(--text-dark);
        }
        
        .table thead th {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
            color: var(--accent-color);
            font-weight: 600;
            border: none;
            padding: 15px;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: var(--bg-color);
            transform: scale(1.01);
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        /* Badge Styles */
        .badge {
            padding: 8px 14px;
            font-weight: 500;
            border-radius: 8px;
            font-size: 0.85rem;
        }
        
        .bg-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }
        
        .bg-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }
        
        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--accent-color) 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(14, 165, 233, 0.4);
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--secondary-color) 100%);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            border-radius: 10px;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            border-radius: 10px;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            border: none;
            border-radius: 10px;
        }
        
        .btn-lg {
            padding: 15px 25px;
            font-size: 0.95rem;
        }
        
        .btn-lg:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            #content {
                margin-left: 0;
            }
            
            .main-content {
                padding: 0 15px 15px 15px;
            }
            
            .top-navbar {
                padding: 15px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">