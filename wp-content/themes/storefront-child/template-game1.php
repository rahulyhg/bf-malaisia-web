<?php
/**
 * The template for displaying the Game 1.
 *
 * Template name: Game 1
 *
 * @package storefront-child
 */
get_template_part('parts/head');
$game1_options = bf_get_game1_options();
?>
    <div class="game-wrapper game-1 bf-padding bf-content-cover">
        <div class="game-title">
            <p><?php echo $game1_options['disclaimer']; ?></p>
            <img src="<?php echo $game1_options['title']; ?>" alt="">
            <h4><?php echo $game1_options['game_explaination_top']; ?></h4>
        </div>
        <div class="game-area">
            <div class="game-blocks"
                 style="background: url('<?php child_theme_assets('assets/images/games/game1/game1-car-object.png'); ?>') center center no-repeat">
                <?php
                for ($i = 1; $i <= 24; $i++) :
                    echo "<div class='g-item g-" . $i . "' data-game='g" . $i . "'></div>";
                endfor;
                ?>
            </div>
            <div class="game-pieces">
                <img id="piece-1" class="img-pieces" draggable="true" data-game='' data-direction=""
                     src="<?php child_theme_assets('assets/images/games/game1/g1-pieces-1.png'); ?>" alt="">
                <img id="piece-2" class="img-pieces piece3" draggable="true" data-game='g18' data-direction="left"
                     src="<?php child_theme_assets('assets/images/games/game1/g1-pieces-2.png'); ?>" alt="">
                <img id="piece-3" class="img-pieces" draggable="true" data-game='g10' data-direction="right"
                     src="<?php child_theme_assets('assets/images/games/game1/g1-pieces-3.png'); ?>" alt="">
                <img id="piece-4" class="img-pieces" draggable="true" data-game='' data-direction=""
                     src="<?php child_theme_assets('assets/images/games/game1/g1-pieces-4.png'); ?>" alt="">
                <img id="piece-5" class="img-pieces piece2" draggable="true" data-game='g14' data-direction="left"
                     src="<?php child_theme_assets('assets/images/games/game1/g1-pieces-5.png'); ?>" alt="">
            </div>
        </div>
        <div class="game-guide">
            <p><?php echo $game1_options['game_explaination_bottom']; ?></p>
        </div>
        <div class="games-success-data">            
            <img id="rank_2" class="img-fluid"
                 src="<?php echo $game1_options['first_puzzle_found']; ?>" alt="" />
            <img id="rank_1" class="img-fluid"
                 src="<?php echo $game1_options['second_puzzle_found']; ?>" alt="" />
            <div class="g1Success">
                <img src="<?php echo $game1_options['congratulation_banner']; ?>" alt="" />
                <div class="g1-success-button">                    
                    <a href="<?php echo bf_gameflow_redirect(); ?>">
                        <img src="<?php echo $game1_options['congratulation_button']; ?>" alt="" />
                    </a>                                
                </div>
            </div>
        </div>
    </div>
    <div class="rotate-game">
        <p>Xoay thiết bị để tiếp tục chơi</p>
    </div>
<?php get_template_part('parts/foot');