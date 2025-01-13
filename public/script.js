// Dynamisch genereren van de kalender
const daysContainer = document.querySelector(".days");
const modal = document.getElementById("modal");
const closeModalButton = document.getElementById("close-modal");
const form = document.getElementById("modal-form");

// Vul de dagen met uren en kwartieren
const hours = 10; // Aantal uur
const quartersPerHour = 4;
const days = 7;

for (let day = 0; day < days; day++) {
  const dayColumn = document.createElement("div");
  dayColumn.className = "day-column";

  for (let hour = 0; hour < hours; hour++) {
    for (let quarter = 0; quarter < quartersPerHour; quarter++) {
      const quarterBlock = document.createElement("div");
      quarterBlock.className = "quarter";
      quarterBlock.dataset.day = day;
      quarterBlock.dataset.hour = hour + 8;
      quarterBlock.dataset.quarter = quarter;
      quarterBlock.addEventListener("click", handleQuarterClick);
      dayColumn.appendChild(quarterBlock);
    }
  }

  daysContainer.appendChild(dayColumn);
}

// Kwartier click-handler
function handleQuarterClick(e) {
  const quarter = e.target;
  const day = quarter.dataset.day;
  const hour = quarter.dataset.hour;
  const quarterPart = quarter.dataset.quarter;

  console.log(`Klik op dag ${day}, uur ${hour}, kwartier ${quarterPart}`);

  modal.classList.remove("hidden");
}

// Modal sluiten
closeModalButton.addEventListener("click", () => {
  modal.classList.add("hidden");
});

// Formulier opslaan
form.addEventListener("submit", (e) => {
  e.preventDefault();
  console.log("Formulier opgeslagen");
  modal.classList.add("hidden");
});
