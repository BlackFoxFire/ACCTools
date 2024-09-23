/**
 * Déclaration des évenements
 */

raceType.addEventListener("input", function() {
    updateRaceType();
});

raceTime.addEventListener("input", function() {
    updateRaceTime();
});

lapTime.addEventListener("input", function() {
    updateLapTime();
});

car.addEventListener("input", function() {
    loadEstimate();
});

circuit.addEventListener("input", function() {
    loadEstimate();
});

consumption.addEventListener("input", function() {
    updateConsumptionValue();
});

consumption.addEventListener("focus", function() {
    circuit.value = "";
});

typePitStop.addEventListener("input", function() {
    updateRelay();
});

pilotRelayTime.addEventListener("input", function() {
    updateRelay();
});

document.getElementById('myForm').addEventListener("input", function() {
    updateConsumption();
});
