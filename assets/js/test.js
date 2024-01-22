    // Set the date we're counting down to
    var countDownDate = new Date("<?= $finish_at->format('M d, Y H:i:s') ?>").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML = ('00' + hours).slice(-2) + ":" +
            ('00' + minutes).slice(-2) + ":" + ('00' + seconds).slice(-2);

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "00:00:00";
            window.location.href = "<?= base_url('aksespeserta/soal_test/akhir') ?>";
        }
    }, 1000);