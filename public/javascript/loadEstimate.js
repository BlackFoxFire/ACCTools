/**
 * Recupere une consommation de la basee de données via php et ajax
 */
function loadEstimate()
{
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        consumption.value = this.responseText;
        updateConsumptionValue();
        updateConsumption();
        }
    };

    let url = "/acctools/estimate-" + car.value + "-" + circuit.value;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}
