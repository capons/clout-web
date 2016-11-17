<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
    <title>Tile View</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../../assets/css/flexboxgrid.min.css" />
    <link rel="stylesheet" href="../../../assets/css/customer_main.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="https://www.clout.com/assets/images/favicon.ico">
    <link rel="stylesheet"
    href="<?php echo base_url();?>assets/css/clout.menu.css"
    type="text/css" media="screen">
    <?php if(!empty($this->native_session->get('__user_id'))) { ?>
        <script type="text/javascript">
          i_user_id = "<?php echo $this->native_session->get('__user_id'); ?>";
      </script>
      <?php
  }?>
</head>

<body>

    <div class="headerBlock white">
        <div class="nav-wrapper">
            <div class="navbar navbar-fixed-top">

                <?php
        // Vertical menu content
                $this->load->view ( 'addons/vertical_menu', array (
                    '__page' => 'customer_home',
                    'area' => 'store_owner'
                    ) );
        // Header content

                $this->load->view ( 'addons/header_admin', array (
                    '__page' => 'customer_home',
                    'title' => 'Customers'
                    ) );

                    ?>
            <!--
            <a style="float:right; margin-right:20px;" href="javascript:;" onClick="location.href='<?php echo base_url();?>promotion/home_custom'"><img src="../assets/images/custom_view_inactive.png" width="55px" height="55px"  onmouseover="this.src='../assets/images/custom_view_active.png'" onmouseout="this.src='../assets/images/custom_view_inactive.png'"/></a>-->
            <ul class="right hide-on-med-and-down">
                <li>
                    <a href="/customer/home/" class="nav-icon">
                        <img src="<?php echo base_url();?>assets/images/customer/list_view_icon.png"  style="width: 30px; margin-top: 10px;"  alt="" />
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-icon">
                        <img src="<?php echo base_url();?>assets/images/customer/map_view_icon.png" alt="" />
                    </a>
                </li>
            </ul>
        </div>        






        <!-- <a href="#" class="brand-logo center">
            <img src="https://www.clout.com/assets/images/logo.png" /></a>
        <ul id="nav-mobile" class="left hide-on-med-and-down">
            <li>
                <a href="#" class="nav-icon">
                    <img src="../../../assets/images/customer/menu.png" style="transform: translateY(8px)" alt="" />
                </a>
            </li>
            <li><span class="bigWhiteText">Customers</span></li>
        </ul>
        <ul class="right hide-on-med-and-down">
            <li>
                <a href="/customer/home/" class="nav-icon">
                    <img src="../../../assets/images/customer/list_view_icon.png" style="transform: translateY(12px)" alt="" />
                </a>
            </li>
            <li>
                <a href="#" class="nav-icon">
                    <img src="../../../assets/images/customer/map_view_icon.png" style="transform: translateY(12px)" alt="" />
                </a>
            </li>
        </ul> -->
    </div>
</div>
<div id="flex-search">

    <span class="flex">
        <input type="text" id="filter-input" placeholder="  Filter By" />
    </span>
    <span class="flex-vert-center">
        <a class="searchBtn waves-effect waves-light btn filter-btn">Go</a>
    </span>
</div>
<div id="dash-header">

    <span style="flex: 1; display:flex; justify-content: space-between; align-items:center;padding-right: 10px">

        <div id="filterBy">
            <a class="tag noselect bigger-text" style="cursor: pointer;">
                Stores: <span>All</span>
                <img src="<?php echo base_url();?>assets/images/customer/arrow_down.png" class="dropdown-icon" />
            </a>

            <div class="menu" style="display:none">

                <div class="menu-row">
                    <span class="bold-menu-text">Stores:</span>
                    <input name="filterBy-stores" type="radio" id="all-store" checked="checked" />
                    <label for="all-store">All</label>
                    <input name="filterBy-stores" type="radio" id="choose-store" />
                    <label for="choose-store">Choose</label>
                </div>
                <div class="country-wrap">
            <!--  <div class="menu-row">
                 <span class="bold-menu-text">United States:</span>
                 <input name="filterBy-USA" type="radio" id="all-countries" />
                 <label for="all-countries">All</label>
                 <input name="filterBy-USA" type="radio" id="choose-country" checked="checked" />
                 <label for="choose-country">Choose</label>
             </div>

             <div class="menu-row">
                 <span class="spacer"></span>
                 <span style="font-weight: 400;">California:</span>
                 <input name="filterBy-california" type="radio" id="all-inState" />
                 <label for="all-inState">All</label>
                 <input name="filterBy-california" type="radio" id="choose-inState" checked="checked" />
                 <label for="choose-inState">Choose</label>
             </div>


             <div class="menu-columns">
                 <input type="checkbox" class="filled-in" id="filled-in-box" />
                 <label for="filled-in-box">Store : ID : Address</label>
                 <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
                 <label for="filled-in-box">Store : ID : Address</label>
                 <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
                 <label for="filled-in-box">Store : ID : Address</label>
             </div>

             <div class="menu-row">
                 <span class="spacer"></span>
                 <span style="font-weight: 400;">Florida:</span>
                 <input name="filterBy-florida" type="radio" id="all-inState" checked="checked" />
                 <label for="all-inState">All</label>
                 <input name="filterBy-florida" type="radio" id="choose-inState" />
                 <label for="choose-inState">Choose</label>
             </div>

             <div class="menu-row">
                 <span class="bold-menu-text">Mexico:</span>
                 <input name="filterBy-Mexico" type="radio" id="all-countries" checked="checked" />
                 <label for="all-countries">All</label>
                 <input name="filterBy-Mexico" type="radio" id="choose-country" />
                 <label for="choose-country">Choose</label>
             </div> -->

         </div>
         <div class="button-row">
            <a class="startFilterBtn waves-effect waves-light btn filter-btn button">Filter</a>
        </div>
        <div class="load-sircle-small"><img src="<?php echo base_url();?>assets/images/loading.gif" alt=""></div>

    </div>
