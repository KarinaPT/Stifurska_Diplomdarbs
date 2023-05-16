
<footer class="bg-dark" id="tempaltemo_footer" >
  <!-- Код вашего футера -->
    <div class="container">
        <div class="row">

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-success border-bottom pb-3 border-light logo">Kiriyena</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <a class="text-decoration-none  ">
                        Kiriyena ir starptautiska tirdzniecības platforma, kas apvieno cilvēkus,
                        kuri vēlas radīt, pārdot, iegādāties un kolekcionēt unikālus priekšmetus.
                        Mēs arī esam cilvēku kopiena, kas rūpējas par mazo biznesu, cilvēku labklājību un
                        mūsu planētas aizsardzību.
                    </a>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Uzņemums</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li><a class="text-decoration-none" href="shop.php">Preces</a></li>
                    <li><a class="text-decoration-none" href="masters.php">Pārdevēji</a></li>
                    <li><a class="text-decoration-none" href="policy.php">Mūsu politika</a></li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 id="contacts" class="h2 text-light border-bottom pb-3 border-light">Kontaktinformācija</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li>
                        <i class="fa-solid fa-info brownicon"></i>
                        <a class="text-decoration-none">Ja Jums ir jautājumi vai vēlaties kaut ko precizēt, varat
                            sazināties ar mums!</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone-flip brownicon"></i>
                        <a class="text-decoration-none">+3712945681</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope brownicon"></i>
                        <a class="text-decoration-none">infokiriyena@gmail.com</a>
                    </li>
                </ul>
            </div>

        </div>


    </div>

    <div class="w-100  py-3">
        <div class="container">
            <div class="row pt-2">
                <div class="col-12">
                    <p class="text-center text-light">
                        Kiriyena &copy; 2023 Small start = Big deal <br>
                        Designed by <a rel="sponsored" href="#" target="_blank">Kiriyena</a>
                    </p>
                </div>
            </div>
        </div>
    </div>



</footer>


<script>
 window.addEventListener("load", function () {
    document.getElementById("tempaltemo_footer").style.visibility = "visible"; // показать footer
    var contentHeight = document.body.clientHeight;
    var windowHeight = window.innerHeight;
    if (contentHeight < windowHeight) {
        document.getElementById("tempaltemo_footer").style.position = "fixed";
        document.getElementById("tempaltemo_footer").style.bottom = "0";
        document.getElementById("tempaltemo_footer").style.left = "0";
        document.getElementById("tempaltemo_footer").style.width = "100%";
    } else {
        document.getElementById("tempaltemo_footer").style.position = "relative";
    }
});
</script>
