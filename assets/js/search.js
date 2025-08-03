// Allows the search functionality to filter tours based on user input
// This includes searching by title and description that is available in the tour overview cards
function searchTour() {
  const searchInput = document.getElementById("searchInput").value.toLowerCase();
  const tours = document.querySelectorAll(".tour-card");

  tours.forEach((tour) => {
    const title = tour.querySelector("h3").textContent.toLowerCase();
    if (title.includes(searchInput)) {
      tour.style.display = "flex";
    } else {
      const details = tour.querySelectorAll("p");
      let found = false;
      details.forEach((detail) => {
        if (detail.textContent.toLowerCase().includes(searchInput)) {
          found = true;
        }
      });
      if (found) {
        tour.style.display = "flex";
      } else {
        tour.style.display = "none";
      }
    }
  });

  // Check if any tours are visible
  const visibleTours = Array.from(tours).some((tour) => tour.style.display !== "none");
  let noResults = document.getElementById("noResultsMessage");
  if (!visibleTours) {
    if (!noResults) {
      noResults = document.createElement("p");
      noResults.id = "noResultsMessage";
      noResults.textContent = "No tours found.";
      document.querySelector("body").appendChild(noResults);
    }
  } else {
    if (noResults) {
      noResults.remove();
    }
  }
}
