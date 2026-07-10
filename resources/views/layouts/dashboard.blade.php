<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --side-bg: #1e293b;
            --side-bg-hover: #334155;
            --side-active: #4f46e5;
            --accent: #4f46e5;
            --soft: #f1f5f9;
            --muted: #64748b;
        }

        body {
            background: #f3f4f6;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #1e293b;
        }

        .app-sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--side-bg);
            position: fixed;
            top: 0;
            left: 0;
            padding: 1.5rem 0;
            color: #cbd5e1;
        }

        .app-sidebar .brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 0 1.5rem 1.5rem;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .app-sidebar .brand i {
            font-size: 1.5rem;
            color: var(--accent);
        }

        .app-sidebar .nav-link {
            color: #cbd5e1;
            padding: .8rem 1.5rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            border-left: 3px solid transparent;
            transition: all .15s;
        }

        .app-sidebar .nav-link:hover {
            background: var(--side-bg-hover);
            color: #fff;
        }

        .app-sidebar .nav-link.active {
            background: var(--side-bg-hover);
            color: #fff;
            border-left-color: var(--accent);
        }

        .app-sidebar .nav-link i {
            font-size: 1.15rem;
        }

        .app-main {
            margin-left: 250px;
            padding: 0;
        }

        .topbar {
            background: #fff;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topbar h4 {
            margin: 0;
            font-weight: 700;
        }

        .topbar .subtitle {
            font-size: .8rem;
            color: var(--muted);
        }

        .topbar .admin-badge {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: var(--muted);
            font-size: .9rem;
        }

        .topbar .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .content-wrap {
            padding: 2rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.4rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
            border: 1px solid #eef2f7;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stat-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
        }

        .stat-card .label {
            color: var(--muted);
            font-size: .82rem;
            margin-top: 1rem;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .stat-card .value {
            font-size: 1.9rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .panel {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
            border: 1px solid #eef2f7;
            overflow: hidden;
        }

        .panel-head {
            padding: 1.1rem 1.4rem;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .panel-head h6 {
            margin: 0;
            font-weight: 700;
        }

        .panel-body {
            padding: 1.4rem;
        }

        .student-name {
            display: flex;
            align-items: center;
            gap: .7rem;
        }

        .student-initials {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--soft);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: .85rem;
        }

        .badge-pass { background: #dcfce7; color: #15803d; }
        .badge-fail { background: #fee2e2; color: #b91c1c; }

        @media (max-width: 768px) {
            .app-sidebar { transform: translateX(-100%); }
            .app-main { margin-left: 0; }
        }
    </style>
</head>
<body>
    <aside class="app-sidebar">
        <div class="brand">
            <i class="bi bi-mortarboard-fill"></i>
            <span>Student MS</span>
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
                <i class="bi bi-book-half"></i> Courses
            </a>
            <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                <i class="bi bi-people-fill"></i> Students
            </a>
            <a class="nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}" href="{{ route('grades.index') }}">
                <i class="bi bi-clipboard-data-fill"></i> Grades
            </a>
            <a class="nav-link" href="/admin">
                <i class="bi bi-shield-lock-fill"></i> Admin Panel
            </a>
        </nav>
    </aside>

    <div class="app-main">
        <div class="topbar">
            <div>
                <h4>@yield('page-title', 'Dashboard')</h4>
                <div class="subtitle">@yield('page-subtitle', 'Overview of your institution')</div>
            </div>
            <div class="admin-badge">
                <div class="text-end">
                    <div class="fw-semibold">Administrator</div>
                    <div class="subtitle">{{ now()->format('l, M d Y') }}</div>
                </div>
                <div class="avatar">A</div>
            </div>
        </div>

        <div class="content-wrap">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
