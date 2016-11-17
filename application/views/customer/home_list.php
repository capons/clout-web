<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
    <title>Customer List View</title>
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/normalize/4.1.1/normalize.min.css" media="screen" title="no title" charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet"
    href="<?php echo base_url();?>assets/css/bootstrap.min.css"
    type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/customer_main.min.css" media="screen" title="no title" charset="utf-8">
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

<!--<script src="../../../assets/js/mocked_customer_details.js" charset="utf-8"></script>-->

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
                    <a href="/customer/home_tile/" class="nav-icon">
                        <img src="<?php echo base_url();?>assets/images/customer/tile_view_icon.png" alt="" />
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-icon">
                        <img src="<?php echo base_url();?>assets/images/customer/map_view_icon.png" alt="" />
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- <nav class="grey">

    <div class="nav-wrapper">
        <a href="#" class="brand-logo center">
            <img src="https://www.clout.com/assets/images/logo.png" /></a>
        <ul id="nav-mobile" class="left hide-on-med-and-down">
            <li>
                <a href="#" class="nav-icon">
                    <img src="<?php echo base_url();?>assets/images/customer/menu.png" style="transform: translateY(8px)" alt="" />
                </a>
            </li>
            <li><span class="bigWhiteText">Customers</span></li>
        </ul>
        <ul class="right hide-on-med-and-down">
            <li>
                <a href="/customer/home_tile/" class="nav-icon">
                    <img src="<?php echo base_url();?>assets/images/customer/tile_view_icon.png" style="transform: translateY(12px)" alt="" />
                </a>
            </li>
            <li>
                <a href="#" class="nav-icon">
                    <img src="<?php echo base_url();?>assets/images/customer/map_view_icon.png" style="transform: translateY(12px)" alt="" />
                </a>
            </li>
        </ul>
    </div>
</nav> -->
<div id="flex-search">
    <span class="flex">
        <input type="text" id="filter-input" placeholder="  Filter By" />
    </span>
    <span class="flex-vert-center">
        <a class="searchBtn waves-effect waves-light btn filter-btn">Go</a>
    </span>
</div>
<div id="dash-header">

    <div id="filterBy">
        <a class="tag noselect bigger-text" style="cursor: pointer;">
            Stores: <span>All</span>
            <img src="<?php echo base_url();?>assets/images/customer/arrow_down.png" class="dropdown-icon" />
        </a>

        <div class="menu" style="display:none">

            <div class="menu-row">
                <span class="bold-menu-text">Stores:</span>
                <input name="filterBy-stores" type="radio" id="all-store" checked="true" />
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
    <div id="bigRez">

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

</div>

<div id="requested-feature" class="modal center-align">

    <div class="modal-content">
        <h4 id="featureName">Request Premium Data</h4>
        <h6 id="featureDetails">This is a planned feature. To request this functionality and to better assist us in prioritizing its release date, please let us know the following:</h6>
        <br>
        <form id="modal-form" action="#">
            <p style="text-align:center"><b>How important is this feature to you?</b></p>
            <span><i>Not Important</i>&nbsp;&nbsp;</span>
            <input name="group1" type="radio" id="test1" />
            <label for="test1">1</label>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="group1" type="radio" id="test2" />
            <label for="test2">2</label>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="group1" type="radio" id="test3" />
            <label for="test3">3</label>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="group1" type="radio" id="test4" />
            <label for="test4">4</label>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="group1" type="radio" id="test5" />
            <label for="test5">5</label>
            <span>&nbsp;&nbsp;<i>Most Important</i></span>
            <br>
            <p style="text-align:center"><b>What monthly subscription fee would you be willing to pay to receive all premium data for the users who match your selected filters?</b></p>
            <input style="text-align:right;max-width: 75px;" id="input_text" type="number" min="0.01" step="0.01" max="2500" value="00.00">&nbsp;$ per user
            <br>
            <p style="text-align:center"><b>Comments, Questions, or Suggestions? (Optional)</b></p>
            <textarea style="text-align:left;max-width: 350px;padding: 0;" id="textarea1" class="materialize-textarea"></textarea>
        </form>
    </div>
    <div class="modal-footer center-align">
        <a href="#!" id="submitModalForm" class="modal-action modal-close waves-effect waves-green btn-flat" style="float:none">
            Request
        </a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" style="float:none">
            Cancel
        </a>
    </div>
</div>


