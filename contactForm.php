<?php
$message_sent = false;
if (isset($_POST['email']) && $_POST['email'] != '') {

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        //submits the form
        $userName = $_POST['fullname'];
        $userEmail = $_POST['email'];
        $messageSubject = $_POST['subject'];
        $message = $_POST['message'];

        $to = "gutierrezhenry95@gmail.com";
        $body = "";

        $body .= "From: " . $userName . "\r\n";
        $body .= "Email: " . $userEmail . "\r\n";
        $body .= "Message:" . $message . "\r\n";



        //mail($to, $messageSubject, $body);
        $message_sent = true;
    } else {
        $invalid_class_name = "form-invalid";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css" integrity="sha256-ybRkN9dBjhcS2qrW1z+hfCxq+1aBdwyQM5wlQoQVt/0=" crossorigin="anonymous" />
</head>

<body class="body">
    <?php
    if ($message_sent) :
    ?>
        <h3>Thanks, we will be in touch!</h3>
    <?php
    else :
    ?>
        <div class="container night-mode-available">
            <div class="content-wrap">
                <div class="topnav">
                    <a class="active" href="index.html">Home</a>
                    <a href="Projects.html">Projects</a>
                    <a href="contactForm.php">Contact</a>
                    <a class="link" href="#">Link</a>
                </div>

                <div class="night-mode-available">
                    <div class="NM-button">
                        <input type="checkbox" class="checkbox" id="night-mode" />
                        <label for="night-mode" class="label">
                            <i class="fas fa-moon"></i>
                            <i class="fas fa-sun"></i>
                            <div class="blob"></div>
                        </label>
                    </div>
                    <div class="info night-mode-available nm">Nightmode</div>
                    <div class="home-content text night-mode-available"></div>
                </div>
                <div class="contact">
                    <h3 class="night-mode-available info">Contact Me</h3>
                    <br />
                </div>
                <div>
                    <form method="post" action="/contactForm.php">
                        <input class="fullName" id="fullname" type="text" name="fullname" placeholder="Name" /><br />
                        <input class="email" id="email" type="text" name="email" placeholder="Email" required /><br />
                        <input class="subject" id="subject" type="text" name="subject" placeholder="Subject" /><br />
                        <textarea class="message" id="message" type="text" name="message" placeholder="Message" rows="8" cols="48"></textarea><br />
                        <input type="submit" value="Send" class="submit" />
                        <input type="reset" value="Reset" class="reset" />
                    </form>
                </div>

                <div class="footer night-mode-available text">
                    <a href="https://github.com/robohen"><img class="githubicon" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Font_Awesome_5_brands_github.svg/116px-Font_Awesome_5_brands_github.svg.png" alt="github-icon" /></a>
                    <span class="span">©2022 HenryCanCode</span><a href="https://www.linkedin.com/in/henry-gutierrez-27b65a247/"><img class="linkedinicon" src="https://img.icons8.com/ios-glyphs/452/linkedin.png" /></a>
                </div>
            </div>
        </div>
        <!--Here is the Javascript and explanations with what each part does-->
        <script type="text/javascript">
            /* this is the javascript for toggling night mode*/
            document.querySelector(".checkbox").addEventListener("change", () => {
                document.querySelectorAll(".night-mode-available").forEach((ele) => {
                    ele.classList.toggle("night");
                });
            });
            /* this is the javascript for copying the link to the clipboard*/
            const link = document.querySelector(".link");
            link.onclick = () => {
                navigator.clipboard.writeText(window.location.href);
            };
            /*keeping state in local storage for night mode*/
            const keepingState = document.getElementsByClassName("nm");
            const theme = document.querySelectorAll(".night-mode-available");
            let darkMode = localStorage.getItem("night");

            const enableNightMode = () => {
                theme.classList.add("night");
                localStorage.setItem("night", "enabled");
            };

            const disableNightMode = () => {
                theme.classList.remove("night");
                localStorage.setItem("night", "disabled");
            };
            if (night === "enabled") {
                enableNightMode();
            }

            keepingState.addEventListener("click", (e) => {
                darkMode = localStorage.getItem("darkMode");
                if (darkMode === "disabled") {
                    enableNightMode();
                } else {
                    disableNightMode();
                }
            });
        </script>
    <?php
    endif;
    ?>
</body>

</html>