<?php include('header.php'); ?>
<style>
* {
  box-sizing: border-box;
}
.col-md-3{ padding: 5px; padding-top: 20px; padding-bottom: 20px;}
.double {border-style: double; color: gold; padding:2px !important;}
.zoom {
  padding: 0px;  
 /* transition: transform .2s;*/
  width: 100%;
  height: 100%px;
  margin: 0 auto;
}

.zoom:hover {
  -ms-transform: scale(1.5); /* IE 9 */
  -webkit-transform: scale(1.5); /* Safari 3-8 */
  transform: scale(1.5); 
}
/* [1] The container */
.img-hover-zoom {
  height: 400px; /* [1.1] Set it as per your need */
  overflow: hidden; /* [1.2] Hide the overflowing of child elements */
}

/* [2] Transition property for smooth transformation of images */
.img-hover-zoom img {
  transition: transform .5s ease;
}

/* [3] Finally, transforming the image when container gets hovered */
.img-hover-zoom:hover img {
  transform: scale(1.5);
}
</style>

<main>

   <section class="our-product pt-60">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="section-title text-center">
                  <h2>Varietiz Gallery</h2>
               </div>
               <p style="text-align: center; margin-top: -20px; margin-bottom: 10px;">Check out Varietiz Gallery</p>
            </div>
         </div>
         <div class="row product-carousel-active--4 slick-arrow-style slick-initialized slick-slider">
            <?php
                $sr=1;
                $q1=mysqli_query($db,"SELECT * FROM `gallery`");
                if(mysqli_num_rows($q1)>0)
                {
                while($r1=mysqli_fetch_assoc($q1))
                {
                ?>
                  <div class="col-md-3">
                  <div class="img-hover-zoom img-hover-zoom--xyz double">
                    <img src="upload/gallery/<?php echo $r1["image"]; ?>" width="100%;" height="100%"; alt="Image">
                  </div>
                  </div>
                    <?php } } ?>      
                  
               </div>
            </div>
            <!-- <button type="button" class="slick-next slick-arrow" style=""><i class="fa fa-angle-right"></i></button> -->
         </div>
      </div>
   </section>
   <!-- brand area end -->
</main>

<!-- Quick view modal end -->
<?php include('footer.php'); ?>

