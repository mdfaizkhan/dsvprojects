<?php include('header.php'); ?>
<!-- main wrapper start -->
    <main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h2>contact</h2>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">contact us</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- contact area start -->
        <div class="contact-area">
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-lg-6">
                        <div class="contact-message pt-56 pb-60">
                            <h2>tell us your project</h2>
                            <form id="contact-form" action="https://demo.hasthemes.com/selena-preview/selena/assets/php/mail.php" method="post" class="contact-form">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="first_name" placeholder="Name *" type="text" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="phone" placeholder="Phone *" type="text" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="email_address" placeholder="Email *" type="text" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="contact_subject" placeholder="Subject *" type="text">
                                    </div>
                                    <div class="col-12">
                                        <div class="contact2-textarea text-center">
                                            <textarea placeholder="Message *" name="message" class="form-control2"
                                                required=""></textarea>
                                        </div>
                                        <div class="contact-btn">
                                            <button class="btn btn__bg btn__sqr" type="submit">Send Message</button>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <p class="form-messege"></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-info bg-gray pt-56 pb-md-46 mb-sm-24">
                            <h2>contact us</h2>
                            
                            <ul>
                                <li><i class="fa fa-fax"></i> Corporate Office : Varietiz Pharma Pvt Ltd.,<br> yashodeep housing society office no. 408, <br> near kailash complex vikroli Mumbai 400079. </li> 
                                <li><i class="fa fa-envelope-o"></i> info@varietiz.com</li>
                                <li><i class="fa fa-phone"></i>+91 9324345389</li>
                                <li><i class="fa fa-whatsapp"></i> +91 9324345389</li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- contact area end -->

        <!-- map area start -->
        <div class="map-area-wrapper">
            <div id="map_content" data-lat="19.105270" data-lng="72.934372" data-zoom="14" data-maptitle="Varietiz Pharma Pvt Ltd."
                data-mapaddress="yashodeep housing society office no. 408,near kailash complex vikroli Mumbai 400079.">
            </div>
        </div>
        <!-- map area end -->
    </main>
    <!-- main wrapper end -->
<?php include('footer.php'); ?>