{% include 'header.php' %}

<h2>Contact Us</h2>

<form name="contactForm" method="post" action="">
    <div class="col-sm-6" style="display: flex; flex-direction: column">
        <label for="fname">Your Full Name</label>
        <input id="fname" name="fullname">

        <label for="femail">Your Email</label>
        <input id="femail" name="email">

        <label for="fsubject">Subject</label>
        <input id="fsubject" name="subject">
    </div>
    <div class="col-sm-6" style="display: flex; flex-direction: column">
        <label for="fmessage">Message</label>
        <textarea name="message" id="fmessage" cols="30" rows="7"></textarea>

        <div class="col-sm-12" style="display: flex; justify-content: center">
            <input type="submit" value="Submit">
        </div>

    </div>

</form>

{% include 'footer.php' %}
