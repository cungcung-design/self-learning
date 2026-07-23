<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Dashboard Layout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
    
      .sidebar {
        min-height: 100vh; 
        background-color: #f8f9fa; 
        padding: 15px 10px;
        border-right: 1px solid #dee2e6;
      }
      .sidebar a {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: #333;
        border-radius: 5px;
        margin-bottom: 5px;
      }
      .sidebar a:hover, .sidebar a.active {
        background-color: green;
        font-weight: bold;
      }
    </style>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"> Student Management System</a>
       
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar">
          <a class="active" href="#home">Home</a>
          <a href="#menu">Student</a>
          <a href="#orders">Teacher</a>
          <a href="#orders">Courses</a>
          <a href="#orders">Enrollment</a>
          <a href="#settings">Payments</a>
        </div>

        <div class="col-md-9 col-lg-10 p-4 content">
          <h2>Welcome to the Dashboard</h2>
          <p>This is where your tables, forms, and data will go.</p>
        </div>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>