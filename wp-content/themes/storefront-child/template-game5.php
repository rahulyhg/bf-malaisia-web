<?php
/**
 * The template for displaying the Game 5.
 *
 * Template name: Game 5
 *
 * @package storefront-child
 */
get_template_part('parts/head');

$game5_options = bf_get_game5_options();

$questions = [
        [
            'title'   => 'Việt Nam thuộc châu lục nào?',
            'option'  => ['A' => 'Châu Á' , 'B' => 'Châu Âu', 'C' => 'Châu Mỹ', 'D' => 'Châu Phi'],
            'correct' => 'A',
        ],

        [
            'title'   => 'Nước sôi ở nhiệt độ?',
            'option'  => ['A' => '50', 'B' => '25', 'C' => '75', 'D' => '100'],
            'correct' => 'D',
        ],

        [
            'title'   => 'Mặt Trăng quay xung quanh hành tinh nào?',
            'option'  => ['A' => 'Trái Đất', 'B' => 'Sao Thủy', 'C' => 'Sao Mộc', 'D' => 'Sao Kim'],
            'correct' => 'A',
        ],

        [
            'title'   => 'Mạng xã hội nào phổ biến nhất trên thế giới hiện nay?',
            'option'  => ['A' => 'Apple', 'B' => 'Facebook', 'C' => 'Blog Spot', 'D' => 'My Space'],
            'correct' => 'B'
        ],

        [
            'title'   => 'Ai là người tìm ra Châu Mỹ?',
            'option'  => ['A' => 'Christopher Columbus', 'B' => 'Marie Curie', 'C' => 'Leonardo Da Vinci', 'D' => 'Albert Einstein'],
            'correct' => 'A',
        ],
];
$game5_questions = get_field('game5_questions','option');
function build_game_answers($options){
    $opt = array();
    foreach($options as $option){
        $opt[$option['answer_key']] = $option['answer_value'];
    }
    return $opt;
}
if(!empty($game5_questions)) {
    $new_questions = array();
    foreach($game5_questions as $game5_question){
        array_push($new_questions,array(
            'title' => $game5_question['game5_question_item'],
            'option' => build_game_answers($game5_question['game5_answers']),
            'correct' => $game5_question['game5_correct']
        ));
    }
//    print_r($new_questions);
    $questions = $new_questions;
}
?>

    <div class="modal fade" id="game5-popup-lose" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="content-popup-lose">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="popup-lose">
                                <div class="title-continue"><?php echo $game5_options['wrong_message'] ?></div>
                                <div class="continue-lose">
                                    <span><u><?php echo $game5_options['button_continue'] ?></u> >></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="game5-popup-win" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="content-popup">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="popup-win">
                                <div class="title-continue"><?php echo $game5_options['popup_message'] ?></div>
                                <div class="continue-win">
                                    <span class="click-next"><u><?php echo $game5_options['button_continue'] ?></u> >></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="game-wrapper game-5">
<!--    <h1>Game 5 Layout</h1>-->
    <div class="container">
        <div class="row">
            <div class="game-content">
                <div class="welcome col-md-12">
                    <img src="<?php echo $game5_options['title']; ?>" alt="">
                </div>
                <div class="content col-md-12">
                    <div class="top">
                        <div class="title-one">
                            <span><?php echo $game5_options['subtitle']; ?></span>
                        </div>
                        <div class="title-two">
                            <span>
                                <?php echo $game5_options['explanation'] ?>
                            </span>
                        </div>
                        <div class="money">
                            <img src="<?php echo $game5_options['prize'] ?>" alt="">
                            <img src="<?php echo child_theme_assets('assets/images/games/tg-game-5.png') ?>" alt="">
                        </div>
                    </div>

                    <div class="container middle">
                        <div class="row">
                            <div class="question-detail col-md-6">
                                <!--roud-one-->
                                <?php $question_number = 0; ?>
                                <?php foreach ($questions as $key => $question): ?>
                                <?php $question_number +=1; ?>
                                    <div class="round <?php if($question_number != 1){ echo 'active-ws'; } ?>" data-order="<?php echo $key ?>" data-ok="<?php echo $question['correct']; ?>" >
                                            <div class="number-question">
                                                <div class="number">
                                                    <?php echo $question_number; ?>
                                                </div>
                                                <div class="title-question" style="padding: 0;">
                                                    <span><?php echo $question['title'] ?></span>
                                                </div>
                                            </div>
                                        <div class="detail-answer">
                                            <?php foreach ($question['option'] as $k => $lable): ?>
                                                <button class="choice-value" value="<?php echo $k ?>"><?php echo $k.'. '.$lable; ?></button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <!--end-->
                            </div>
                            <div class="product-detail col-md-6">
                                <img src="<?php echo $game5_options['stamp'] ?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="bottom">
                        <span><?php $game5_options['status_bar'] ?></span>
                    </div>
                    <div class="line-light"></div>
                </div>
            </div>
            <div class="col-md-12 banner-page"><?php echo $game5_options['disclaimer']; ?></div>
        </div>
    </div>
