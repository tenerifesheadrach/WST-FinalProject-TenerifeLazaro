<?php
// Load XML
$xmlFile = 'employee.xml';
if (!file_exists($xmlFile)) {
    $xml = new SimpleXMLElement('<employees></employees>');
    $xml->asXML($xmlFile);
} else {
    $xml = simplexml_load_file($xmlFile);
}

// Helper: save XML and reload
function saveXML($xml, $file) {
    $xml->asXML($file);
    return simplexml_load_file($file);
}

// Handle Create
if (isset($_POST['add'])) {
    $newID = 1;
    foreach ($xml->employee as $emp) {
        $id = (int)$emp->EmpID;
        if ($id >= $newID) $newID = $id + 1;
    }

    $employee = $xml->addChild('employee');
    $employee->addChild('EmpID', $newID);
    $employee->addChild('FullName', $_POST['fullname']);
    $employee->addChild('EmploymentStatus', $_POST['employment_status']);
    $employee->addChild('Position', $_POST['position']);
    $employee->addChild('Department', $_POST['department']);

    // Handle picture upload (store file path only)
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $filename = time() . '_' . basename($_FILES["picture"]["name"]); // optional: make it unique
        $targetFilePath = $targetDir . $filename;

        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFilePath)) {
            $employee->addChild('Picture', $targetFilePath);
        } else {
            $employee->addChild('Picture', '');
        }
    } else {
        $employee->addChild('Picture', '');
    }

    saveXML($xml, $xmlFile);
    header("Location: manage_employee.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $index = 0;
    foreach ($xml->employee as $emp) {
        if ((string)$emp->EmpID == $idToDelete) {
            unset($xml->employee[$index]);
            break;
        }
        $index++;
    }
    saveXML($xml, $xmlFile);
    header("Location: manage_employee.php");
    exit;
}

