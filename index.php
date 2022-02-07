<?php include('header.php'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="text/html; charset=iso-8859-2" http-equiv="Content-Type">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<!-- main wrapper start -->
<style>
.mySlides {display:none;}
</style>

<div id="page" class="hfeed site grid-container container grid-parent">
	<div id="content" class="site-content">
		<div id="primary" class="content-area grid-parent mobile-grid-100 grid-100 tablet-grid-100">
			<main id="main" class="site-main">
				<article id="post-7" class="post-7 page type-page status-publish" itemtype="https://schema.org/CreativeWork" itemscope>
					<div class="inside-article">
						<div class="entry-content" itemprop="text">
							<div data-elementor-type="wp-post" data-elementor-id="7" class="elementor elementor-7" data-elementor-settings="[]">
								<div class="elementor-inner">
									<div class="elementor-section-wrap">
										<section class="elementor-section elementor-top-section elementor-element elementor-element-3765f594 elementor-section-full_width elementor-section-stretched elementor-section-height-default elementor-section-height-default" data-id="3765f594" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
										<div class="elementor-container elementor-column-gap-default">
											<div class="elementor-row">
												<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-5122b658" data-id="5122b658" data-element_type="column">
													<div class="elementor-column-wrap elementor-element-populated">
														<div class="elementor-widget-wrap">
															<div class="elementor-element elementor-element-193091c elementor--h-position-left elementor--v-position-middle elementor-arrows-position-inside elementor-pagination-position-inside elementor-widget elementor-widget-slides" data-id="193091c" data-element_type="widget" data-settings="{&quot;navigation&quot;:&quot;both&quot;,&quot;autoplay&quot;:&quot;yes&quot;,&quot;pause_on_hover&quot;:&quot;yes&quot;,&quot;pause_on_interaction&quot;:&quot;yes&quot;,&quot;autoplay_speed&quot;:5000,&quot;infinite&quot;:&quot;yes&quot;,&quot;transition&quot;:&quot;slide&quot;,&quot;transition_speed&quot;:500}" data-widget_type="slides.default">
																<div class="elementor-widget-container">
																	<div class="elementor-swiper">
																		<div class="elementor-slides-wrapper elementor-main-swiper swiper-container" dir="ltr" data-animation="fadeInUp">
																			<div class="swiper-wrapper elementor-slides">
																				<?php
																				$sr=1;
                																$q1=mysqli_query($db,"SELECT * FROM `slider`");
																	                if(mysqli_num_rows($q1)>0)
																	                {
																	                while($r1=mysqli_fetch_assoc($q1))
																	                {
																	                ?>
																				<div class="elementor-repeater-item-f4506fd swiper-slide">
																					<div class="swiper-slide-bg" style="background-image: url(upload/slider/<?php echo $r1['image']; ?>)">
																					</div>
																					<div class="swiper-slide-inner" >
																						<div class="swiper-slide-contents">
																							<div class="elementor-slide-heading">LET'S SKIN SHINE WITH MIRACLE EE FOUNDATION</div>
																							<div class="elementor-slide-description">Invest in your skin,it is going to represent you for a very long time. With Miracle EE Foundation you will never regret it.</div>
																							<a href="our-dealer/index.html" class="elementor-button elementor-slide-button elementor-size-xs">BUY NOW</a></div>
																						</div>
																				</div>
																				 <?php } } ?>
																			</div>
																			<div class="swiper-pagination">
																			</div>
																			<div class="elementor-swiper-button elementor-swiper-button-prev">
																				<i class="eicon-chevron-left" aria-hidden="true"></i>
																				<span class="elementor-screen-only">Previous</span>
																			</div>
																			<div class="elementor-swiper-button elementor-swiper-button-next">
																				<i class="eicon-chevron-right" aria-hidden="true"></i>
																				<span class="elementor-screen-only">Next</span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</section>
									<section class="elementor-section elementor-top-section elementor-element elementor-element-f2c9f1f elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="f2c9f1f" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
										<div class="elementor-container elementor-column-gap-default">
											<div class="elementor-row">
												<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-5241b151" data-id="5241b151" data-element_type="column">
													<div class="elementor-column-wrap elementor-element-populated">
														<div class="elementor-widget-wrap">
															<div class="elementor-element elementor-element-a3062b6 elementor-headline--style-rotate elementor-widget elementor-widget-animated-headline" data-id="a3062b6" data-element_type="widget" data-settings="{&quot;headline_style&quot;:&quot;rotate&quot;,&quot;animation_type&quot;:&quot;flip&quot;,&quot;rotating_text&quot;:&quot;Financial Freedom\nFreedom Of Choice \nFreedom Of Time&quot;,&quot;loop&quot;:&quot;yes&quot;,&quot;rotate_iteration_delay&quot;:2500}" data-widget_type="animated-headline.default">
																<div class="elementor-widget-container">
																	<h2 class="elementor-headline elementor-headline-animation-type-flip">
																		<span class="elementor-headline-plain-text elementor-headline-text-wrapper">We can bring</span>
																		<span class="elementor-headline-dynamic-wrapper elementor-headline-text-wrapper">
																			<span class="elementor-headline-dynamic-text elementor-headline-text-active">
																				Financial&nbsp;Freedom			
																			</span>
																			<span class="elementor-headline-dynamic-text ">
																				Freedom&nbsp;Of&nbsp;Choice&nbsp;
																			</span>
																			<span class="elementor-headline-dynamic-text ">
																				Freedom&nbsp;Of&nbsp;Time
																			</span>
																		</span>
																		<span class="elementor-headline-plain-text elementor-headline-text-wrapper">to you life</span>
																	</h2>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</section>
									<section class="elementor-section elementor-top-section elementor-element elementor-element-49a42da3 elementor-section-stretched elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="49a42da3" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
										<div class="elementor-background-overlay"></div>
										<div class="elementor-container elementor-column-gap-default">
											<div class="elementor-row">
												<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-50b59f60" data-id="50b59f60" data-element_type="column">
													<div class="elementor-column-wrap elementor-element-populated">
														<div class="elementor-widget-wrap">
															<section class="elementor-section elementor-inner-section elementor-element elementor-element-64be485 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="64be485" data-element_type="section">
																<div class="elementor-container elementor-column-gap-default">
																	<div class="elementor-row">
																		<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-4e35659" data-id="4e35659" data-element_type="column">
																			<div class="elementor-column-wrap elementor-element-populated">
																				<div class="elementor-widget-wrap">
																					<div class="elementor-element elementor-element-efa87dd elementor-view-framed elementor-position-left elementor-shape-circle elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="efa87dd" data-element_type="widget" data-widget_type="icon-box.default">
																						<div class="elementor-widget-container">
																							<div class="elementor-icon-box-wrapper">
																								<div class="elementor-icon-box-icon">
																									<span class="elementor-icon elementor-animation-" >
																								<i class="fa fa-flask" aria-hidden="true"></i>				</span>
																							</div>
																						<div class="elementor-icon-box-content">
																							<h3 class="elementor-icon-box-title">
																								<span >PROVEN</span>
																							</h3>
																							<p class="elementor-icon-box-description">Our own R&D team constantly find pure and patent ingredients from nature review scientific literature and conduct their own studies to verify efficacy and utmost effectiveness.</p>
																						</div>
																					</div>
																					</div>
																					</div>
																				</div>
																			</div>
																		</div>
													<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-c013ec8" data-id="c013ec8" data-element_type="column">
														<div class="elementor-column-wrap elementor-element-populated">
																<div class="elementor-widget-wrap">
															<div class="elementor-element elementor-element-2aaf150 elementor-view-framed elementor-position-left elementor-shape-circle elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="2aaf150" data-element_type="widget" data-widget_type="icon-box.default">
															<div class="elementor-widget-container">
														<div class="elementor-icon-box-wrapper">
															<div class="elementor-icon-box-icon">
													<span class="elementor-icon elementor-animation-" >
													<i class="fa fa-check" aria-hidden="true"></i>				</span>
												</div>
															<div class="elementor-icon-box-content">
													<h3 class="elementor-icon-box-title">
														<span >QUALITY</span>
													</h3>
																	<p class="elementor-icon-box-description">Safe products come from quality ingredients, so that's what we use. Unconditional safety is of utmost importance in our products and assure you our standards are unsurpassed. </p>
																</div>
											</div>
													</div>
													</div>
															</div>
														</div>
											</div>
																	</div>
														</div>
											</section>
				<section class="elementor-section elementor-inner-section elementor-element elementor-element-a92fa3b elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="a92fa3b" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-e4b1044" data-id="e4b1044" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-10fc5d7 elementor-view-framed elementor-position-left elementor-shape-circle elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="10fc5d7" data-element_type="widget" data-widget_type="icon-box.default">
				<div class="elementor-widget-container">
					<div class="elementor-icon-box-wrapper">
						<div class="elementor-icon-box-icon">
				<span class="elementor-icon elementor-animation-" >
				<i class="fa fa-heart" aria-hidden="true"></i>				</span>
			</div>
						<div class="elementor-icon-box-content">
				<h3 class="elementor-icon-box-title">
					<span >HONEST</span>
				</h3>
								<p class="elementor-icon-box-description">We are honest with our products. We declare everything we put inside our product. Not a single ingredient is omitted.</p>
							</div>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-fd95137" data-id="fd95137" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-e2e9512 elementor-view-framed elementor-position-left elementor-shape-circle elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="e2e9512" data-element_type="widget" data-widget_type="icon-box.default">
				<div class="elementor-widget-container">
					<div class="elementor-icon-box-wrapper">
						<div class="elementor-icon-box-icon">
				<span class="elementor-icon elementor-animation-" >
				<i class="fa fa-life-saver" aria-hidden="true"></i>				</span>
			</div>
						<div class="elementor-icon-box-content">
				<h3 class="elementor-icon-box-title">
					<span >SAFE</span>
				</h3>
								<p class="elementor-icon-box-description">Harmful products are freely available in the market and it is very worrying. This needs to change and thus why we are here.</p>
							</div>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
				<section class="elementor-section elementor-top-section elementor-element elementor-element-750ec87 elementor-section-stretched elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="750ec87" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-9018127" data-id="9018127" data-element_type="column">
<div class="elementor-column-wrap elementor-element-populated">
	<div class="elementor-widget-wrap">
		<section class="elementor-section elementor-inner-section elementor-element elementor-element-6675d22 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="6675d22" data-element_type="section">
			<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
					<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-a203c68" data-id="a203c68" data-element_type="column">
						<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
								<div class="elementor-element elementor-element-6e66f15 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="6e66f15" data-element_type="widget" data-widget_type="divider.default">
									<div class="elementor-widget-container">
										<div class="elementor-divider">
											<span class="elementor-divider-separator">
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-fc1ce26" data-id="fc1ce26" data-element_type="column">
					<div class="elementor-column-wrap elementor-element-populated">
						<div class="elementor-widget-wrap">
							<div class="elementor-element elementor-element-4b993fb elementor-widget elementor-widget-heading" data-id="4b993fb" data-element_type="widget" data-widget_type="heading.default">
								<div class="elementor-widget-container">
									<h2 class="elementor-heading-title elementor-size-default">OUR PRODUCTS</h2>		
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-24ba372" data-id="24ba372" data-element_type="column">
					<div class="elementor-column-wrap elementor-element-populated">
						<div class="elementor-widget-wrap">
							<div class="elementor-element elementor-element-6afc6e0 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="6afc6e0" data-element_type="widget" data-widget_type="divider.default">
								<div class="elementor-widget-container">
									<div class="elementor-divider">
										<span class="elementor-divider-separator">
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</section>
		<section class="elementor-section elementor-inner-section elementor-element elementor-element-1e4d684 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="1e4d684" data-element_type="section">
			<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
					<?php
						$result=mysqli_query($db, "SELECT product_id,name,image FROM products");
						while($row=mysqli_fetch_array($result)){?>
							<div class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-8176608" data-id="8176608" data-element_type="column">
								<div class="elementor-column-wrap elementor-element-populated">
									<div class="elementor-widget-wrap">
										<div class="elementor-element elementor-element-1727069 elementor-widget elementor-widget-image" data-id="1727069" data-element_type="widget" data-widget_type="image.default">
										<div class="elementor-widget-container">
											<div class="elementor-image">
												<img width="1200" height="800" src="upload/product/<?php echo $row['image'];?>" class="attachment-full size-full" alt="ADAM SUPPLEMENT"  sizes="(max-width: 1200px) 100vw, 1200px" />									
											</div>
										</div>
										</div>
										<div class="elementor-element elementor-element-5171474 elementor-widget elementor-widget-heading" data-id="5171474" data-element_type="widget" data-widget_type="heading.default">
											<div class="elementor-widget-container">
												<h3 class="elementor-heading-title elementor-size-default"><?php echo $row['name'];?></h3>		
											</div>
										</div>
									</div>
								</div>
							</div>
					<?php
						}
					?>		
				</div>
				</div>
			</section>
		</div>
	</div>
	</div>
	</div>
	</div>
		</section>
				<section class="elementor-section elementor-top-section elementor-element elementor-element-65394a27 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="65394a27" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;gradient&quot;,&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
						<div class="elementor-container elementor-column-gap-no">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-3d08dbd5" data-id="3d08dbd5" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<section class="elementor-section elementor-inner-section elementor-element elementor-element-71f6e97 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="71f6e97" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-0291cbf" data-id="0291cbf" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-b971919 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="b971919" data-element_type="widget" data-widget_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-7944518" data-id="7944518" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-25eab3c elementor-widget elementor-widget-heading" data-id="25eab3c" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">TESTIMONIAL</h2>		</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-817d9bb" data-id="817d9bb" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-57070be elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="57070be" data-element_type="widget" data-widget_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
				<div class="elementor-element elementor-element-6dccc66a elementor-testimonial--layout-image_above elementor-testimonial--skin-default elementor-testimonial--align-center elementor-arrows-yes elementor-pagination-type-bullets elementor-widget elementor-widget-testimonial-carousel" data-id="6dccc66a" data-element_type="widget" data-settings="{&quot;space_between&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:22,&quot;sizes&quot;:[]},&quot;show_arrows&quot;:&quot;yes&quot;,&quot;pagination&quot;:&quot;bullets&quot;,&quot;speed&quot;:500,&quot;autoplay&quot;:&quot;yes&quot;,&quot;autoplay_speed&quot;:5000,&quot;loop&quot;:&quot;yes&quot;,&quot;pause_on_hover&quot;:&quot;yes&quot;,&quot;pause_on_interaction&quot;:&quot;yes&quot;,&quot;space_between_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:10,&quot;sizes&quot;:[]},&quot;space_between_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:10,&quot;sizes&quot;:[]}}" data-widget_type="testimonial-carousel.default">
				<div class="elementor-widget-container">
					<div class="elementor-swiper">
			<div class="elementor-main-swiper swiper-container">
				<div class="swiper-wrapper">
											<div class="swiper-slide">
									<div class="elementor-testimonial">
							<div class="elementor-testimonial__content">
					<div class="elementor-testimonial__text">
						“Dulu saya mengalami period tak teratur, kulit kusam dan selalu penat. Alhamdulillah sejak amalkan SL Supplement kini saya sentiasa bertenaga, malah period saya kembali stabil dan yang lagi best kulit makin licin dan lembut. Yang penting bagi saya ialah badan makin sihat dan nampak awet muda. Tak menyesal amalkan produk dari Secrets Living. Thank You Secrets Living.”					</div>
					<cite class="elementor-testimonial__cite"><span class="elementor-testimonial__name">Pn yusnita</span><span class="elementor-testimonial__title">manager sl, ipoh</span></cite>				</div>
						<div class="elementor-testimonial__footer">
									<div class="elementor-testimonial__image">
						<img src="wp-content/uploads/2019/03/KAK-YUS.jpg" alt="Pn yusnita">
					</div>
											</div>
		</div>
								</div>
											<div class="swiper-slide">
									<div class="elementor-testimonial">
							<div class="elementor-testimonial__content">
					<div class="elementor-testimonial__text">
						“Masalah saya sebelum amalkan SL Supplement adalah selalu letih, kulit kusam dan kering, tapi sejak amalkan SL Supplement ni badan makin bertenaga, kulit kembali lembap dan licin dan yang lagi best berat badan pun turun. Tapi yang paling penting badan semakin sihat dan semakin muda. Produk dari Secrets Living ternyata cukup berkesan.
Thank You Secrets Living.”
					</div>
					<cite class="elementor-testimonial__cite"><span class="elementor-testimonial__name">pn ramla</span><span class="elementor-testimonial__title">manager sl, melaka</span></cite>				</div>
						<div class="elementor-testimonial__footer">
									<div class="elementor-testimonial__image">
						<img src="wp-content/uploads/2019/03/KAK-RAMLA.jpg" alt="pn ramla">
					</div>
											</div>
		</div>
								</div>
											<div class="swiper-slide">
									<div class="elementor-testimonial">
							<div class="elementor-testimonial__content">
					<div class="elementor-testimonial__text">
						“Saya nak share masalah yang saya alami sebelum amalkan produk dari Secrets Living. Dulu saya ada masalah sakit tumit, period xteratur, kulit kering dan selalu penat. Alhamdulillah sekarang tumit saya dah tak sakit, period kembali teratur dan kulit lembap dan makin cerah sekata. Yang paling best badan makin sihat dan awet muda giteww. Thank You Secrets Living.”					</div>
					<cite class="elementor-testimonial__cite"><span class="elementor-testimonial__name">pn june</span><span class="elementor-testimonial__title">manager sl, sarawak</span></cite>				</div>
						<div class="elementor-testimonial__footer">
									<div class="elementor-testimonial__image">
						<img src="wp-content/uploads/2019/03/KAK-JUNE-2.jpg" alt="pn june">
					</div>
											</div>
		</div>
								</div>
											<div class="swiper-slide">
									<div class="elementor-testimonial">
							<div class="elementor-testimonial__content">
					<div class="elementor-testimonial__text">
						“Dulu saya mengalami masalah cepat letih, kulit kering dan kusam. Selain tu, saya badan selalu penat. Alhamdulillah sejak amalkan Produk dari Secrets Living masalah saya selesai. Kini perut saya dan kempis macam waktu remaja dulu, kulit pun makin licin dan kulit lebih cerah. Yang paling penting badan saya sihat dan nampak bertambah muda dari usia. Thank You Secrets Living.”					</div>
					<cite class="elementor-testimonial__cite"><span class="elementor-testimonial__name">pn arabaya</span><span class="elementor-testimonial__title"> leader, tapah,perak</span></cite>				</div>
						<div class="elementor-testimonial__footer">
									<div class="elementor-testimonial__image">
						<img src="wp-content/uploads/2019/12/69699822_2446207562370926_5342075795869270016_n.jpg" alt="pn arabaya">
					</div>
											</div>
		</div>
								</div>
									</div>
															<div class="swiper-pagination"></div>
																<div class="elementor-swiper-button elementor-swiper-button-prev">
							<i class="eicon-chevron-left" aria-hidden="true"></i>
							<span class="elementor-screen-only">Previous</span>
						</div>
						<div class="elementor-swiper-button elementor-swiper-button-next">
							<i class="eicon-chevron-right" aria-hidden="true"></i>
							<span class="elementor-screen-only">Next</span>
						</div>
												</div>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
				<section class="elementor-section elementor-top-section elementor-element elementor-element-30324ad4 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="30324ad4" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-3d1d393a" data-id="3d1d393a" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-150fcd3 elementor-headline--style-rotate elementor-widget elementor-widget-animated-headline" data-id="150fcd3" data-element_type="widget" data-settings="{&quot;headline_style&quot;:&quot;rotate&quot;,&quot;animation_type&quot;:&quot;clip&quot;,&quot;rotating_text&quot;:&quot;Your Life\nYour Financial\nYour Time&quot;,&quot;loop&quot;:&quot;yes&quot;,&quot;rotate_iteration_delay&quot;:2500}" data-widget_type="animated-headline.default">
				<div class="elementor-widget-container">
					<h3 class="elementor-headline elementor-headline-animation-type-clip">
					<span class="elementor-headline-plain-text elementor-headline-text-wrapper">Start Improving</span>
				<span class="elementor-headline-dynamic-wrapper elementor-headline-text-wrapper">
					<span class="elementor-headline-dynamic-text elementor-headline-text-active">
				Your&nbsp;Life			</span>
					<span class="elementor-headline-dynamic-text ">
				Your&nbsp;Financial			</span>
					<span class="elementor-headline-dynamic-text ">
				Your&nbsp;Time			</span>
						</span>
					<span class="elementor-headline-plain-text elementor-headline-text-wrapper">Today!</span>
					</h3>
				</div>
				</div>
				<div class="elementor-element elementor-element-5c26c189 elementor-widget elementor-widget-text-editor" data-id="5c26c189" data-element_type="widget" data-widget_type="text-editor.default">
				<div class="elementor-widget-container">
								<div class="elementor-text-editor elementor-clearfix">
					<p style="text-align: center;">You have the ability to make a difference not only in your own life, but in the lives of those you will meet and those surrounded you.</p>					</div>
						</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
				<section class="elementor-section elementor-top-section elementor-element elementor-element-44f9fb52 elementor-section-content-middle elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="44f9fb52" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
							<div class="elementor-background-overlay"></div>
							<div class="elementor-container elementor-column-gap-no">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-7f5f4def" data-id="7f5f4def" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<section class="elementor-section elementor-inner-section elementor-element elementor-element-21c5c1c elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="21c5c1c" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-b0dc483" data-id="b0dc483" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-e3f0fbe elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="e3f0fbe" data-element_type="widget" data-widget_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-a86d172" data-id="a86d172" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-7bead3e elementor-widget elementor-widget-heading" data-id="7bead3e" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">BENEFITS BEING OUR TEAM</h2>		</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-dd72bd1" data-id="dd72bd1" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-0ce2d39 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="0ce2d39" data-element_type="widget" data-widget_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
				<section class="elementor-section elementor-inner-section elementor-element elementor-element-7459d2c2 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="7459d2c2" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-30fea0fe" data-id="30fea0fe" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-cfb28ee elementor-view-default elementor-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="cfb28ee" data-element_type="widget" data-widget_type="icon-box.default">
				<div class="elementor-widget-container">
					<div class="elementor-icon-box-wrapper">
						<div class="elementor-icon-box-icon">
				<span class="elementor-icon elementor-animation-grow" >
				<i class="fa fa-address-card-o" aria-hidden="true"></i>				</span>
			</div>
						<div class="elementor-icon-box-content">
				<h3 class="elementor-icon-box-title">
					<span >Distributor Membership</span>
				</h3>
							</div>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-2298a0d5" data-id="2298a0d5" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-3b0806da elementor-view-default elementor-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="3b0806da" data-element_type="widget" data-widget_type="icon-box.default">
				<div class="elementor-widget-container">
					<div class="elementor-icon-box-wrapper">
						<div class="elementor-icon-box-icon">
				<span class="elementor-icon elementor-animation-grow" >
				<i class="fa fa-user-plus" aria-hidden="true"></i>				</span>
			</div>
						<div class="elementor-icon-box-content">
				<h3 class="elementor-icon-box-title">
					<span >Unlimited Referral Bonus</span>
				</h3>
								<p class="elementor-icon-box-description"> </p>
							</div>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-7181fa47" data-id="7181fa47" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-3a788321 elementor-view-default elementor-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="3a788321" data-element_type="widget" data-widget_type="icon-box.default">
				<div class="elementor-widget-container">
					<div class="elementor-icon-box-wrapper">
						<div class="elementor-icon-box-icon">
				<span class="elementor-icon elementor-animation-grow" >
				<i class="fa fa-money" aria-hidden="true"></i>				</span>
			</div>
						<div class="elementor-icon-box-content">
				<h3 class="elementor-icon-box-title">
					<span >Generate Five Figures Income</span>
				</h3>
								<p class="elementor-icon-box-description"> </p>
							</div>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
				<section class="elementor-section elementor-inner-section elementor-element elementor-element-efec732 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="efec732" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-1186a487" data-id="1186a487" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-64a8ee2 elementor-view-default elementor-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="64a8ee2" data-element_type="widget" data-widget_type="icon-box.default">
				<div class="elementor-widget-container">
					<div class="elementor-icon-box-wrapper">
						<div class="elementor-icon-box-icon">
				<span class="elementor-icon elementor-animation-grow" >
				<i class="fa fa-percent" aria-hidden="true"></i>				</span>
			</div>
						<div class="elementor-icon-box-content">
				<h3 class="elementor-icon-box-title">
					<span >Up To 15% Discount</span>
				</h3>
							</div>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-1cad3366" data-id="1cad3366" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-72b3380b elementor-view-default elementor-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="72b3380b" data-element_type="widget" data-widget_type="icon-box.default">
				<div class="elementor-widget-container">
					<div class="elementor-icon-box-wrapper">
						<div class="elementor-icon-box-icon">
				<span class="elementor-icon elementor-animation-grow" >
				<i class="fa fa-group" aria-hidden="true"></i>				</span>
			</div>
						<div class="elementor-icon-box-content">
				<h3 class="elementor-icon-box-title">
					<span >Expand Your Network</span>
				</h3>
							</div>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
				<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-5b73f87e" data-id="5b73f87e" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-10eef988 elementor-view-default elementor-position-top elementor-vertical-align-top elementor-widget elementor-widget-icon-box" data-id="10eef988" data-element_type="widget" data-widget_type="icon-box.default">
				<div class="elementor-widget-container">
					<div class="elementor-icon-box-wrapper">
						<div class="elementor-icon-box-icon">
				<span class="elementor-icon elementor-animation-grow" >
				<i class="fa fa-industry" aria-hidden="true"></i>				</span>
			</div>
						<div class="elementor-icon-box-content">
				<h3 class="elementor-icon-box-title">
					<span >Own Your Business</span>
				</h3>
							</div>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
				<section class="elementor-section elementor-top-section elementor-element elementor-element-fdadd39 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="fdadd39" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;stretch_section&quot;:&quot;section-stretched&quot;}">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-68144666" data-id="68144666" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<section class="elementor-section elementor-inner-section elementor-element elementor-element-9d8d193 elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="9d8d193" data-element_type="section">
						<div class="elementor-container elementor-column-gap-default">
							<div class="elementor-row">
					<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-895d574" data-id="895d574" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-52c98e8 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="52c98e8" data-element_type="widget" data-widget_type="divider.default">
				<div class="elementor-widget-container">
					<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
				</div>
				</div>
						</div>
					</div>
		</div>
		<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-ab30ece" data-id="ab30ece" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
				<div class="elementor-widget-wrap">
					<div class="elementor-element elementor-element-2dcc3fa elementor-widget elementor-widget-heading" data-id="2dcc3fa" data-element_type="widget" data-widget_type="heading.default">
						<div class="elementor-widget-container">
							<h2 class="elementor-heading-title elementor-size-default">SECRETS LIVING'S BLOG</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="elementor-column elementor-col-33 elementor-inner-column elementor-element elementor-element-1622612" data-id="1622612" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
				<div class="elementor-widget-wrap">
					<div class="elementor-element elementor-element-fce1418 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="fce1418" data-element_type="widget" data-widget_type="divider.default">
						<div class="elementor-widget-container">
							<div class="elementor-divider">
								<span class="elementor-divider-separator">
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
		</div>
		</section>
			<div class="elementor-element elementor-element-d6be50e elementor-grid-3 elementor-grid-tablet-2 elementor-grid-mobile-1 elementor-posts--thumbnail-top elementor-posts--show-avatar elementor-card-shadow-yes elementor-posts__hover-gradient elementor-widget elementor-widget-posts" data-id="d6be50e" data-element_type="widget" data-settings="{&quot;cards_columns&quot;:&quot;3&quot;,&quot;cards_columns_tablet&quot;:&quot;2&quot;,&quot;cards_columns_mobile&quot;:&quot;1&quot;,&quot;cards_row_gap&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:35,&quot;sizes&quot;:[]}}" data-widget_type="posts.cards">
				<div class="elementor-widget-container">
					<div class="elementor-posts-container elementor-posts elementor-posts--skin-cards elementor-grid">
						<article class="elementor-post elementor-grid-item post-2839 post type-post status-publish format-standard has-post-thumbnail hentry category-tips-kesihatan">
							<div class="elementor-post__card">
								<a class="elementor-post__thumbnail__link" href="8-tips-hilangkan-kesan-gigitan-nyamuk-pada-bayi/index.html" >
									<div class="elementor-post__thumbnail">
										<img width="300" height="200" src="wp-content/uploads/2019/12/GIGITAN-NYAMUK-300x200.jpg" class="attachment-medium size-medium" alt="" srcset="https://secretsliving.com/wp-content/uploads/2019/12/GIGITAN-NYAMUK-300x200.jpg 300w, https://secretsliving.com/wp-content/uploads/2019/12/GIGITAN-NYAMUK-768x512.jpg 768w, https://secretsliving.com/wp-content/uploads/2019/12/GIGITAN-NYAMUK.jpg 1000w" sizes="(max-width: 300px) 100vw, 300px" /></div>
								</a>
				<div class="elementor-post__badge">Tips Kesihatan</div>
				<div class="elementor-post__avatar">
			<img alt='Secrets Living' src='https://secure.gravatar.com/avatar/41ffefeefa9cd3518907f22e16f43762?s=128&amp;d=mm&amp;r=g' srcset='https://secure.gravatar.com/avatar/41ffefeefa9cd3518907f22e16f43762?s=256&#038;d=mm&#038;r=g 2x' class='avatar avatar-128 photo' height='128' width='128' />		</div>
				<div class="elementor-post__text">
				<h3 class="elementor-post__title">
			<a href="8-tips-hilangkan-kesan-gigitan-nyamuk-pada-bayi/index.html" >
				8 TIPS HILANGKAN KESAN GIGITAN NYAMUK PADA BAYI			</a>
		</h3>
				<div class="elementor-post__excerpt">
			<p>Anak anda selalu kena gigit nyamuk? Hati-hati ya. Gigitan nyamuk tak boleh dipandang mudah. Kadang-kadang, kanak-kanak boleh terkena jangkitan&nbsp;malaria,&nbsp;demam denggi&nbsp;atau&nbsp;demam</p>
		</div>
					<a class="elementor-post__read-more" href="8-tips-hilangkan-kesan-gigitan-nyamuk-pada-bayi/index.html" >
				Read More »			</a>
				</div>
					</div>
		</article>
				<article class="elementor-post elementor-grid-item post-2834 post type-post status-publish format-standard has-post-thumbnail hentry category-tips-kecantikan">
			<div class="elementor-post__card">
				<a class="elementor-post__thumbnail__link" href="ramai-orang-tak-tahu-minyak-sapi-untuk-kulit-dan-rambut/index.html" >
			<div class="elementor-post__thumbnail"><img width="300" height="225" src="wp-content/uploads/2019/11/minyak-sapi-300x225.jpg" class="attachment-medium size-medium" alt="" srcset="https://secretsliving.com/wp-content/uploads/2019/11/minyak-sapi-300x225.jpg 300w, https://secretsliving.com/wp-content/uploads/2019/11/minyak-sapi-768x576.jpg 768w, https://secretsliving.com/wp-content/uploads/2019/11/minyak-sapi.jpg 1000w" sizes="(max-width: 300px) 100vw, 300px" /></div>
		</a>
				<div class="elementor-post__badge">Tips Kecantikan</div>
				<div class="elementor-post__avatar">
			<img alt='Secrets Living' src='https://secure.gravatar.com/avatar/41ffefeefa9cd3518907f22e16f43762?s=128&amp;d=mm&amp;r=g' srcset='https://secure.gravatar.com/avatar/41ffefeefa9cd3518907f22e16f43762?s=256&#038;d=mm&#038;r=g 2x' class='avatar avatar-128 photo' height='128' width='128' />		</div>
				<div class="elementor-post__text">
				<h3 class="elementor-post__title">
			<a href="ramai-orang-tak-tahu-minyak-sapi-untuk-kulit-dan-rambut/index.html" >
				RAMAI ORANG TAK TAHU MINYAK SAPI UNTUK KULIT DAN RAMBUT			</a>
		</h3>
				<div class="elementor-post__excerpt">
			<p>Pelbagai khasiat terkandung dalam minyak sapi dimana ia sesuai untuk menangani masalah kulit dan rambut. MINYAK&nbsp;sapi terhasil daripada kandungan lemak</p>
		</div>
					<a class="elementor-post__read-more" href="ramai-orang-tak-tahu-minyak-sapi-untuk-kulit-dan-rambut/index.html" >
				Read More »			</a>
				</div>
					</div>
		</article>
				<article class="elementor-post elementor-grid-item post-2825 post type-post status-publish format-standard has-post-thumbnail hentry category-tips-kesihatan">
			<div class="elementor-post__card">
				<a class="elementor-post__thumbnail__link" href="sakit-lutut-mengganggu-anda-untuk-bergerak-kemana-mana-jangan-risau-mari-saya-kongsikan-tips-untuk-bebas-dari-sakit-lutut/index.html" >
			<div class="elementor-post__thumbnail"><img width="300" height="200" src="wp-content/uploads/2019/11/sakit-lutut-300x200.png" class="attachment-medium size-medium" alt="" srcset="https://secretsliving.com/wp-content/uploads/2019/11/sakit-lutut-300x200.png 300w, https://secretsliving.com/wp-content/uploads/2019/11/sakit-lutut-768x512.png 768w, https://secretsliving.com/wp-content/uploads/2019/11/sakit-lutut-1024x683.png 1024w, https://secretsliving.com/wp-content/uploads/2019/11/sakit-lutut.png 1200w" sizes="(max-width: 300px) 100vw, 300px" /></div>
		</a>
				<div class="elementor-post__badge">Tips Kesihatan</div>
				<div class="elementor-post__avatar">
			<img alt='Secrets Living' src='https://secure.gravatar.com/avatar/41ffefeefa9cd3518907f22e16f43762?s=128&amp;d=mm&amp;r=g' srcset='https://secure.gravatar.com/avatar/41ffefeefa9cd3518907f22e16f43762?s=256&#038;d=mm&#038;r=g 2x' class='avatar avatar-128 photo' height='128' width='128' />		</div>
				<div class="elementor-post__text">
				<h3 class="elementor-post__title">
			<a href="sakit-lutut-mengganggu-anda-untuk-bergerak-kemana-mana-jangan-risau-mari-saya-kongsikan-tips-untuk-bebas-dari-sakit-lutut/index.html" >
				SAKIT LUTUT MENGGANGGU ANDA UNTUK BERGERAK KEMANA-MANA, JANGAN RISAU MARI SAYA KONGSIKAN TIPS UNTUK BEBAS DARI SAKIT LUTUT			</a>
		</h3>
				<div class="elementor-post__excerpt">
			<p>Di Malaysia masalah sakit sendi lutut adalah salah satu penyakit yang biasa dialami oleh sebilangan besar masyarakat di sini dan</p>
		</div>
					<a class="elementor-post__read-more" href="sakit-lutut-mengganggu-anda-untuk-bergerak-kemana-mana-jangan-risau-mari-saya-kongsikan-tips-untuk-bebas-dari-sakit-lutut/index.html" >
				Read More »			</a>
				</div>
					</div>
		</article>
				</div>
				</div>
				</div>
						</div>
					</div>
		</div>
								</div>
					</div>
		</section>
		<section class="elementor-section elementor-top-section elementor-element elementor-element-39538a1 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="39538a1" data-element_type="section" data-settings="{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;gradient&quot;}">
			<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
					<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-83452f6" data-id="83452f6" data-element_type="column">
						<div class="elementor-column-wrap elementor-element-populated">
							<div class="elementor-widget-wrap">
						<div class="elementor-element elementor-element-cc83d02 elementor-widget elementor-widget-heading" data-id="cc83d02" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-default">Subscribe to Secrets Living's Newsletter & Offer</h2>		</div>
				</div>
				<div class="elementor-element elementor-element-7957611 elementor-widget elementor-widget-text-editor" data-id="7957611" data-element_type="widget" data-widget_type="text-editor.default">
				<div class="elementor-widget-container">
								<div class="elementor-text-editor elementor-clearfix">
					<h2>Sign up for <strong>Chance To Win a Free Product</strong> and monthly newsletter for product news and exclusive promotions</h2>					</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-b06a9bd elementor-align-center elementor-widget elementor-widget-button" data-id="b06a9bd" data-element_type="widget" data-widget_type="button.default">
				<div class="elementor-widget-container">
					<div class="elementor-button-wrapper">
			<a href="#elementor-action%3Aaction%3Dpopup%3Aopen%26settings%3DeyJpZCI6IjIzODciLCJ0b2dnbGUiOmZhbHNlfQ%3D%3D" class="elementor-button-link elementor-button elementor-size-md elementor-animation-grow" role="button">
						<span class="elementor-button-content-wrapper">
						<span class="elementor-button-text">SIGN UP NOW</span></span></a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
								</div>
							</div>
						</div><!-- .entry-content -->
					</div><!-- .inside-article -->
				</article><!-- #post-## -->
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->
</div><!-- #page -->


<?php include 'footer.php'?>
<?php include 'linkfooter.php'?>