<div id="list-view">
    <div class="load-sircle"><img src="<?php echo base_url();?>assets/images/loading.gif" alt=""></div>
    <div class="noRes" style="display: none;">No results.</div>

    <div id="static-columns">
        <div id="customer-list" class="static-section-content">

        </div>
    </div>
    <div id="sortable-overlay">
        <div class="sortable-overlay-column no-subsections">
            <div class="collapse collapse-label handle" style="display: none;">
                <img src="../../../assets/images/customer/arrow_closed.png" class="closed_arrow" />
                <div><span>STORE</span></div>
                <img src="../../../assets/images/customer/arrow_closed.png" class="closed_arrow bottom" />

            </div>
            <div id="store">
                <div class="section-header collapse handle blueBg">
                    <img src="<?php echo base_url();?>assets/images/customer/arrow_opened.png" alt="" />STORE
                </div>
                <div class="section-content blueLeftBorder blueBg"></div>
                <div class="section-content blueLeftBorder blueBg" style="display: none;">
                    <div class="content-column">


                        <div class="content-column-header">
                            <div class="simple-sort">
                                <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                            </div>
                            <div class="flex">
                                <span>SCORE</span>
                                <a class="header-hover">
                                    <img src="<?php echo base_url();?>assets/images/customer/arrow_down.png" />
                                </a>

                                <!--
                                                                        <div style="position: absolute; background-color: white; flex-direction: column; border: 2px solid grey; padding:10px; z-index: 100; transform: translate(-22px, 32px); font-family:'Roboto'; font-weight: 500; ">

                                                                    <input style="display:flex" name="showSumtin" type="radio" id="showPending" />
                                                                    <label style="display:flex; color: black;" for="showPending">=

                                                                            </label>

                                                                    <input style="display:flex" name="showSumtin" type="radio" id="showApproved" />
                                                                    <label style="display:flex; color: black;" for="showApproved">&gt;</label>

                                                                    <input style="display:flex" name="showSumtin" type="radio" id="showCanceled" />
                                                                    <label style="display:flex; color: black;" for="showCanceled"> 	&lt; </label>

                                                                    <input style="display:flex" name="showSumtin" type="radio" id="showAllSumtin" checked="checked" />
                                                                    <label style="display:flex; color: black;" for="showAllSumtin">Show All</label>

                                                                    </div>
                                                                -->

                                                            </div>
                                                        </div>


                                                        <div class="content-column-data score greenScore">
                                                            540
                                                        </div>
                                                        <div class="content-column-data score purpleScore">
                                                            162
                                                        </div>
                                                        <div class="content-column-data score greenScore">
                                                            540
                                                        </div>
                                                        <div class="content-column-data score purpleScore">
                                                            162
                                                        </div>
                                                        <div class="content-column-data score blueScore">
                                                            700
                                                        </div>

                                                    </div>
                    <!--
                                            <div class="content-column">
                                                <div class="content-column-header premium">
                                                    <span class="">Age</span>
                                                    <img src="icons/arrow_down.png" class="header-hover" />
                                                </div>
                                                <div class="premium-content-data">
                                                    <span>REQUEST</span>
                                                </div>
                                            </div>
                                        -->

                                        <div class="content-column">
                                            <div class="content-column-header">
                                                <div class="simple-sort">
                                                    <img class="icon"  src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                                </div>
                                                <div class="flex">
                                                    <span>In-Store Spending</span>
                                                    <a class="header-hover">
                                                        <img src="<?php echo base_url();?>assets/images/customer/arrow_down.png" />
                                                    </a>
                                <!--


                                                                    <div style="position: absolute; background-color: white; flex-direction: column; border: 2px solid grey; padding:10px; z-index: 100; transform: translate(-22px, 32px); font-family:'Roboto'; font-weight: 500; ">

                                                                        <input type="checkbox" class="filled-in" id="data-dropdown-menu" checked="checked" />
                                                                        <label for="data-dropdown-menu" style="color:black; font-size: 15px">Show checkins between:</label><br/>
                                                                        <div style="display:flex; flex: 1; flex-direction: row; align-items: center; justify-content: center">
                                                                            <div class="spacer"></div> <div class="spacer"></div>
                                                                            <input type="text" style="width: 50px; height: 25px; border: 1px solid black" value=" 05/21/16" />

                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                                            <div style="font-weight: 900; transform: scale(2.5);">-</div>

                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                                            <input type="text" style="width: 50px; height: 25px; border: 1px solid black" value=" 05/27/16" />
                                                                        </div>

                                                                    </div>
                                                                -->


                                                            </div>
                                                        </div>

                                                        <div class="content-column-data">
                                                            90%
                                                        </div>
                                                        <div class="content-column-data">
                                                            90%
                                                        </div>
                                                        <div class="content-column-data">
                                                            90%
                                                        </div>
                                                        <div class="content-column-data">
                                                            90%
                                                        </div>
                                                        <div class="content-column-data">
                                                            90%
                                                        </div>

                                                    </div>
                                                    <div class="content-column">
                                                        <div class="content-column-header">
                                                            <span class="simple-sort">
                                                                <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                                            </span>
                                                            <span class="flex">
                                                                <span>Competitor Spending</span>
                                                                <a class="header-hover">
                                                                    <img src="<?php echo base_url();?>assets/images/customer/arrow_down.png" /></a>
                                                                </span>
                                                            </div>
                                                            <div class="content-column-data">
                                                                1.0%
                                                            </div>
                                                            <div class="content-column-data">
                                                                1.0%
                                                            </div>
                                                            <div class="content-column-data">
                                                                1.0%
                                                            </div>
                                                            <div class="content-column-data">
                                                                1.0%
                                                            </div>
                                                            <div class="content-column-data">
                                                                1.0%
                                                            </div>

                                                        </div>
                    <!--
                                            <div class="content-column">
                                                <div class="content-column-header premium">
                                                    <span class="">Location</span>
                                                    <img src="icons/arrow_down.png" class="header-hover" />
                                                </div>
                                                <div class="premium-content-data">
                                                    <span>REQUEST</span>
                                                </div>
                                            </div>
                                        -->
                                        <div class="content-column">
                                            <div class="content-column-header">
                                                <span class="simple-sort">
                                                    <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                                </span>
                                                <span class="flex">
                                                    <span>Category Spending</span>
                                                    <a class="header-hover">
                                                        <img src="<?php echo base_url();?>assets/images/customer/arrow_down.png" /></a>

