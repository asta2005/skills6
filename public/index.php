<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Week Kalender</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="calendar-container">
    <div class="header">
      <div class="day">Maandag</div>
      <div class="day">Dinsdag</div>
      <div class="day">Woensdag</div>
      <div class="day">Donderdag</div>
      <div class="day">Vrijdag</div>
      <div class="day">Zaterdag</div>
      <div class="day">Zondag</div>
      
    </div>
    <div class="body">
      <!-- Tijdslots -->
      <div class="hours">
        <div class="time">08:30</div>
        <div class="time">09:30</div>
        <div class="time">10:30</div>
        <div class="time">11:30</div>
        <div class="time">12:30</div>
        <div class="time">13:30</div>
        <div class="time">14:30</div>
        <div class="time">15:30</div>
        <div class="time">16:30</div>
        <div class="time">17:30</div>
      </div>
      <!-- Dagen en kwartieren -->
      <div class="days">
        <!-- Dit zal via JavaScript dynamisch gevuld worden -->
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div id="modal" class="hidden">
    <form id="modal-form">
      <label for="description">Beschrijving:</label>
      <textarea id="description" name="description"></textarea>
      <button type="submit">Opslaan</button>
      <button type="button" id="close-modal">Sluiten</button>
    </form>
  </div>

  <script src="script.js"></script>
</body>
</html>
