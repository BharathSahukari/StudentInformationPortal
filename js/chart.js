const departmentCtx = document.getElementById("departmentChart");

if (departmentCtx) {
    new Chart(departmentCtx, {
        type: "bar",
        data: {
            labels: departments,
            datasets: [{
                label: "Students",
                data: departmentCounts,
                backgroundColor: "#5865F2"
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

const yearCtx = document.getElementById("yearChart");

if (yearCtx) {
    new Chart(yearCtx, {
        type: "pie",
        data: {
            labels: years,
            datasets: [{
                data: yearCounts,
                backgroundColor: [
                    "#5865F2",
                    "#28a745",
                    "#ffc107",
                    "#dc3545"
                ]
            }]
        },
        options: {
            responsive: true
        }
    });
}