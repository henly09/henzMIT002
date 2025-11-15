
document.addEventListener("DOMContentLoaded", function () {
  // Set today's date for both filter groups
  const today = new Date().toISOString().split("T")[0];
  document.getElementById("startDateAll").setAttribute("max", today);
  document.getElementById("endDateAll").setAttribute("max", today);
  document.getElementById("startDateLib").setAttribute("max", today);
  document.getElementById("endDateLib").setAttribute("max", today);

  // Store original dates for reset use
  let globalDatesAll = [];
  let globalDatesLibrary = [];

  // ====== VISITS ALL ======
  fetch("fetch_visits_all.php")
    .then((response) => response.json())
    .then((data) => {
      const dates = data.map((item) => item.date);
      const visitCounts = data.map((item) => item.visits);
      globalDatesAll = dates;

      const endDate = new Date().getTime();
      const startDate = new Date();
      startDate.setDate(startDate.getDate() - 365);
      const initialStartDate = startDate.getTime();

      const options = {
        chart: {
          type: "line",
          height: "100%",
          width: "100%",
          id: "visits_all",
          animations: { enabled: true },
          zoom: {
            enabled: true,
            type: "x",
            autoScaleYaxis: true,
          },
        },
        series: [{ name: "Visits", data: visitCounts }],
        xaxis: {
          type: "datetime",
          categories: dates,
          min: initialStartDate,
          max: endDate,
          labels: { format: "dd MMM" },
        },
        stroke: { curve: "smooth", width: 2 },
        markers: { size: 0 },
        tooltip: { shared: true, intersect: false },
        responsive: [{
          breakpoint: 768,
          options: { chart: { width: "100%" } },
        }],
      };

      const chart = new ApexCharts(document.querySelector("#visits"), options);
      chart.render();
    })
    .catch((error) => console.error("Error fetching visits_all:", error));

  // ====== VISITS BY LIBRARY ======
  fetch("fetch_visits_by_library.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.message) {
        console.error(data.message);
        return;
      }

      const libraries = [...new Set(data.map((item) => item.LIBRARY))];
      const dates = [...new Set(data.map((item) => item.date))];
      globalDatesLibrary = dates;

      const series = libraries.map((library) => ({
        name: library,
        data: dates.map((date) => {
          const record = data.find(
            (item) => item.LIBRARY === library && item.date === date
          );
          return record ? record.visits : 0;
        }),
      }));

      const options = {
        chart: {
          type: "line",
          height: "100%",
          width: "100%",
          id: "visits_by_library",
          animations: { enabled: true },
          zoom: {
            enabled: true,
            type: "x",
            autoScaleYaxis: true,
          },
        },
        series: series,
        xaxis: {
          type: "datetime",
          categories: dates,
          min: new Date(dates[0]).getTime(),
          max: new Date(dates[dates.length - 1]).getTime(),
          labels: { format: "dd MMM" },
        },
        stroke: { curve: "smooth", width: 2 },
        markers: { size: 0 },
        tooltip: { shared: true, intersect: false },
        responsive: [{
          breakpoint: 768,
          options: { chart: { width: "100%" } },
        }],
      };

      const chart = new ApexCharts(document.querySelector("#visits_by_library"), options);
      chart.render();
    })
    .catch((error) => console.error("Error fetching visits_by_library:", error));

  // ====== FILTER EVENTS FOR VISITS ALL ======
  document.getElementById("chartFilterAll").addEventListener("click", function () {
    const startVal = document.getElementById("startDateAll").value;
    const endVal = document.getElementById("endDateAll").value;

    if (!startVal || !endVal) return alert("Please select both dates.");
    const start = new Date(startVal).getTime();
    const end = new Date(endVal).getTime() + 86400000 - 1;

    if (start > end) return alert("Start date must be before end date.");

    ApexCharts.exec("visits_all", "updateOptions", {
      xaxis: { min: start, max: end },
    });
  });

  document.getElementById("chartResetAll").addEventListener("click", function () {
    document.getElementById("startDateAll").value = "";
    document.getElementById("endDateAll").value = "";

    const now = new Date().getTime();
    const oneYearAgo = new Date();
    oneYearAgo.setDate(oneYearAgo.getDate() - 365);

    ApexCharts.exec("visits_all", "updateOptions", {
      xaxis: { min: oneYearAgo.getTime(), max: now },
    });
  });

  // ====== FILTER EVENTS FOR VISITS BY LIBRARY ======
  document.getElementById("chartFilterLib").addEventListener("click", function () {
    const startVal = document.getElementById("startDateLib").value;
    const endVal = document.getElementById("endDateLib").value;

    if (!startVal || !endVal) return alert("Please select both dates.");
    const start = new Date(startVal).getTime();
    const end = new Date(endVal).getTime() + 86400000 - 1;

    if (start > end) return alert("Start date must be before end date.");

    ApexCharts.exec("visits_by_library", "updateOptions", {
      xaxis: { min: start, max: end },
    });
  });

  document.getElementById("chartResetLib").addEventListener("click", function () {
    document.getElementById("startDateLib").value = "";
    document.getElementById("endDateLib").value = "";

    if (globalDatesLibrary.length > 0) {
      ApexCharts.exec("visits_by_library", "updateOptions", {
        xaxis: {
          min: new Date(globalDatesLibrary[0]).getTime(),
          max: new Date(globalDatesLibrary[globalDatesLibrary.length - 1]).getTime(),
        },
      });
    }
  });
});