</div>


<div id="viewBy">
    <a class="tag bigger-text noselect" style="cursor: pointer;">
        <span>Everyone</span>
        <img src="<?php echo base_url();?>assets/images/customer/arrow_down.png" class="dropdown-icon" />
    </a>

    <div class="menu" style="display:none">
        <input name="viewByRadio" type="radio" id="everyoneRadio" checked="checked" />
        <label for="everyoneRadio">Everyone</label>
        <input name="viewByRadio" type="radio" id="myCustomersRadio" />
        <label for="myCustomersRadio">My Customers</label>
        <input name="viewByRadio" type="radio" id="hereNowRadio" />
        <label for="hereNowRadio">Here Now</label>
        <input name="viewByRadio" type="radio" id="reservationsRadio" />
        <label for="reservationsRadio">Reservations</label>
    </div>
</div>
</span>
</div>


<div id="tileGrid" class="row">
    <div class="load-sircle"><img src="<?php echo base_url();?>assets/images/loading.gif" alt=""></div>
    <div class="noRes" style="display: none;">No results.</div>
    <div class="mainBlock row">
        <!---->
        <!--        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 tile-column">-->
        <!--            <div class="tile" style="background-image: url(https://randomuser.me/api/portraits/women/56.jpg); background-position: top center; background-size: 200px; background-repeat: no-repeat">-->
        <!--                <img class="corner" src="dependencies/corner.png" />-->
        <!--                <div class="top reservationBg" style="float: left">-->
        <!--                    <div class="resAlert"></div>-->
        <!--                    <h4 class="firstLine" style="font-size: 1em;">RESERVATIONS</h4>-->
        <!--                    <h4 class="secondLine" style="font-size: 1em;">10/2/2016 AT 8:30PM</h4>-->
        <!--                </div>-->
        <!--                <div class="bottom reservationBg">-->
        <!--                    <div class="checkinAlert">Here Now</div>-->
        <!--                    <div class="tile_Score"><span>49</span></div>-->
        <!--                    <div class="promos">-->
        <!--                        <div class="promo one"><span>10-20%</span></div>-->
        <!--                        <div class="promo two"><span>Perk</span></div>-->
        <!--                    </div>-->
        <!--                    <h1>Clout User</h1>-->
        <!--                    <h2>Dallas, TX</h2>-->
        <!--                    <h3>Network Size: 4434<br>Male, 72</h3>-->
        <!--                    <div class="storeActivity">-->
        <!--                        <div class="activityHeader">LITTLE CAESARS</div>-->
        <!--                        <div class="activityDetails">-->
        <!--                            <div class="amount">245</div>-->
        <!--                            <div class="identification">-->
        <!--                                STORE-->
        <!--                                <br> SPENDING-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                        <div class="activityDetails">-->
        <!--                            <div class="amount">&nbsp;55</div>-->
        <!--                            <div class="identification">TOTAL-->
        <!--                                <br>TRANSACTIONS</div>-->
        <!--                        </div>-->
        <!--                        <div class="activityDetails">-->
        <!--                            <div class="amount">$567</div>-->
        <!--                            <div class="identification">PROMO-->
        <!--                                <br>SPENDING</div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 tile-column">-->
        <!--            <div class="tile mobile" style="background-image: url(https://randomuser.me/api/portraits/men/60.jpg); background-position: top center">-->
        <!--                <img class="corner" src="dependencies/corner.png" />-->
        <!--                <div class="top neutralBg" style="float: left">-->
        <!--                    <div class="resAlert"></div>-->
        <!--                    <h4 class="firstLine" style="font-size: 1em;">RESERVATIONS</h4>-->
        <!--                    <h4 class="secondLine" style="font-size: 1em;">10/2/2016</h4></div>-->
        <!--                <div class="bottom neutralBg">-->
        <!--                    <div class="tile_Score"><span>998</span></div>-->
        <!--                    <div class="promos">-->
        <!--                        <div class="promo one"><span>10-20%</span></div>-->
        <!--                        <div class="promo two"><span>Perk</span></div>-->
        <!--                    </div>-->
        <!--                    <h1>Clout User</h1>-->
        <!--                    <h2>Dallas, TX</h2></div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        -->
    </div>

</div>
<?php echo minify_js('promotion__home', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js'));?>
<script src="https://code.jquery.com/jquery-2.2.3.js" integrity="sha256-laXWtGydpwqJ8JA+X9x2miwmaiKhn8tVmOVEigRNtP4=" crossorigin="anonymous"></script>
<!--<script src="tile_view.js" type="text/javascript"></script>-->
<script src="<?php echo base_url();?>assets/js/config.js"></script>
<script src="<?php echo base_url();?>assets/js/promotion.api.js"></script>
<!-- <script src="../../../assets/js/clout.customer_tile.js"></script> -->
<script src="<?php echo base_url();?>assets/js/clout.customer.js"></script>
</body>
</html>
