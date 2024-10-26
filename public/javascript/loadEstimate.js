/**
 * Recupere une consommation de la basee de données via php et ajax
 */
function loadEstimate()
{
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let value = this.responseText;

            if(value > 0) {
                consumption.value = value;
                updateConsumptionValue();
                updateConsumption();
            }
        }
    };

    let url = "/estimate-" + car.value + "-" + circuit.value;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}
