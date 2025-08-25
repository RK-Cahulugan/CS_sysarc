async function submitAttendance() {
  const studentId = document.getElementById("studentId").value.trim();

  if (!studentId) {
    alert("Please enter a Student ID");
    return;
  }

  try {
    const response = await fetch("http://localhost/CS-system/attendances.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "studentId=" + encodeURIComponent(studentId)
    });

    if (!response.ok) {
      throw new Error("HTTP error! Status: " + response.status);
    }

    const text = await response.text();
    console.log("Raw Response:", text);

    let data;
    try {
      data = JSON.parse(text);
    } catch (err) {
      throw new Error("Invalid JSON from PHP: " + text);
    }

    if (data.success) {
      document.getElementById("name").textContent = data.name;
      document.getElementById("year").textContent = data.year_level;
      document.getElementById("course").textContent = data.course;
      document.getElementById("status").textContent = data.status;
      document.getElementById("timein").textContent = data.time_in ?? "--";
      document.getElementById("timeout").textContent = data.time_out ?? "--";

      document.getElementById("studentInfo").style.display = "block";
    } else {
      alert(data.message || "Student not found!");
      document.getElementById("studentInfo").style.display = "none";
    }

  } catch (error) {
    console.error("Fetch Error:", error);
    alert("Error: " + error.message);
  }
}
