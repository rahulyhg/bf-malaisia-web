<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Template Dialog
 *
 * @package storefront-child
 */

get_header(); ?>


<div id="cover">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div id="popup" class="col-md-12 col-xs-12">
                    <div class="popup-login">
                        <div class="row">
                            <div class="col-md-12">
                                <img class="close-popup" src="<?php child_theme_assets('assets/images/common/close1.png');?>" alt="">
                            </div>
                        </div>
                        <h1>log in</h1>
                        <div class="label-name">
                            <label for="first-name">first name</label>
                            <label for="last-name">last name</label>
                        </div>
                        <div class="input-name">
                            <input type="text" id="first-name" name="first-name">
                            <input type="password" id="last-name" name="last-name">
                            <div class="forgot-password">
                                <a href="#">Forgot your password?</a>
                            </div>
                        </div>
                        <div class="sigup">
                            <span>You don't have an account yet? <a href="#">sign up</a></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="popup">
                    <div id="popup-congratulation">
                        <h1>congratulation !</h1>
                        <div class="text-winner">
                            <span>You are the winner !</span> <br>
                            <span>Oder to win the prizes !</span>
                        </div>
                        <div class="oder">
                            <button>oder</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="popup">
                    <div id="content-block-popup">
                        <div class="row">
                            <div class="col-md-12">
                                <img class="close-popup" src="<?php child_theme_assets('assets/images/common/close1.png');?>" alt="">
                            </div>
                            <div class="col-md-6">
                                <img src="<?php child_theme_assets('assets/images/common/img-qm1.png');?>" alt="">
                            </div>
                            <div class="col-md-6">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam.
                                    Lsed diam nonummy nibh euismod tincidunt ut laoreet dolore magn
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div id="popup">
                    <div id="game-winner-popup">
                        <div class="row">
                            <div class="col-md-12">
                                <img class="close-popup" src="<?php child_theme_assets('assets/images/common/close1.png');?>" alt="">
                            </div>
                            <div class="col-md-12">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam.
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magn
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div id="popup">
                    <div id="subcription-popup">
                        <div class="row">
                            <div class="col-md-12">
                                <img class="close-popup" src="<?php child_theme_assets('assets/images/common/close1.png');?>" alt="">
                            </div>
                            <div class="col-md-12">
                                <h1>subcription</h1>
                                <p>
                                    Hello! Submit your email to recieve
                                    newsletter and information from us
                                </p>
                                <span>Email</span>
                                <input type="text">
                                <div class="submit">
                                    <button>submit</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>



<?php
get_footer();
