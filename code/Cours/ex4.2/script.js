document.getElementById('submitBtn').addEventListener('click', function() {
    let tableau = [];
    let value = parseInt(document.getElementById('inputValue').value);
    
 
    while (value > 0) {
        tableau.push(value);
        value = parseInt(prompt("Entrez un nombre supérieur à 0 :"));
    }

    fetch('https://315709cc-b138-492d-905b-8b8ac98f186c.mock.pstmn.io/t?mediane', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ tableau: tableau })
    })
    .then(response => response.json())
    .then(data => {
      
        document.getElementById('response').innerHTML = JSON.stringify(data, null, 2);

     
        if (data.median) {
            document.getElementById('mediane').innerHTML = `Médiane : ${data.median}`;
        } else {
            document.getElementById('mediane').innerHTML = 'Médiane non disponible.';
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
});
