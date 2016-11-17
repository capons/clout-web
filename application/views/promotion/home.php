<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" type="image/x-icon"
	href="https://www.clout.com/assets/images/favicon.ico">
	<title><?php echo SITE_TITLE.": Promotions";?></title>
	<link rel="stylesheet"
	href="<?php echo base_url();?>assets/css/external-fonts.css"
	type="text/css">
	<link rel="stylesheet"
	href="<?php echo base_url();?>assets/css/bootstrap.min.css"
	type="text/css" media="screen">
	<link rel="stylesheet"
	href="<?php echo base_url();?>assets/css/clout.shadowbox.css"
	type="text/css" media="screen">
	<link rel="stylesheet"
	href="<?php echo base_url();?>assets/css/clout.list.css"
	type="text/css" media="screen">
	<link rel="stylesheet"
	href="<?php echo base_url();?>assets/css/clout.pagination.css"
	type="text/css" media="screen">
	<link rel="stylesheet"
	href="<?php echo base_url();?>assets/css/clout.menu.css"
	type="text/css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.promotion.page.css">
	<!--
	    # move all styles used in this page from clout.old.css to clout.css
	    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/clout.old.css" type="text/css" media="screen"> -->

	<!-- <link rel="stylesheet"
		  href="<?php echo base_url();?>assets/css/clout.old.css" type="text/css"
		  media="screen"> -->
		  <link href="//fonts.googleapis.com/css?family=Roboto:400,300"
		  rel="stylesheet" type="text/css">
		  <style type="text/css">
		  	#page1 {
		  		position: relative;
		  	}

		  	#viewrow {
		  		cursor: pointer;
		  	}
		  </style>
		  <?php if(!empty($this->native_session->get('__user_id'))) { ?>
		  <script type="text/javascript">
		  	i_user_id = "<?php echo $this->native_session->get('__user_id'); ?>";
		  </script>
		  <?php
		}?>
	</head>

	<body>

		<!-- First Page -->
		<div id="page1" style="padding-top: 70px;">
			<div class="navbar navbar-fixed-top">

				<?php
		// Vertical menu content
				$this->load->view ( 'addons/vertical_menu', array (
					'__page' => 'promotion_home',
					'area' => 'store_owner'
					) );
		// Header content
				$this->load->view ( 'addons/header_admin', array (
					'__page' => 'promotion_home',
					'title' => 'Promotions'
					) );

					?>
					<a style="float:right; margin-right:20px;" href="javascript:;" onClick="location.href='<?php echo base_url();?>promotion/home_custom'"><img src="../assets/images/custom_view_inactive.png" width="55px" height="55px"  onmouseover="this.src='../assets/images/custom_view_active.png'" onmouseout="this.src='../assets/images/custom_view_inactive.png'"/></a>
				</div>
			</div>






			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<table width="100%" border="0" cellspacing="0" cellpadding="5">
						<tr>
							<td width="0%" style="padding-left: 20px;"><div
								class="bigscreendetails topleftheader" style="font-size: 22px;">Promotion Management by Score</div></td>
							</tr>
						</table>
					</tr>


					<!-- START Score Columns -->
					<div class="load-sircle"><img src="<?php echo base_url();?>assets/images/loading.gif" alt=""></div>
					<div class="wrap-all">
						<div class="main-content">
							<div class="content-wrap">
								<aside class="score-menu">
									<div class="menu-block"><span>Store Score</span></div>
									<div class="menu-block"><span>Perks</span></div>
									<div class="menu-block"><span>Cash Back</span></div>
								</aside>
								<div class="score-content">
									<div class="content-block" id="0">
										<div class="score-block"><span>0</span></div>
										<div class="score-block"><span class="perk-score">0</span></div>
										<div class="score-block"><span class="cashback-score">0</span></div>
										<div class="score-block view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="100">
										<div class="score-block score-green"><span>100</span></div>
										<div class="score-block score-green"><span class="perk-score">0</span></div>
										<div class="score-block score-green"><span class="cashback-score">0</span></div>
										<div class="score-block score-green view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="200">
										<div class="score-block score-darkgreen"><span>200</span></div>
										<div class="score-block score-darkgreen"><span class="perk-score">0</span></div>
										<div class="score-block score-darkgreen"><span class="cashback-score">0</span></div>
										<div class="score-block score-darkgreen view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="300">
										<div class="score-block score-lightgreen"><span>300</span></div>
										<div class="score-block score-lightgreen"><span class="perk-score">0</span></div>
										<div class="score-block score-lightgreen"><span class="cashback-score">0</span></div>
										<div class="score-block score-lightgreen view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="400">
										<div class="score-block score-lightblue"><span>400</span></div>
										<div class="score-block score-lightblue"><span class="perk-score">0</span></div>
										<div class="score-block score-lightblue"><span class="cashback-score">0</span></div>
										<div class="score-block score-lightblue view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="500">
										<div class="score-block score-blue"><span>500</span></div>
										<div class="score-block score-blue"><span class="perk-score">0</span></div>
										<div class="score-block score-blue"><span class="cashback-score">0</span></div>
										<div class="score-block score-blue view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="600">
										<div class="score-block score-purple"><span>600</span></div>
										<div class="score-block score-purple"><span class="perk-score">0</span></div>
										<div class="score-block score-purple"><span class="cashback-score">0</span></div>
										<div class="score-block score-purple view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="700">
										<div class="score-block score-darkpurple"><span>700</span></div>
										<div class="score-block score-darkpurple"><span class="perk-score">0</span></div>
										<div class="score-block score-darkpurple"><span class="cashback-score">0</span></div>
										<div class="score-block score-darkpurple view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="800">
										<div class="score-block score-lightgray"><span>800</span></div>
										<div class="score-block score-lightgray"><span class="perk-score">0</span></div>
										<div class="score-block score-lightgray"><span class="cashback-score">0</span></div>
										<div class="score-block score-lightgray view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="900">
										<div class="score-block score-gray"><span>900</span></div>
										<div class="score-block score-gray"><span class="perk-score">0</span></div>
										<div class="score-block score-gray"><span class="cashback-score">0</span></div>
										<div class="score-block score-gray view-score"><a href="#">+/View</a></div>
									</div>
									<div class="content-block" id="1000">
										<div class="score-block score-black"><span>1000+</span></div>
										<div class="score-block score-black"><span class="perk-score">0</span></div>
										<div class="score-block score-black"><span class="cashback-score">0</span></div>
										<div class="score-block score-black view-score"><a href="#">+/View</a></div>
									</div>
									<div class="details-window">
										<div class="promotion-list">

										</div>
										<div class="add-part">
											<div class="cashback-part">
												<div class="cashback-icon"></div>
												<a href="#">Build a new Cash back offer!</a>
											</div>
											<div class="cashback-part-prew">
												<div class="add-cashback-title">
													<div class="cashback-icon"></div>
													<span>Cash Back</span>
												</div>
												<div class="add-cashback-main">
													<div class="cashback-procent">
														<input type="number" placeholder="0"><span class="procent"> %</span>
													</div>
													<div class="add-buttons">
														<button class="options-btn cashback">Options</button>
														<button class="save-btn">Save</button>
														<button class="cancel-btn">Cancel</button>
													</div>
												</div>
											</div>
											<div class="perk-part">
												<div class="perk-icon"></div>
												<a href="#">Build a new Perk!</a>
											</div>
											<div class="perk-part-prew">
												<div class="add-perk-title">
													<div class="perk-icon"></div>
													<span>The Best Perk in the World!</span>
												</div>
												<div class="add-perk-main">
													<div class="perk-settings">
														<input type="text" placeholder="The Best Perk in the World!">
														<textarea type="text" placeholder="Description"></textarea>
														<span class="warning-about-charct">Beware of bad characters, e.g., <,\,></span>
													</div>
													<div class="add-buttons">
														<button class="options-btn perk">Options</button>
														<button class="save-btn">Save</button>
														<button class="cancel-btn">Cancel</button>
													</div>
												</div>
											</div>
										</div>
										<div class="add-cashback" data-id="null">
											<div class="cashback-part-add">
												<div class="new-cashback-title">
													<div class="cashback-icon">
														<p> 0 %</p>
													</div>
													<span>Cash Back</span>
													<div class="clearfix"></div>
												</div>
												<div class="add-cashback-main">
													<div class="cashback-procent">
														<input type="number" placeholder="0"><span class="procent"> %</span>
													</div>
													<div class="new-buttons">
														<button class="save-btn">Save</button>
														<button class="cancel-btn">Cancel</button>
													</div>
												</div>
											</div>
											<div class="tabs">
												<div class="tab-wrap active-tab" data-id="1">
													<a href="#">Locations</a>
												</div>
												<div class="tab-wrap" data-id="2">
													<a href="#">Run time</a>
												</div>
												<div class="tab-wrap" data-id="3">
													<a href="#">Blackouts</a>
												</div>
												<div class="tab-wrap" data-id="4">
													<a href="#">Create a custom QR code</a>
												</div>
											</div>
											<div class="setting-content">
												<div class="settings" data-id="1">
													<div class="stores">
														<form>
															<ul class="type-of-stores">
																<li>
																	<div class="squaredRadio">
																		<input type="radio" name="stores" class="spesific" id="spesific"/>
																		<label for="spesific"></label>
																	</div>
																	<span>Select specific stores</span>
																</li>
																<li>
																	<div class="squaredRadio">
																		<input type="radio" name="stores" class="all-stores" id="all-stores"/>
																		<label for="all-stores"></label>
																	</div>
																	<span>All my stores</span>
																</li>
															</ul>
														</form>
													</div>
													<div class="search-location">
														<form>
															<div class="view-loc">View locations by: 
																<input type="text" name="search" placeholder="Search in locations"></div>
																<div class="view-loc">
																	<span>or select from: </span>
																	<div class="locations">
																		<div class="squaredRadio">
																			<input type="radio" name="location" id="all" checked="checked" />
																			<label for="all"></label>
																		</div>
																		<span>all</span>
																	</div>
																	<div class="locations">
																		<div class="squaredRadio">
																			<input type="radio" name="location" id="country" />
																			<label for="country"></label>
																		</div>
																		<span>country</span>
																	</div> 
																	<div class="locations">
																		<div class="squaredRadio">
																			<input type="radio" name="location" id="state" />
																			<label for="state"></label>
																		</div>
																		<span>state</span>
																	</div>
																	<div class="locations">
																		<div class="squaredRadio">
																			<input type="radio" name="location" id="city" />
																			<label for="city"></label>
																		</div>
																		<span>city</span>
																	</div>
																</div>
															</form>
														</div>
														<div class="location-wrap">
															<div class="squaredCheck">
																<input type="checkbox" name="all" id="select-all-countries" />
																<label for="select-all-countries"></label>
															</div>
															<span>Select All</span>
															<ul class="location-list">
															</ul>
														</div>
															<div class="adress-wrap"><!-- 
																<input type="checkbox" id="select-all-stores" name="all-stores"><span>Select All</span> -->
																<ul class="adress-list">
																</ul>
															</div>
														</div>
														<div class="settings" data-id="2">
															<div class="date-wrap">
																<div class="start-date">
																	<h3 class="date-item">Start Date</h3>
																	<div class="date-block">
																		<div class="squaredRadio">
																			<input type="radio" name="published" id="published" />
																			<label for="published"></label>
																		</div>
																		<!-- <input type="radio" name="published"> -->
																		<span>When I publish it</span>
																	</div>
																	<div class="date-block">
																		<div class="squaredRadio time-margin">
																			<input type="radio" name="published" id="published-time" />
																			<label for="published-time"></label>
																		</div>
																		<span><input type="date" class="custom-date"></span>
																	</div>
																</div>
															</div>
															<div class="date-wrap">
																<div class="start-date">
																	<h3 class="date-item">End Date</h3>
																	<div class="end-date-block">
																		<div class="squaredRadio">
																			<input type="radio" name="end" id="end" />
																			<label for="end"></label>
																		</div>
																		<span>When I delete it</span>
																	</div>
																	<div class="end-date-block">
																		<div class="squaredRadio time-margin">
																			<input type="radio" name="end" id="end-time" />
																			<label for="end-time"></label>
																		</div>
																		<span><input class="custom-end-date" type="date"></span>
																	</div>
																</div>
															</div>
															<div class="spend-wrap">
																<h3>Max quantity available</h3>
																<div class="quantity-wrap">
																	<div class="squaredRadio">
																		<input type="radio" name="max-spend" id="max-spend" />
																		<label for="max-spend"></label>
																	</div>
																	<span>No Max</span>
																</div>
																<div class="quantity-wrap">
																	<div class="squaredRadio">
																		<input type="radio" name="max-spend" id="max-spend-custom" />
																		<label for="max-spend-custom"></label>
																	</div>
																	<span>
																		<select class="select-max-quant">
																			<option disabled selected>Enter quantity</option>
																			<option value="hour">hour</option>
																			<option value="week">week</option>
																			<option value="month">month</option>
																			<option value="year">year</option>
																			<option value="total">total</option>
																		</select>
																	</span>
																</div>
															</div>
														</div>
														<div class="settings" data-id="3">
															<div class="blackout-wrap">
																<div class="black-date">
																	<div class="squaredCheck blackout-margin">
																		<input type="checkbox" name="date" id="date" />
																		<label for="date"></label>
																	</div>
																	<span>Date:</span> <input type="date">
																</div>
																<div class="black-day">
																	<div class="squaredCheck blackout-margin">
																		<input type="checkbox" name="day" id="day" />
																		<label for="day"></label>
																	</div>
																	<span>Day:</span>
																	<select>
																		<option selected="selected">Monday</option>
																		<option>Tuesday</option>
																		<option>Wednesday</option>
																		<option>Thursday</option>
																		<option>Friday</option>
																		<option>Saturday</option>
																		<option>Sunday</option>
																	</select>
																</div>
																<div class="black-time">
																	<div class="squaredCheck blackout-margin">
																		<input type="checkbox" name="time" id="time" />
																		<label for="time"></label>
																	</div>
																	<span>Time: </span><input type="time"> to <input type="time">
																</div>
																<button class="generate-btn">Apply</button>
															</div>
															<div class="date-list">
																<ul>
																	<li>
																		<p><span>x</span>Sundays: 4am-8pm</p>
																	</li>
																	<li>
																		<p><span>x</span>December 12, 2015</p>
																	</li>
																	<li>
																		<p><span>x</span>January 2, 2016</p>
																	</li>
																	<li>
																		<p><span>x</span>Mondays: 8am-12pm, 3pm-4pm</p>
																	</li>
																	<li>
																		<p><span>x</span>Saturdays: 11am-11pm</p>
																	</li>
																</ul>
															</div>
														</div>
														<div class="settings" data-id="4">
															<div class="custom-qr-wrap">
																<div class="add-qr">
																	<div><span>Email Address:</span><input type="text" placeholder="name@email.com"></div>
																	<div><span class="typeOfMassege">Data Type:	</span>
																		<input type="radio" name="type" checked="checked"><span>Website</span>
																		<input type="radio" name="type"><span>Phone#</span>
																		<input type="radio" name="type"><span>SMS</span>
																		<input type="radio" name="type"><span>Text</span>
																	</div>
																	<div><span>Website URL:</span><input type="text" placeholder="http://www.clout.com"></div>
																	<button class="generate-btn">Generate</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</table>





						<?php $this->load->view('addons/footer_admin'); ?>
					</div>
					<?php echo minify_js('promotion__home', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js'));?>
					<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
					<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
					<script src="<?php echo base_url();?>assets/js/config.js"></script>
					<script src="<?php echo base_url();?>assets/js/promotion.api.js"></script>
					<script src="<?php echo base_url();?>assets/js/clout.promotion.js"></script>
				</body>
				</html>