<!--
                                <div style="position: absolute; background-color: white; flex-direction: column; border: 2px solid grey; padding:10px; z-index: 100; transform: translate(-22px, 32px); font-family:'Roboto'; font-weight: 500; ">

                                    <input style="display:flex" name="ShowDD" type="radio" id="showPending" />
                                    <label style="display:flex; color: black;" for="showPending">Show Pending</label>

                                    <input style="display:flex" name="ShowDD" type="radio" id="showApproved" />
                                    <label style="display:flex; color: black;" for="showApproved">Show Approved</label>

                                    <input style="display:flex" name="ShowDD" type="radio" id="showCanceled" />
                                    <label style="display:flex; color: black;" for="showCanceled">Show Cancelled</label>

                                    <input style="display:flex" name="ShowDD" type="radio" id="showAll" checked="checked" />
                                    <label style="display:flex; color: black;" for="showAll">Show All</label>

                                    </div>
                                -->

                            </span>
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>

                    </div>
                    <div class="content-column">
                        <div class="content-column-header">
                            <span class="simple-sort" >
                                <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                            </span>
                            <span class="flex">
                                <span>Related Spending</span>
                                <a class="header-hover">
                                    <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                </a>
                            </span>
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>

                    </div>
                    <div class="content-column">
                        <div class="content-column-header">
                            <span class="simple-sort">
                                <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                            </span>
                            <span class="flex">
                                <span>Overall Spending</span>
                                <a class="header-hover">
                                    <img src="../../../assets/images/customer/arrow_down.png" /></a>

