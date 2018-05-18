<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 *
 * @package storefront-child
 */
$game = get_field('game');
switch ($game):
    case 'game1':
        get_template_part('template-game1');
        break;
    case 'game2':
        get_template_part('template-game2');
        break;
    case 'game3':
        get_template_part('template-game3');
        break;               
    case 'game4':
        get_template_part('template-game4');
        break;
    case 'game5':
        get_template_part('template-game5');
        break;
    default:
        get_template_part('404');
        break;
endswitch;


