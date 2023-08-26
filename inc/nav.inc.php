<!-- navbar.php -->
<div class="navbar">
    <ul>
        <li><a href="../php/homePage.php">Home</a></li>
        <li><a href="../php/createNewList.php">Create new List </a> </li>
    </ul>
    <button class="logout-button" onclick="logout()">Log Out</button>
</div>

<script>
function logout() {
    if (confirm("Are you sure you want to log out?")) {
        // Redirect to logout.php to handle session destruction
        window.location.href = '../php/logOut.php';
    }
}
</script>
