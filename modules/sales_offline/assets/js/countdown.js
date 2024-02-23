function start(time_end, id) {
    // Set the date we're counting down to
    var countDownDate = new Date(time_end).getTime();
    // alert(countDownDate);
    // Update the count down every 1 second
    var x = setInterval(function () {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        $("#demo" + id).html("<span class='number_'>" + days + "</span><span> Ngày </span><span class='number_'>" + hours + "</span><span> Giờ </span>"
            + "<span class='number_'>" + minutes + "</span><span> Phút </span><span class='number_'>" + seconds + "</span><span> Giây </span>");

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            $("#demo" + id).html("Hết giờ khuyến mại");
        }
    }, 1000);
}

function start1(time_end, id) {
    // Set the date we're counting down to
    var countDownDate = new Date(time_end).getTime();

    // Update the count down every 1 second
    var x = setInterval(function () {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        $("#demo" + id).html(days + " ngày " + hours + " : "
            + minutes + " : " + seconds + "");

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            $("#demo" + id).html("Hết giờ khuyến mại");
        }
    }, 1000);
}

function start2(time_end, id, color_number, bgr_color, color_word) {
    // Set the date we're counting down to
    var countDownDate = new Date(time_end).getTime();

    // Update the count down every 1 second
    var x = setInterval(function () {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        $("#demo" + id).html("<span class='number_' style='background-color: " + bgr_color + ";color: " + color_number + "'>" + days + "</span><span style='color: " + color_word + ";'> Ngày </span><span class='number_' style='background-color: " + bgr_color + ";color: " + color_number + "'>" + hours + "</span><span style='color: " + color_word + ";'> Giờ </span>"
            + "<span class='number_' style='background-color: " + bgr_color + ";color: " + color_number + "'>" + minutes + "</span><span style='color: " + color_word + ";'> Phút </span><span class='number_' style='background-color: " + bgr_color + ";color: " + color_number + "'>" + seconds + "</span><span style='color: " + color_word + ";'> Giây </span>");

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            $("#demo" + id).html("Hết giờ khuyến mại");
        }
    }, 1000);
}