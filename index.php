<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login </title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f4f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      width: 360px;
    }

    h2 {
      text-align: center;
      margin-bottom: 1rem;
      color: #0d47a1;
    }

    input, button {
      width: 100%;
      padding: 0.75rem;
      margin: 0.5rem 0;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }

    button {
      background: #0d47a1;
      color: #fff;
      cursor: pointer;
      font-weight: bold;
    }

    button:hover {
      background: #08306b;
    }

    .toggle {
      text-align: center;
      margin-top: 1rem;
      cursor: pointer;
      color: #0d47a1;
    }

    .message {
      text-align: center;
      color: green;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="cict.png" alt="Logo" style="width: 80px; height: 80px; border-radius: 50%; display: block; margin: 0 auto 1rem;">
    <h2>Login</h2>
    <form id="loginForm">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p id="message"></p>
    <div class="toggle"><a href="signup.php">Create an Account</a></div>
  </div>

  <script>
  document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("process_login.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.text())
    .then(data => {
      const messageElement = document.getElementById("message");
      messageElement.innerText = data;

      if (data.includes("Login successful")) {
        window.location.href = "home.php"; // Redirect all users to home page
      }
    });
  });
  </script>
</body>
</html>
