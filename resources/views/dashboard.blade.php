<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Order Management</a>

            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Welcome, {{ Auth::user()->name }} 👋</h4>
                <p class="card-text">You are logged in as <strong>{{ Auth::user()->role }}</strong>.</p>

                <hr>

                <p>Use the navigation bar or sidebar (if available) to manage your orders, products, users, or outlets based on your role.</p>
            </div>
        </div>
    </div>

</body>
</html>
