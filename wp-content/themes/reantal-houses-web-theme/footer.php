
<div>

    <footer class="text-center text-lg-start">
        
        <!-- Social -->
        <section class="social text-light d-flex flex-column align-items-center justify-content-center justify-content-lg-between gap-2 p-4 border-bottom">

            <div class="d-flex justify-content-center align-items-center d-none d-lg-block">
                <span class="text-black">Get connected with us on social networks:</span>
            </div>

            <div class="d-flex justify-content-center align-items-center gap-5">
                <a class="social-links px-2 text-black" href="https://www.facebook.com/profile.php?id=rentalhouse" target="_blank">
                    <i class="fab fa-facebook-f fs-3"></i>
                </a>
                <a class="social-links px-2 text-black" href="https://www.instagram.com/rentalhouse/" target="_blank">
                    <i class="fab fa-instagram fs-3"></i>
                </a>
                <a class="social-links px-2 text-black" href="https://www.linkedin.com/in/rentalhouse/" target="_blank">
                    <i class="fab fa-linkedin fs-3"></i>
                </a>
                <a class="social-links px-2 text-black" href="https://github.com/rentalhouse" target="_blank" >
                    <i class="fab fa-github fs-3"></i>
                </a>
            </div>

        </section>
        <!-- Social -->

        <!--company info -->
        <section>
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-5 col-lg-4  mx-auto mb-4">

                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>Rental Homes
                        </h6>

                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Blanditiis minima mollitia et aspernatur ratione assumenda, aut quidem, quasi laudantium quisquam unde sequi sint! Rerum perspiciatis minima explicabo esse, veniam dolorum?
                        </p>
                    </div>

                    <div class="col-md-5 col-lg-4  mx-auto my-auto mb-4">

                        <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                        
                        <div class="mb-3">
                            <a href="https://www.google.com/maps?q=47.05027,8.27817" target="_blank" class="contact-links text-reset text-decoration-none d-flex align-items-center justify-content-center justify-content-md-start justify-content-md-start gap-2">
                                <i class="fas fa-home fs-3 p-1"></i><span> Longstreet 50, City 601432, ZZ</span>
                            </a> 
                        </div>

                        <div class="mb-3">
                            <a href="mailto:websiteadress@website.com?subject=Web visit message:" target="_blank" class="contact-links text-reset text-decoration-none d-flex align-items-center justify-content-center justify-content-md-start justify-content-md-start gap-2">
                                <i class="fas fa-envelope fs-3 p-1"></i><span> websiteadress@website.com</span>
                            </a>
                        </div>

                        <div class="mb-3">
                            <a href="tel:+999 66 999 66 99" target="_blank" class="contact-links text-reset text-decoration-none d-flex align-items-center justify-content-center justify-content-md-start justify-content-md-start gap-2">
                                <i class="fas fa-phone fs-3 p-1"></i><span> +999 66 999 66 99</span>
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        <!--company info -->

        <!-- Copyright -->
        <section class="copyright text-center p-4 d-none" style="background-color: rgba(0, 0, 0, 0.05);">

            <p>&copy; <?php echo date('Y'); ?> Rental Homes. All rights reserved.</p>

        </section>
        <!-- Copyright -->
    </footer>
</div>

    


<footer class="d-none">
    <!-- Testo del copyright dinamico con l'anno corrente -->
    <!-- Dynamic copyright text with the current year -->
    <p>&copy; <?php echo date('Y'); ?> Rental Homes. All rights reserved.</p>
</footer>

<!-- Aggiunge gli hook e gli script necessari di WordPress -->
<!-- Adds the necessary WordPress hooks and scripts -->
<?php wp_footer(); ?>

</body>
</html>