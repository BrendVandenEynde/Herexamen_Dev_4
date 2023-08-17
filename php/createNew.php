
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
        .navbar {
      position: fixed;
      top: 0;
      left: 0;
      background-color: #566198;
      color: #ECEDEB;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size:20px;
      width: 100%;
    }

    .navbar ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
    }

    .navbar li {
      margin-left: 10px;
    }

    .navbar li a {
      color: #fff;
      text-decoration: none;
    }

    .container {
    width: 100%;
    max-width: 400px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

        h1 {
            text-align: center;
            color: #333;
        }

        .label {
    display: block;
    margin-bottom: 10px;
    color: #566198;
    font-weight: bold;
    font-size: 16px;
}

.input-field {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 15px;
    transition: border-color 0.3s ease;
    font-size: 16px;
}

.input-field:focus {
    border-color: #566198;
}

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul>
          <li><a href="../pages/HomePage.html">Home</a></li>
        </ul>
        <button class="logout-button" onclick="location.href='../Index.html'">Log Out</button>
      </div>
    <div class="container">
        <h1>To-Do List</h1>
        <form method="POST" action="addtask.php">
            <label for="task">Task 1:</label>
            <input type="text" id="task1" name="task1" placeholder="Enter a task">
            
            <label for="task">Task 2:</label>
            <input type="text" id="task2" name="task2" placeholder="Enter another task">
            
            <input type="submit" value="Create List">
        </form>
    </div>
</body>
</html>
