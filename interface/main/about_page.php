<?php
/**
 * OpenEMR About Page
 *
 * This Displays an About page for OpenEMR Displaying Version Number, Support Phone Number
 * If it have been entered in Globals along with the Manual and On Line Support Links
 *
 * Copyright (C) 2016 Terry Hill <terry@lillysystems.com>
 * Copyright (C) 2017 Brady Miller <brady.g.miller@gmail.com>
 *
 * LICENSE: This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 3
 * of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://opensource.org/licenses/gpl-license.php>;.
 *
 * @package OpenEMR
 * @author Terry Hill <terry@lilysystems.com>
 * @author Brady Miller <brady.g.miller@gmail.com>
 * @link http://www.open-emr.org
 *
 * Please help the overall project by sending changes you make to the author and to the OpenEMR community.
 *
 */


require_once("../globals.php");

use OpenEMR\Core\Header;
use OpenEMR\Services\VersionService;

?>
<html>
<head>

    <?php Header::setupHeader(["jquery-ui","jquery-ui-darkness"]); ?>
    <title><?php echo xl("About");?> MedicEMR</title>
    <style>
        .donations-needed {
            margin-top: 25px;
            margin-bottom: 25px;
            color: #c9302c;
        }
        .donations-needed a, .donations-needed a:visited,
        .donations-needed a:active {
            color: #c9302c;
        }
        .donations-needed a.btn {
            color: #c9302c;
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            animation: all 2s;
        }
        .donations-needed a.btn:hover {
            background-color: #c9302c;
            color: #fff;
        }
        .donations-needed .btn {
            border-radius: 8px;
            border: 2px solid #c9302c;
            color: #c9302c;
            background-color: transparent;
        }
    </style>

    <script type="text/javascript">
        var registrationTranslations = <?php echo json_encode(array(
            'title' => xla('OpenEMR Product Registration'),
            'pleaseProvideValidEmail' => xla('Please provide a valid email address'),
            'success' => xla('Success'),
            'registeredSuccess' => xla('Your installation of OpenEMR has been registered'),
            'submit' => xla('Submit'),
            'noThanks' => xla('No Thanks'),
            'registeredEmail' => xla('Registered email'),
            'registeredId' => xla('Registered id'),
            'genericError' => xla('Error. Try again later'),
            'closeTooltip' => ''
        ));
        ?>;

        var registrationConstants = <?php echo json_encode(array(
            'webroot' => $GLOBALS['webroot']
        ))
        ?>;
    </script>

    <script type="text/javascript" src="<?php echo $webroot ?>/interface/product_registration/product_registration_service.js?v=<?php echo $v_js_includes; ?>"></script>
    <script type="text/javascript" src="<?php echo $webroot ?>/interface/product_registration/product_registration_controller.js?v=<?php echo $v_js_includes; ?>"></script>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            var productRegistrationController = new ProductRegistrationController();
            productRegistrationController.getProductRegistrationStatus(function(err, data) {
                if (err) { return; }

                if (data.statusAsString === 'UNREGISTERED') {
                    productRegistrationController.showProductRegistrationModal();
                } else if (data.statusAsString === 'REGISTERED') {
                    productRegistrationController.displayRegistrationInformationIfDivExists(data);
                }
            });
            
						jQuery('#donation_medicaddr_click').on('click', function(){
						    var textArea = document.createElement("textarea");
						    textArea.value = $('#donation_medicaddr').text();
						    document.body.appendChild(textArea);
						    textArea.select();
						    document.execCommand("Copy");
						    textArea.remove();
						    $('#donation_medicaddr_copied').show().addClass('text-success');
                return false;
            });
        });
    </script>

    <script type="text/javascript">

    </script>