<!--
                                 <div style="position: absolute; background-color: white; flex-direction: column; border: 2px solid grey; padding:10px; z-index: 100; transform: translate(-22px, 32px); font-family:'Roboto'; font-weight: 500; ">

                                        <input type="checkbox" class="filled-in" id="data-dropdown-menu" checked="checked" />
                                        <label for="data-dropdown-menu" style="color:black; font-size: 15px">Show reservations between:</label><br/>
                                        <div style="display:flex; flex: 1; flex-direction: row; align-items: center; justify-content: center">
                                            <div class="spacer"></div> <div class="spacer"></div>
                                            <input type="text" style="width: 50px; height: 25px; border: 1px solid black" value=" 05/21/16" />

                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            <div style="font-weight: 900; transform: scale(2.5);">-</div>

                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            <input type="text" style="width: 50px; height: 25px; border: 1px solid black" value=" 05/27/16" />
                                        </div>

                                    </div>
                                -->

                            </span>

                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>
                        <div class="content-column-data">
                            50%
                        </div>

                    </div>
                    <div class="content-column">
                        <div class="content-column-header">
                            <span class="simple-sort" >
                                <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                            </span>
                            <span class="flex">
                                <span>Linked Accounts</span>
                                <a class="header-hover">
                                    <img src="../../../assets/images/customer/arrow_down.png"/></a>
                                </span>
                            </div>
                            <div class="content-column-data">
                                50%
                            </div>
                            <div class="content-column-data">
                                50%
                            </div>
                            <div class="content-column-data">
                                50%
                            </div>
                            <div class="content-column-data">
                                50%
                            </div>
                            <div class="content-column-data">
                                50%
                            </div>

                        </div>
                        <div class="content-column">
                            <div class="content-column-header">
                                <span class="simple-sort" >
                                    <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                </span>
                                <span class="flex">
                                    <span>Activity</span>
                                    <a class="header-hover">
                                        <img src="../../../assets/images/customer/arrow_down.png" /></a>
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    50%
                                </div>
                                <div class="content-column-data">
                                    50%
                                </div>
                                <div class="content-column-data">
                                    50%
                                </div>
                                <div class="content-column-data">
                                    50%
                                </div>
                                <div class="content-column-data">
                                    50%
                                </div>

                            </div>

                        </div>
                        <div class="section-header collapse handle blueBg">
                            <img src="<?php echo base_url();?>assets/images/customer/arrow_opened.png" alt="" />STORE
                        </div>
                    </div>
                </div>
                <div class="sortable-overlay-column no-subsections">

                    <div class=" collapse collapse-label handle" style="display: none">
                        <img src="../../../assets/images/customer/arrow_closed.png" class="closed_arrow" />
                        <div><span>CUSTOMER DETAILS</span></div>
                        <img src="../../../assets/images/customer/arrow_closed.png" class="closed_arrow bottom" />
                    </div>
                    <div id="customer_details">
                        <div class="section-header collapse handle greyBg">
                            <img src="<?php echo base_url();?>assets/images/customer/arrow_opened.png" alt="" />
                            CUSTOMER DETAILS
                        </div>
                        <div class="section-content greyLeftBorder greyBg"></div>
                        <div class="section-content greyLeftBorder greyBg" style="display: none">
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        City
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    Los Angeles
                                </div>
                                <div class="content-column-data">
                                    Hogwarts
                                </div>
                                <div class="content-column-data">
                                    Narnia
                                </div>
                                <div class="content-column-data">
                                    Seattle
                                </div>
                                <div class="content-column-data">
                                    Los Angeles
                                </div>

                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        State
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    CA
                                </div>
                                <div class="content-column-data">
                                    NY
                                </div>
                                <div class="content-column-data">
                                    DC
                                </div>
                                <div class="content-column-data">
                                    CA
                                </div>
                                <div class="content-column-data">
                                    CA
                                </div>

                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        Zip
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    90037
                                </div>
                                <div class="content-column-data">
                                    90037
                                </div>
                                <div class="content-column-data">
                                    90037
                                </div>
                                <div class="content-column-data">
                                    90037
                                </div>
                                <div class="content-column-data">
                                    90037
                                </div>

                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        Country
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    USA
                                </div>
                                <div class="content-column-data">
                                    Canada
                                </div>
                                <div class="content-column-data">
                                    Antartica
                                </div>
                                <div class="content-column-data">
                                    Atlantis
                                </div>
                                <div class="content-column-data">
                                    USA
                                </div>


                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        Gender
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    M
                                </div>
                                <div class="content-column-data">
                                    F
                                </div>
                                <div class="content-column-data">
                                    ?
                                </div>
                                <div class="content-column-data">
                                    F
                                </div>
                                <div class="content-column-data">
                                    M
                                </div>

                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        Age
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    23
                                </div>
                                <div class="content-column-data">
                                    31
                                </div>
                                <div class="content-column-data">
                                    ?
                                </div>
                                <div class="content-column-data">
                                    42
                                </div>
                                <div class="content-column-data">
                                    58
                                </div>


                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        Custom Label
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    Favorite Customer
                                </div>
                                <div class="content-column-data">
                                    Shareholder
                                </div>
                                <div class="content-column-data">
                                    Celebrity
                                </div>
                                <div class="content-column-data">
                                    Influencer
                                </div>
                                <div class="content-column-data">
                                    Friend of Shareholders
                                </div>

                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        <span style="color: black; font-size: 11px;">Notes</span>
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    Seating Priority! Treat as VIP
                                </div>
                                <div class="content-column-data">
                                    <a>+ note</a>
                                </div>
                                <div class="content-column-data">
                                    <a>+ note</a>
                                </div>
                                <div class="content-column-data">
                                    Alonso likes champagne.
                                </div>
                                <div class="content-column-data">
                                    VIP customer and big network
                                </div>

                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        Priority
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    High: Big Spender
                                </div>
                                <div class="content-column-data">
                                    High: New Customer
                                </div>
                                <div class="content-column-data">
                                    Normal: Customer
                                </div>
                                <div class="content-column-data">
                                    High: New Customer
                                </div>
                                <div class="content-column-data">
                                    Enrolled via "VIP Sign In With Clout"
                                </div>

                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        Network
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    5,690
                                </div>
                                <div class="content-column-data">
                                    35,690
                                </div>
                                <div class="content-column-data">
                                    17
                                </div>
                                <div class="content-column-data">
                                    105,690
                                </div>
                                <div class="content-column-data">
                                    1,000,000
                                </div>

                            </div>
                            <div class="content-column">
                                <div class="content-column-header">
                                    <span class="simple-sort" >
                                        <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                    </span>
                                    <span class="flex">
                                        Invites
                                        <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                    </span>
                                </div>
                                <div class="content-column-data">
                                    15,650
                                </div>
                                <div class="content-column-data">
                                    45,888
                                </div>
                                <div class="content-column-data">
                                    20
                                </div>
                                <div class="content-column-data">
                                    450,000
                                </div>
                                <div class="content-column-data">
                                    4,500,000
                                </div>

                            </div>

                        </div>
                        <div class="section-header collapse handle greyBg" style="background-color: #666666; color: white;">
                            <img src="<?php echo base_url();?>assets/images/customer/arrow_opened.png" alt="" />CUSTOMER DETAILS</div>
                        </div>
                    </div>
                    <div class="sortable-overlay-column no-subsections">

                        <div class="collapse collapse-label handle" style="display:none">
                            <img src="../../../assets/images/customer/arrow_closed.png" class="closed_arrow" />
                            <div><span>RESERVATIONS</span></div>
                            <img src="../../../assets/images/customer/arrow_closed.png" class="closed_arrow bottom" />
                        </div>
                        <div id="reservations">
                            <div class="section-header collapse handle lightblueBg">
                                <img src="<?php echo base_url();?>assets/images/customer/arrow_opened.png" alt="" /> RESERVATIONS
                            </div>
                            <div class="section-content lightblueLeftBorder lightblueBg"></div>
                            <div class="section-content lightblueLeftBorder lightblueBg" style="display: none">
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Upcoming
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        10/02/15
                                    </div>
                                    <div class="content-column-data">
                                        10/02/15
                                    </div>
                                    <div class="content-column-data">
                                        10/02/15
                                    </div>
                                    <div class="content-column-data">
                                        10/02/15
                                    </div>
                                    <div class="content-column-data">
                                        10/02/15
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Time
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        8:57pm
                                    </div>
                                    <div class="content-column-data">
                                        12:21am
                                    </div>
                                    <div class="content-column-data">
                                        1:33pm
                                    </div>
                                    <div class="content-column-data">
                                        6:40am
                                    </div>
                                    <div class="content-column-data">
                                        5:06am
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Type
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        Event
                                    </div>
                                    <div class="content-column-data">
                                        Private Shopping Experience
                                    </div>
                                    <div class="content-column-data">
                                        Hotel Room
                                    </div>
                                    <div class="content-column-data">
                                        Table
                                    </div>
                                    <div class="content-column-data">
                                        Test Drive
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Size
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        10
                                    </div>
                                    <div class="content-column-data">
                                        2
                                    </div>
                                    <div class="content-column-data">
                                        3
                                    </div>
                                    <div class="content-column-data">
                                        4
                                    </div>
                                    <div class="content-column-data">
                                        5
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Status
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data pending">
                                        pending
                                    </div>
                                    <div class="content-column-data approved">
                                        approved
                                    </div>
                                    <div class="content-column-data cancelled">
                                        cancelled
                                    </div>
                                    <div class="content-column-data pending">
                                        pending
                                    </div>
                                    <div class="content-column-data approved">
                                        approved
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            <span style="color: black">Action!</span>
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data checkbox-data">
                                        <div class="clout-checkbox">
                                            <input type="checkbox" value="None" id="action1" name="check" checked />
                                            <label for="action1">approve</label>
                                        </div>
                                        <div class="clout-checkbox">
                                            <input type="checkbox" value="None" id="action2" name="check" />
                                            <label for="action2">deny</label>
                                        </div>
                                    </div>
                                    <div class="content-column-data">

                                    </div>
                                    <div class="content-column-data">

                                    </div>
                                    <div class="content-column-data checkbox-data">
                                        <div class="clout-checkbox">
                                            <input type="checkbox" value="None" id="action3" name="check" checked />
                                            <label for="action3">approve</label>
                                        </div>
                                        <div class="clout-checkbox">
                                            <input type="checkbox" value="None" id="action4" name="check" />
                                            <label for="action4">deny</label>
                                        </div>
                                    </div>
                                    <div class="content-column-data">

                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Other Reservations?
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        1
                                    </div>
                                    <div class="content-column-data">
                                        6
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        1
                                    </div>


                                </div>
                            </div>
                            <div class="section-header collapse handle lightblueBg">
                                <img src="<?php echo base_url();?>assets/images/customer/arrow_opened.png" alt="" /> RESERVATIONS
                            </div>
                        </div>
                    </div>
                    <div class="sortable-overlay-column no-subsections">

                        <!-- hidden vertical label shown  -->
                        <div class="collapse collapse-label handle" style="display: none;">
                            <img src="<?php echo base_url();?>assets/images/customer/arrow_closed.png" class="closed_arrow" />
                            <div><span>ACTIVITY</span></div>
                            <img src="<?php echo base_url();?>assets/images/customer/arrow_closed.png" class="closed_arrow bottom" />
                        </div>
                        <!-- margin -->
                        <div id="activity">
                            <div class="section-header collapse handle purpleBg">
                                <img src="<?php echo base_url();?>assets/images/customer/arrow_opened.png" alt="" /> ACTIVITY
                            </div>
                            <!-- column content -->
                            <div class="section-content purpleLeftBorder purpleBg"></div>
                            <div class="section-content purpleLeftBorder purpleBg" style="display: none">
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Last Checkin
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data purpleBox">
                                        In Store Now!
                                        <br>3:35pm PST
                                    </div>
                                    <div class="content-column-data checkin-data">
                                        10:30am PST
                                    </div>
                                    <div class="content-column-data checkin-data">
                                        6:06pm EST
                                    </div>
                                    <div class="content-column-data checkin-data">
                                        1:37pm EST
                                    </div>
                                    <div class="content-column-data checkin-data">
                                        8:30pm PST
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Past Checkins
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        24
                                    </div>
                                    <div class="content-column-data">
                                        3
                                    </div>
                                    <div class="content-column-data">
                                        51
                                    </div>
                                    <div class="content-column-data">
                                        1
                                    </div>
                                    <div class="content-column-data">
                                        102
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            In Network
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        Yes
                                    </div>
                                    <div class="content-column-data">
                                        No
                                    </div>
                                    <div class="content-column-data">
                                        Yes, via VIP Plugin
                                    </div>
                                    <div class="content-column-data">
                                        Yes
                                    </div>
                                    <div class="content-column-data">
                                        Yes
                                    </div>
                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Transactions
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        24
                                    </div>
                                    <div class="content-column-data">
                                        1
                                    </div>
                                    <div class="content-column-data">
                                        20
                                    </div>
                                    <div class="content-column-data">
                                        1
                                    </div>
                                    <div class="content-column-data">
                                        23
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Reviews
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        6
                                    </div>
                                    <div class="content-column-data">
                                        1
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        1
                                    </div>
                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        <span class="simple-sort" >
                                            <img class="icon" src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-128.png" height="10px" />
                                        </span>
                                        <span class="flex">
                                            Favorited
                                            <img src="../../../assets/images/customer/arrow_down.png" class="header-hover" />
                                        </span>
                                    </div>
                                    <div class="content-column-data">
                                        Yes
                                    </div>
                                    <div class="content-column-data">
                                        No
                                    </div>
                                    <div class="content-column-data">
                                        Yes
                                    </div>
                                    <div class="content-column-data">
                                        Yes
                                    </div>
                                    <div class="content-column-data">
                                        Yes
                                    </div>

                                </div>
                            </div>
                            <!-- column content -->
                            <div class="section-header collapse handle purpleBg">
                                <img src="<?php echo base_url();?>assets/images/customer/arrow_opened.png" alt="" /> ACTIVITY
                            </div>
                        </div>
                        <!-- margin -->
                    </div>
        <!--<div class="sortable-overlay-column">
            <div class="collapse collapse-label handle no-subsections" style="display:none;">
                <img src="icons/arrow_closed.png" class="closed_arrow" />
                <div><span>PROMOTIONS</span></div>
                <img src="icons/arrow_closed.png" class="closed_arrow bottom" />
            </div>
            <div id="promotions">
                <div class="section-header collapse handle violetBg">
                    <img src="icons/arrow_opened.png" alt="" />PROMOTIONS
                </div>
                <div class="subsections-no-drag violetLeftBorder">

                    <div class="whole-subsection violetBg">

                        <div class="subsection">
                            <div class="subsection-header-no-drag handle violetBg">
                            </div>
                            <div class="subsection-content">

                                <div class="content-column">

                                    <div class="content-column-header">Available
                                        <img src="icons/arrow_down.png" class="header-hover" /></div>
                                    <div class="content-column-data">
                                        3
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        6
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        10
                                    </div>

                                </div>
                                <div class="content-column">

                                    <div class="content-column-header">Viewed
                                        <img src="icons/arrow_down.png" class="header-hover" /></div>
                                    <div class="content-column-data">
                                        3
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        4
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>

                                </div>
                                <div class="content-column">

                                    <div class="content-column-header">Used
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        4
                                    </div>
                                    <div class="content-column-data">
                                        2
                                    </div>
                                    <div class="content-column-data">
                                        100
                                    </div>

                                </div>

                            </div>
                            <div class="subsection-header violetBg"></div>
                        </div>
                    </div>

                    <div class="whole-subsection subVioletLeftBorder">

                        <div class="collapse collapse-label" style="display: none;">
                            <img src="icons/arrow_closed.png" class="closed_arrow" />
                            <div><span>Promotional Spending at my Store(s)</span>
                            </div>
                            <img src="icons/arrow_closed.png" class="closed_arrow bottom" />
                        </div>
                        <div class="subsection">
                            <div class="subsection-header collapse subVioletBg">
                                <img src="icons/arrow_opened.png" alt="" /> Promotional Spending at my Store(s)
                            </div>
                            <div class="subsection-content subVioletBg">
                                <div class="content-column">

                                    <div class="content-column-header">
                                        Lifetime
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        $1,000,000
                                    </div>
                                    <div class="content-column-data">
                                        $1,000,000
                                    </div>
                                    <div class="content-column-data">
                                        $1,000,000
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                </div>
                                <div class="content-column">

                                    <div class="content-column-header">This Week
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        $10.50
                                    </div>
                                    <div class="content-column-data">
                                        $10.50
                                    </div>
                                    <div class="content-column-data">
                                        $10.50
                                    </div>
                                    <div class="content-column-data">
                                        $10.50
                                    </div>
                                    <div class="content-column-data">
                                        $10.50
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        Last Week
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        $15.42
                                    </div>
                                    <div class="content-column-data">
                                        $15.42
                                    </div>
                                    <div class="content-column-data">
                                        $15.42
                                    </div>
                                    <div class="content-column-data">
                                        $15.42
                                    </div>
                                    <div class="content-column-data">
                                        $15.42
                                    </div>
                                </div>
                                <div class="content-column">

                                    <div class="content-column-header">This Month
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        $20.00
                                    </div>
                                    <div class="content-column-data">
                                        $20.00
                                    </div>
                                    <div class="content-column-data">
                                        $20.00
                                    </div>
                                    <div class="content-column-data">
                                        $20.00
                                    </div>
                                    <div class="content-column-data">
                                        $20.00
                                    </div>

                                </div>
                                <div class="content-column">

                                    <div class="content-column-header">
                                        Last Month
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        $100.00
                                    </div>
                                    <div class="content-column-data">
                                        $100.00
                                    </div>
                                    <div class="content-column-data">
                                        $100.00
                                    </div>
                                    <div class="content-column-data">
                                        $100.00
                                    </div>
                                    <div class="content-column-data">
                                        $100.00
                                    </div>

                                </div>
                                <div class="content-column">

                                    <div class="content-column-header">
                                        This Year
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        $1,562.00
                                    </div>
                                    <div class="content-column-data">
                                        $1,562.00
                                    </div>
                                    <div class="content-column-data">
                                        $1,562.00
                                    </div>
                                    <div class="content-column-data">
                                        $1,562.00
                                    </div>
                                    <div class="content-column-data">
                                        $1,562.00
                                    </div>

                                </div>
                                <div class="content-column">

                                    <div class="content-column-header">
                                        Last Year
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        $500.00
                                    </div>
                                    <div class="content-column-data">
                                        $500.00
                                    </div>
                                    <div class="content-column-data">
                                        $500.00
                                    </div>
                                    <div class="content-column-data">
                                        $500.00
                                    </div>
                                    <div class="content-column-data">
                                        $500.00
                                    </div>
                                </div>
                            </div>
                            <div class="subsection-header collapse subVioletBg">
                                <img src="icons/arrow_opened.png" alt="" /> Promotional Spending at my Store(s)
                            </div>
                        </div>
                    </div>

                </div>
                <div class="section-header collapse handle violetBg">
                    <img src="icons/arrow_opened.png" alt="" /> PROMOTIONS
                </div>
            </div>
        </div>
        <div class="sortable-overlay-column">

            <div class="collapse collapse-label handle no-subsections" style="display:none;">
                <img src="icons/arrow_closed.png" class="closed_arrow" />
                <div><span>SPENDING</span></div>
                <img src="icons/arrow_closed.png" class="closed_arrow bottom" />
            </div>
            <div id="spending">
                <div class="section-header collapse handle greenBg">
                    <img src="icons/arrow_opened.png" alt="" />SPENDING
                </div>
                <div class="subsections">
                    <div class="whole-subsection">
                        <div class="subsection subGreenLeftBorder">

                            <div class="subsection-header-no-drag handle subGreenBg left-space">
                                at my store(s)
                            </div>
                            <div class="subsection-content subGreenBg">

                                <div class="content-column">
                                    <div class="content-column-header">
                                        Lifetime
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        3
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        6
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        10
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        This Week
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        3
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        4
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        Last Week
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        4
                                    </div>
                                    <div class="content-column-data">
                                        2
                                    </div>
                                    <div class="content-column-data">
                                        100
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        This Month
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        3
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        6
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        10
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        Last Month
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        3
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        4
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        This Year
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        4
                                    </div>
                                    <div class="content-column-data">
                                        2
                                    </div>
                                    <div class="content-column-data">
                                        100
                                    </div>

                                </div>
                                <div class="content-column">
                                    <div class="content-column-header">
                                        Last Year
                                        <img src="icons/arrow_down.png" class="header-hover" />
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        0
                                    </div>
                                    <div class="content-column-data">
                                        4
                                    </div>
                                    <div class="content-column-data">
                                        2
                                    </div>
                                    <div class="content-column-data">
                                        100
                                    </div>

                                </div>
                            </div>
                            <div class="subsection-header subGreenBg left-space">
                                at my store(s)
                            </div>
                        </div>
                    </div>
                    <div class="sortable flex">
                        <div class="whole-subsection">

                            <div class="collapse collapse-label subhandle" style="display: none;">
                                <img src="icons/arrow_closed.png" class="closed_arrow" />
                                <div><span>at my Competitor(s)</span>
                                </div>
                                <img src="icons/arrow_closed.png" class="closed_arrow bottom" />
                            </div>

                            <div class="subsection darkGreenLeftBorder">
                                <div class="subsection-header subhandle collapse darkGreenBg">
                                    <img src="icons/arrow_opened.png" alt="" /> at my Competitor(s)
                                </div>
                                <div class="subsection-content darkGreenBg">
                                    <div class="content-column">

                                        <div class="content-column-header">
                                            All
                                            <img src="icons/arrow_down.png" class="header-hover" />
                                        </div>
                                        <div class="content-column-data">
                                            $1,000,000
                                        </div>
                                        <div class="content-column-data">
                                            $1,000,000
                                        </div>
                                        <div class="content-column-data">
                                            $1,000,000
                                        </div>
                                        <div class="content-column-data">
                                            0
                                        </div>
                                        <div class="content-column-data">
                                            0
                                        </div>

                                    </div>
                                    <div class="content-column">

                                        <div class="content-column-header">
                                            Competitor 1
                                            <img src="icons/arrow_down.png" class="header-hover" />
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>

                                    </div>
                                </div>
                                <div class="subsection-header collapse handle darkGreenBg">
                                    <img src="icons/arrow_opened.png" alt="" /> at my Competitor(s)
                                </div>
                            </div>
                        </div>
                        <div class="whole-subsection">

                            <div class="collapse collapse-label subhandle" style="display: none;">
                                <img src="icons/arrow_closed.png" class="closed_arrow" />
                                <div><span>by Category</span></div>
                                <img src="icons/arrow_closed.png" class="closed_arrow bottom" />
                            </div>

                            <div class="subsection kellyGreenLeftBorder">
                                <div class="collapse subhandle subsection-header kellyGreenBg">
                                    <img src="icons/arrow_opened.png" alt="" /> by Category
                                </div>
                                <div class="subsection-content kellyGreenBg">
                                    <div class="content-column">

                                        <div class="content-column-header">
                                            All
                                            <img src="icons/arrow_down.png" class="header-hover" />
                                        </div>
                                        <div class="content-column-data">
                                            $1,000,000
                                        </div>
                                        <div class="content-column-data">
                                            $1,000,000
                                        </div>
                                        <div class="content-column-data">
                                            $1,000,000
                                        </div>
                                        <div class="content-column-data">
                                            0
                                        </div>
                                        <div class="content-column-data">
                                            0
                                        </div>

                                    </div>
                                    <div class="content-column">

                                        <div class="content-column-header">
                                            Retail
                                            <img src="icons/arrow_down.png" class="header-hover" />
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>
                                        <div class="content-column-data">
                                            $10.50
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse subsection-header handle kellyGreenBg">
                                    <img src="icons/arrow_opened.png" alt="" /> by Category
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="section-header collapse handle greenBg">
                    <img src="icons/arrow_opened.png" alt="" /> PROMOTIONS
                </div>
            </div>
        </div> -->
    </div>

</div>
</div>
<?php echo minify_js('promotion__home', array('jquery-2.1.1.min.js', 'bootstrap.min.js', 'jquery-ui.js', 'jquery.form.js', 'clout.js', 'clout.fileform.js', 'clout.menu.js'));?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/dependencies/materializeJS/materialize.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/customer_list_view.js"></script>
<script src="<?php echo base_url();?>assets/js/config.js"></script>
<script src="<?php echo base_url();?>assets/js/promotion.api.js"></script>
<!-- <script src="<?php echo base_url();?>assets/js/clout.customer_list.js"></script> -->
<script src="<?php echo base_url();?>assets/js/clout.customer.js"></script>
</body>

</html>