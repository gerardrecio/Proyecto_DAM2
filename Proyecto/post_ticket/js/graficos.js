$.post("php/obtenir_dades.php", function(data){

    var email = data;

    $.post("php/grafico_redonda.php", {correo: email}, 
    
        function(data){

            var parsed = JSON.parse(data);

            var desc = [];
            var datos = [];

            for ( i = 0; i < parsed.length; i++)
            {
                desc.push(parsed[i].descripcio);
                datos.push(parsed[i].contador);
            }

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: desc,
                    datasets: [{
                        label: 'Tasques per Estat',
                        data: datos,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
        }
    )
});


$.post("php/obtenir_dades.php", function(data){

    var email = data;

    $.post("php/grafico_barres.php", {correo: email}, 
    
        function(data){

            var parsed = JSON.parse(data);

            var desc = [];
            var datos = [];

            for ( i = 0; i < parsed.length; i++)
            {
                desc.push(parsed[i].nom);
                datos.push(parsed[i].contador);
            }

            var ctx = document.getElementById('myChart2').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: desc,
                    datasets: [{
                        label: '# Tasques',
                        data: datos,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    )
});
