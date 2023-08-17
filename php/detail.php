<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="../images/DefFaviconPortPixel.svg">
  <title>Detailed Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f2f2f2;
      color: #364045;
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
      font-size: 20px;
      width: 100%;
      z-index: 1;
    }

    .navbar ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
    }

    .navbar li {
      margin-left: 20px;
    }

    .navbar li a {
      color: #fff;
      text-decoration: none;
    }

    .logout-button {
      background-color: #f44336;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
      margin-right: 2%;
    }

    .logout-button:hover {
      background-color: #d32f2f;
    }

    .listName {
      text-align: center;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      margin: 80px auto 20px;
      width: 80%;
      max-width: 600px;
    }

    h1, h2 {
      color: #444;
      margin: 0;
      padding: 0;
    }

    .item-info {
      margin: 0 auto 20px;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 80%;
      max-width: 600px;
    }

    .item-info p {
      margin-bottom: 10px;
      color: #666;
    }

    @media (max-width: 600px) {
      .item-info {
        padding: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="navbar">
    <ul>
        <li><a href="../pages/HomePage.html">Home</a></li>
        <li><a href="../pages/CreateNew.html">Create new List</a></li>
    </ul>
    <button class="back-button" onclick="goBack()">Back</button>
  </div>

  <div class="listName">
    <h1>Detailed Page</h1>
    <h2>Item Details</h2>
  </div>

  <div class="item-info">
    <h2>Item Title</h2>
    <p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    <p>Price: $19.99</p>
    <p>Color: Blue</p>
  </div>

  <div class="item-info">
    <h2>Item Title</h2>
    <p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    <p>Price: $24.99</p>
    <p>Color: Red</p>
  </div>

  <div class="item-info">
    <h2>Item Title</h2>
    <p>Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    <p>Price: $29.99</p>
    <p>Color: Green</p>
  </div>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>
</body>
</html>