// Handle Update
if (isset($_POST['update'])) {
    $idToUpdate = $_POST['empid'];
    foreach ($xml->employee as $emp) {
        if ((string)$emp->EmpID == $idToUpdate) {
            $emp->FullName = $_POST['fullname'];
            $emp->EmploymentStatus = $_POST['employment_status'];
            $emp->Position = $_POST['position'];
            $emp->Department = $_POST['department'];

            // Handle picture update (replace with new file path if uploaded)
            if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
                $targetDir = "uploads/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $filename = time() . '_' . basename($_FILES["picture"]["name"]);
                $targetFilePath = $targetDir . $filename;

                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFilePath)) {
                    $emp->Picture = $targetFilePath;
                }
            }
            break;
        }
    }
    saveXML($xml, $xmlFile);
    header("Location: manage_employee.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Manage Employees</title>
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


  .container { padding: 2rem; max-width: 900px; margin: auto; }
  h2 { color: #0d47a1; text-align: center; margin-bottom: 1rem; }

  button#addBtn {
    background: #0d47a1; color: white; border: none; padding: 0.75rem 1.5rem;
    border-radius: 5px; cursor: pointer; font-size: 1rem; margin-bottom: 1rem;
  }

  .form-popup {
    display: none;
    position: fixed;
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
    border: 2px solid #0d47a1;
    background-color: white;
    z-index: 2000;
    padding: 1rem 2rem;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    width: 350px;
  }

  .form-popup.active { display: block; }

  .form-popup h3 {
    margin-top: 0; color: #0d47a1; text-align: center;
  }

  .form-popup form {
    display: flex; flex-direction: column;
  }

  .form-popup input[type="text"],
  .form-popup input[type="date"],
  .form-popup input[type="file"] {
    margin-bottom: 0.8rem;
    padding: 0.5rem;
    font-size: 1rem;
  }

  .form-popup button {
    background: #0d47a1; color: white; border: none; padding: 0.5rem;
    cursor: pointer; border-radius: 5px;
  }

  .form-popup .close-btn {
    background: #888; margin-top: 0.5rem;
  }
	.table-container {
	  width: 100%;
	  overflow-x: auto;
	  display: flex;
	  justify-content: center;
	}

	table {
	  width: 100%;
	  border-collapse: collapse;
	  margin-top: 1rem;
	  table-layout: auto;
	}

	th, td {
	  border: 1px solid #ccc;
	  padding: 0.75rem;
	  text-align: center;
	  vertical-align: middle;
	  white-space: normal;
	}

	th {
	  background: #0d47a1;
	  color: white;
	}

	td:last-child, th:last-child {
	  white-space: nowrap;
	  min-width: 100px;
}


  img.emp-pic {
    width: 80px; height: 80px; object-fit: cover; border-radius: 50%;
  }

  .action-links a {
    margin: 0 5px; color: #0d47a1; cursor: pointer;
    text-decoration: none; font-weight: 600;
  }
  .form-popup {
  cursor: default;
	}

	.form-popup h3.draggable {
	  cursor: move;
	  user-select: none;
	}

</style>
<script>
  function toggleAddForm() {
    const form = document.getElementById('addForm');
    form.classList.toggle('active');
  }

  function openUpdateForm(empId) {
    // Get employee data from table cells
    const row = document.getElementById('row-' + empId);
    const fullname = row.querySelector('.fullname').textContent;
	const employmentStatus = row.querySelector('.employment-status').textContent;
    const position = row.querySelector('.position').textContent;
    const department = row.querySelector('.department').textContent;

    // Set form values
    document.getElementById('update-empid').value = empId;
    document.getElementById('update-fullname').value = fullname;
    document.getElementById('update-employment_status').value = employmentStatus;
    document.getElementById('update-position').value = position;
    document.getElementById('update-department').value = department;

    // Show update form popup
    document.getElementById('updateForm').classList.add('active');
  }

  function closeUpdateForm() {
    document.getElementById('updateForm').classList.remove('active');
  }

  function closeAddForm() {
    document.getElementById('addForm').classList.remove('active');
  }
  function dragElement(evt, formId) {
  const popup = document.getElementById(formId);
  let shiftX = evt.clientX - popup.getBoundingClientRect().left;
  let shiftY = evt.clientY - popup.getBoundingClientRect().top;

  function moveAt(pageX, pageY) {
    popup.style.left = pageX - shiftX + 'px';
    popup.style.top = pageY - shiftY + 'px';
    popup.style.transform = 'none'; // cancel default centering
    popup.style.position = 'fixed';
  }

  function onMouseMove(event) {
    moveAt(event.pageX, event.pageY);
  }

  document.addEventListener('mousemove', onMouseMove);

  document.onmouseup = function () {
    document.removeEventListener('mousemove', onMouseMove);
    document.onmouseup = null;
  };
}

function filterTable() {
  const input = document.getElementById("searchInput");
  const filter = input.value.toLowerCase();
  const rows = document.querySelectorAll("tbody tr");

  rows.forEach(row => {
    const nameCell = row.querySelector(".fullname");
    if (nameCell) {
      const nameText = nameCell.textContent.toLowerCase();
      row.style.display = nameText.includes(filter) ? "" : "none";
    }
  });
}
</script>
</head>
<body>

<nav class="navbar">
  <div class="left-section">
    <img src="cict.png" alt="Logo" class="logo" />
    <div class="college-name">College of Information and Communications Technology</div>
  </div>
  <ul>
    <li><a href="home.php">Home</a></li>
	<li><a href="manage_employee.php">Employees</a></li>
	<li><a href="gallery.php">Gallery</a></li>
    <li><a href="aboutus.php">About</a></li>
    <li><a href="index.php">Logout</a></li>
  </ul>
</nav>

<div class="container">
  <h2>Manage Employees</h2>
  
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
  <button id="addBtn" onclick="toggleAddForm()">+ Add Employee</button>
  <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search by Name..." 
         style="padding: 0.5rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 5px;" />
</div>

  <!-- Add Employee Pop-out Form -->
  <div class="form-popup" id="addForm">
   <h3 class="draggable" onmousedown="dragElement(event, 'addForm')">Add New Employee</h3>
    <form method="post" enctype="multipart/form-data" onsubmit="closeAddForm()">
      <input type="text" name="fullname" placeholder="Full Name" required />
	  <input type="text" name="employment_status" placeholder="Employment Status" required />
      <input type="text" name="position" placeholder="Position"  />
      <input type="text" name="department" placeholder="Department" required />
      <label>Upload Picture:</label>
      <input type="file" name="picture" accept="image/*" />
      <button type="submit" name="add">Add Employee</button>
      <button type="button" class="close-btn" onclick="closeAddForm()">Cancel</button>
    </form>
  </div>

  <!-- Update Employee Pop-out Form -->
  <div class="form-popup" id="updateForm">
  <h3 class="draggable" onmousedown="dragElement(event, 'updateForm')">Update Employee</h3>
    <form method="post" enctype="multipart/form-data" onsubmit="closeUpdateForm()">
      <input type="hidden" id="update-empid" name="empid" />
      <input type="text" id="update-fullname" name="fullname" placeholder="Full Name" required />
	  <input type="text" id="update-employment_status" name="employment_status" placeholder="Employment Status" required />
      <input type="text" id="update-position" name="position" placeholder="Position" required />
      <input type="text" id="update-department" name="department" placeholder="Department" required />
      <label>Change Picture (leave blank to keep current):</label>
      <input type="file" name="picture" accept="image/*" />
      <button type="submit" name="update">Update Employee</button>
      <button type="button" class="close-btn" onclick="closeUpdateForm()">Cancel</button>
    </form>
  </div>
  
<div class="table-container">
  <table>
  <thead>
    <tr>
      <th>Employee ID</th>
	  <th>Picture</th>
      <th>Full Name</th>
      <th>Employment Status</th>
      <th>Position</th>
      <th>Department</th>
      <th>Actions</th>
    </tr>
  </thead>
<tbody>
  <?php foreach ($xml->employee as $emp): ?>
    <tr id="row-<?= $emp->EmpID ?>">
      <!-- EmpID first -->
      <td class="emp-id"><?= htmlspecialchars($emp->EmpID) ?></td>

      <!-- Picture second -->
      <td>
        <?php if (!empty($emp->Picture)): ?>
          <img src="<?= htmlspecialchars($emp->Picture) ?>" alt="Emp Pic" class="emp-pic" style="width: 60px; height: 60px; object-fit: cover;">
        <?php else: ?>
          <span>No Image</span>
        <?php endif; ?>
      </td>

      <td class="fullname"><?= htmlspecialchars($emp->FullName) ?></td>
      <td class="employment-status"><?= htmlspecialchars($emp->EmploymentStatus) ?></td>
      <td class="position"><?= htmlspecialchars($emp->Position) ?></td>
      <td class="department"><?= htmlspecialchars($emp->Department) ?></td>
      <td class="action-links">
        <a href="javascript:void(0)" onclick="openUpdateForm('<?= $emp->EmpID ?>')">Edit</a> |
        <a href="?delete=<?= $emp->EmpID ?>" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</tbody>




</body>
</html>