</head>
<?php
$versionService = new VersionService();
$version = $versionService->fetch();
?>
<body class="body_top">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-4 col-md-offset-4 text-center">
                <div class="page-header">
                    <h1><?php echo xlt("About");?>&nbsp;MedicEMR</h1>
                    <p>MedicEMR combines the opensource OpenEMR software with Medic Coin blockchain technology to create the first free opensource EMR software, MedicEMR, accepting crypto as a form of payment.</p>
                </div>
                <div class="page-header">
                    <h2><?php echo xlt("About");?>&nbsp;Medic Coin</h2>
                    <p>MedicCoin (MEDIC) is a community-driven crypto focused on improving the health of people throughout the world via innovative reward programs, recruiting others to help advance scientific research and donating to charities.</p>
                	<a href="http://mediccoin.com" target="_blank" class="btn btn-default btn-block"><img border="0" height="16" src="<?php echo $GLOBALS['images_static_relative']; ?>/menu-logo.png"> Medic Coin homepage</a>
                </div>
                <h4><?php  echo xlt('Version Number'); ?>: <?php echo "v".text($openemr_version) ?></h4>
                <span class="text product-registration"><span class="email"></span> <span class="id"></span></span><br>
                <?php if (!empty($GLOBALS['support_phone_number'])) { ?>
                    <span class="text"><?php  echo xlt('Support Phone Number'); ?>: <?php echo $GLOBALS['support_phone_number'] ?></span><br>
                <?php } ?>
                <a href="<?php echo "http://open-emr.org/wiki/index.php/OpenEMR_".attr($version->getMajor()).".".attr($version->getMinor()).".".attr($version->getPatch())."_Users_Guide"; ?>" target="_blank" class="btn btn-block btn-default"><i class="fa fa-fw fa-book"></i>&nbsp;<?php echo xlt('User Manual'); ?></a>
                <?php if (!empty($GLOBALS['online_support_link'])) { ?>
                    <a href='<?php echo $GLOBALS["online_support_link"]; ?>' target="_blank" class="btn btn-default btn-block"><i class="fa fa-fw fa-question-circle"></i>&nbsp;<?php echo xlt('Online Support'); ?></a>
                <?php } ?>
                <a href="../../acknowledge_license_cert.html" target="_blank" class="btn btn-default btn-block"><i class="fa fa-fw fa-info-circle"></i><?php echo xlt('Acknowledgments, Licensing and Certification'); ?></a>
                <div class="donations-needed">
                    <span class="text"><?php echo xlt("Please consider sending in a donation to"); ?> OpenEMR:</span><br>
                    <a href="http://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=V6EVVTYYK264C" target="_blank" class="btn btn-lg btn-block"><i class="fa fa-2x fa-heart"></i><br/><?php echo xlt("DONATE NOW!"); ?></a>
                </div>
                <div class="donations-needed">
                    <span class="text"><?php echo xlt("Please consider sending in a donation to"); ?> MedicEMR:</span><br>
                    <a id="donation_medicaddr_click" href="https://explorer.mediccoin.com/address/MWFwbBLJeicbDqQWLbGBCgPmiLLcPzrgro" target="_blank" class="btn btn-lg btn-block">
                    	<img style="padding: 20px" src="https://explorer.mediccoin.com/qr/MWFwbBLJeicbDqQWLbGBCgPmiLLcPzrgro" />
                    	<br/><br/><span id="donation_medicaddr">MWFwbBLJeicbDqQWLbGBCgPmiLLcPzrgro</span>
                    	<br /><br />(Click to copy address) <span id="donation_medicaddr_copied" style="display:none">copied!</span>
                    </a>
                </div>
            </div>
        </div>


    <div class="product-registration-modal" style="display: none">
        <p class="context"><?php echo xlt("Register your installation with OEMR to receive important notifications, such as security fixes and new release announcements."); ?></p>
        <input placeholder="<?php echo xlt('email'); ?>" type="email" class="email" style="width: 100%; color: black" />
        <p class="message" style="font-style: italic"></p>
    </div>
</body>
</html>
