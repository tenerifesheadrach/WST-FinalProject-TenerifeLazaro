<?php 
$xml = simplexml_load_file('employee.xml');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Employee Gallery</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f0f4fa;
      color: #333;
    }

    /* Navbar styles */
    .navbar {
      width: 100%;
      background-color: #0d47a1;
      color: #fff;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .left-section {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .logo {
      height: 50px;
      width: auto;
    }

    .college-name {
      font-size: 1.25rem;
      font-weight: 700;
      white-space: nowrap;
    }

    .navbar ul {
      list-style: none;
      display: flex;
      gap: 1.5rem;
    }

    .navbar ul li a {
      text-decoration: none;
      color: #fff;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .navbar ul li a:hover {
      color: #90caf9;
      text-decoration: underline;
    }

    /* Page heading */
    h1 {
      text-align: center;
      margin: 2rem 0;
      color: #0d47a1;
      font-weight: 700;
    }

    /* Gallery container with grid */
    .gallery-container {
      max-width: 1100px;
      margin: 0 auto 4rem auto;
      padding: 0 1rem;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 1.5rem;
    }

    /* Card styles */
    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
      overflow: hidden;
      text-align: center;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 16px rgb(0 0 0 / 0.15);
    }

    .card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-bottom: 2px solid #0d47a1;
    }

    .card h3 {
      margin: 12px 0 6px;
      color: #0d47a1;
      font-weight: 700;
      font-size: 1.1rem;
    }

    .card p {
      margin-bottom: 15px;
      color: #555;
      font-weight: 500;
      font-size: 0.95rem;
    }

    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.7);
      padding: 2rem 1rem;
    }

    .modal-content {
      background-color: #fff;
      margin: 5% auto;
      padding: 2rem;
      border-radius: 12px;
      max-width: 480px;
      box-shadow: 0 5px 15px rgb(0 0 0 / 0.25);
      position: relative;
    }

    .close {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 28px;
      font-weight: bold;
      color: #aaa;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .close:hover {
      color: #0d47a1;
    }

    .modal-content h2 {
      color: #0d47a1;
      margin-bottom: 1rem;
    }

    .modal-content p {
      font-size: 1rem;
      margin-bottom: 0.6rem;
      color: #444;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
      .gallery-container {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      }
      .card img {
        height: 160px;
      }
    }
	.drag-handle {
	  cursor: move;
	  user-select: none;
	}

  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="left-section">
      <img src="cict.png" alt="Logo" class="logo" />
      <div class="college-name">College of Information & Communications Technology</div>
    </div>
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="manage_employee.php">Employees</a></li>
	  	<li><a href="gallery.php">Gallery</a></li>
      <li><a href="aboutus.php">About</a></li>
	   <li><a href="index.php">Log Out</a></li>
    </ul>
  </nav>

  <h1>Employee Gallery</h1>

  <div class="gallery-container">
    <?php foreach ($xml->employee as $emp):
      $pictureRaw = trim((string)$emp->Picture);
      
      // Handle full vs. partial paths
      if (strpos($pictureRaw, 'uploads/') !== false) {
        $imagePath = $pictureRaw;
      } else {
        $imagePath = 'uploads/' . $pictureRaw;
      }

      // Fallback if file is missing or not readable
      if (!$pictureRaw || !file_exists($imagePath)) {
        $imagePath = 'uploads/default.png'; // Ensure this file exists
      }
    ?>
      <div class="card" onclick="showModal('<?php echo htmlspecialchars($emp->FullName); ?>', '<?php echo htmlspecialchars($emp->EmploymentStatus); ?>', '<?php echo htmlspecialchars($emp->Position); ?>', '<?php echo htmlspecialchars($emp->Department); ?>')">
        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Employee Photo" />
        <h3><?php echo htmlspecialchars($emp->FullName); ?></h3>
        <p><?php echo htmlspecialchars($emp->Position); ?></p>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Modal -->
<div id="employeeModal" class="modal">
  <div class="modal-content" id="draggableModal">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2 id="modalName" class="drag-handle"></h2>
    <p><strong>Employment Status:</strong> <span id="modalStatus"></span></p>
    <p><strong>Position:</strong> <span id="modalPosition"></span></p>
    <p><strong>Department:</strong> <span id="modalDepartment"></span></p>
  </div>
</div>

<script>
  function showModal(name, status, position, department) {
    document.getElementById('modalName').innerText = name;
    document.getElementById('modalStatus').innerText = status;
    document.getElementById('modalPosition').innerText = position;
    document.getElementById('modalDepartment').innerText = department;
    document.getElementById('employeeModal').style.display = 'block';
  }

  function closeModal() {
    document.getElementById('employeeModal').style.display = 'none';
  }

  window.onclick = function(event) {
    const modal = document.getElementById('employeeModal');
    if (event.target === modal) {
      closeModal();
    }
  }

  // Draggable modal
  const modal = document.getElementById("draggableModal");
  const dragHandle = modal.querySelector(".drag-handle");

  let isDragging = false;
  let offsetX = 0, offsetY = 0;

  dragHandle.addEventListener("mousedown", function(e) {
    isDragging = true;
    offsetX = e.clientX - modal.getBoundingClientRect().left;
    offsetY = e.clientY - modal.getBoundingClientRect().top;
    document.body.style.userSelect = "none";
  });

  document.addEventListener("mousemove", function(e) {
    if (isDragging) {
      modal.style.position = "absolute";
      modal.style.top = (e.clientY - offsetY) + "px";
      modal.style.left = (e.clientX - offsetX) + "px";
      modal.style.margin = 0;
    }
  });

  document.addEventListener("mouseup", function() {
    isDragging = false;
    document.body.style.userSelect = "auto";
  });
</script>

</body>
</html>