</div>

    <div class="rotate-game">
        <p>Xoay thiết bị để tiếp tục chơi</p>
    </div>


    <div class="modal fade" id="game5-popup-congratulation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered popup-dg " role="document">
            <div class="modal-content content-popup-win">
                <div class="game-wrapper congratulation-game5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 title-cm">
                                <img src="<?php echo $game5_options['congratulation_popup']; ?>" alt="">
                            </div>
                            <div class="col-md-12 banner-text">
                                <span>
                                    <?php echo $game5_options['congratulation_message'] ?>
                                </span>
                            </div>
                            <a href="<?php echo bf_gameflow_redirect(); ?>" class="col-md-12 step-button">
                                <button>
                                    <img src="<?php echo $game5_options['congratulation_banner_button'] ?>" alt="">
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">

    (function($) {


        function gameFive(status_bar, popup_message) {

            // message
            var messageOne = popup_message[0];
            var messageTwo = popup_message[1];
            var messageThree = popup_message[2];
            var messageFour = popup_message[3];

            //status bar
            var statusStart = status_bar[0];
            var statusOne = status_bar[1];
            var statusTwo = status_bar[2];
            var statusThree = status_bar[3];
            var statusFour = status_bar[4];


            $(".bottom span").text(statusStart);
            if($(".game-5 .choice-value").click(function () {
                    var $round = $(this).parents(".round");
                    $round.find('.choice-value[value="'+ $round.data('ok') +'"]');
                    if($round.data('ok') == $(this).attr('value')) {
                        // add color
                        $(this).addClass('right-answer');
                        $(".bottom").css({"background-color": "red", "color": "yellow", "padding": "0 1.5rem"});
                        if($round.data('order') == 0) {
                            $(".popup-win .title-continue").html(messageOne);
                            $(".bottom span").html(statusOne);

                        }
                        if($round.data('order') == 1) {
                            $(".popup-win .title-continue").html(messageTwo);
                            $(".bottom span").html(statusTwo);
                        }
                        if($round.data('order') == 2) {
                            $(".popup-win .title-continue").html(messageThree);
                            $(".bottom span").html(statusThree);
                        }
                        if($round.data('order') == 3) {
                            $(".popup-win .title-continue").html(messageFour);
                            $(".bottom span").html(statusFour);
                        }
                        if($round.data('order') == 4) {
                            $("#game5-popup-congratulation").modal('show');
                            return;
                        }

                        $("#game5-popup-win").modal('show');
                        $("#game5-popup-win").click(function () {
                            $round.hide();
                            $round.next().show();
                        });


                    }
                    else{
                        $(this).css('background','grey');
                        $("#game5-popup-lose").modal('show');
                    }
                }));
        }

        $(document).ready(()=>{
            gameFive(
                <?php echo wp_json_encode($game5_options['status_bar']); ?>,
                <?php echo wp_json_encode($game5_options['popup_message']); ?>
            );
        });
    })(jQuery);


</script>
<?php get_template_part('parts/foot'); ?>