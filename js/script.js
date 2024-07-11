// Function to show/hide weekly report based on button click
function toggleReportTable() {
  var reportTable = document.getElementById("report-table");
  var expandBtn = document.getElementById("expand-btn");

  // Toggle visibility of report table and update button text
  if (reportTable.classList.contains("report-hidden")) {
    reportTable.classList.remove("report-hidden");
    expandBtn.textContent = "Collapse Report Table";
  } else {
    reportTable.classList.add("report-hidden");
    expandBtn.textContent = "Expand Report Table";
  }
}

// Function to show weekly report based on task ID
function showReport(taskId) {
  var reportTable = document.getElementById("report-table");
  var reportBody = document.getElementById("report-body");

  // Clear previous report data
  reportBody.innerHTML = "";

  // Sample data for demonstration (replace with actual data retrieval)
  var reports = [
    { week: "Week 1", progress: "80%", comments: "Good progress, need to review last section." },
    { week: "Week 2", progress: "100%", comments: "Task completed successfully." },
    // Add more report data as needed
  ];

  // Filter reports based on task ID (for demonstration, using static data)
  reports.forEach(function (report) {
    var row = document.createElement("tr");
    row.innerHTML = "<td>" + report.week + "</td><td>" + report.progress + "</td><td>" + report.comments + "</td>";
    reportBody.appendChild(row);
  });

  // Show the report table when a task is clicked
  reportTable.style.display = "block";
}

// Basic form validation example
document.getElementById("taskForm").addEventListener("submit", function (event) {
  const description = document.getElementById("description").value.trim();
  const taskDate = document.getElementById("taskDate").value.trim();

  if (description === "" || taskDate === "") {
    event.preventDefault(); // Prevent form submission if fields are empty
    alert("Please fill out all fields.");
  }
});
