<?php
    class Footer {
        public static function getFooter($datos_in){
            $footer = <<<HTML
                <div class="footer">
                    <div class="footerContainer">
                        <div class="footerText">
                            <h1>INFOTEL</h1>
                            <h6>HOTELES</h6>
                        </div>
                        <div class="footerContactInfo">
                            <div class="footerContactInfoIcon">
                                <img src="img/phone.png" alt="phone">
                            </div>
                            <div class="footerContactInfoText">
                                <h6>+34 987 574 147</h6>
                            </div>
                        </div>
                        <div class="footerSocialMedia">
                            <div class="footerSocialMediaIcon">
                                <img src="images/facebook.png" alt="facebook">
                            </div>
                            <div class="footerSocialMediaIcon">
                                <img src="images/instagram.png" alt="instagram">
                            </div>
                            <div class="footerSocialMediaIcon">
                                <img src="images/twitter.png" alt="twitter">
                            </div>
                        </div>
                    </div>
                    <div class="footerBlueLine"></div>
                </div>
            HTML;

            return $footer;
        }
    }
?>