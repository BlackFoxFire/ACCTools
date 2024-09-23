/**
 * Constantes
 */
const raceType = document.getElementById('raceType');
const raceTime = document.getElementById('raceTime');
const lapTime = document.getElementById('lapTime');
const car = document.getElementById('car');
const circuit = document.getElementById('circuit');
const consumption = document.getElementById('consumption');
const typePitStop = document.getElementById('typePitStop');
const pilotRelayTime = document.getElementById('pilotRelayTime');

/**
 * Tableau des temps de course en minutes
 */
const raceTimeArray1 = [5, 10, 15, 20, 25, 30, 45, 60];
const raceTimeArray2 = [30, 60 ,90, 120, 180];
const raceTimeArray3 = [60, 120, 180, 240, 360];
const raceTimeArray4 = [180, 360, 480, 540, 600, 720, 1080, 1440];
const raceTimeArray5 = [10, 20, 30, 60 ,90, 120, 180, 240, 300, 360, 420, 480, 540, 600, 720, 840, 960, 1080, 1200, 1320, 1440];

/**
 * Tableau des temps de pilotage en minutes
 */
const relayArray = [10, 20, 30, 60];

/**
 * Initialisation des variables
 */
let raceTimeArray = raceTimeArray1;
let pitStop = 0;
