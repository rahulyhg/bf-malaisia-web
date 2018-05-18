<?php
/**
 * The template for displaying the Game 41.
 *
 * Template name: Game 4
 *
 * @package storefront-child
 */
get_template_part('parts/head');
$game_options = bf_get_game4_options();
$data_game_json = $game_options['game_data'];
global $data_game;
$data_game = empty($data_game_json)? array() : json_decode($data_game_json);

function generate_crossboard(){
    $rows = 10;
    $columns = 10;
    $words = get_matched_words();
    for($i=0;$i<$rows*$columns;$i++){
        $begin = $i + 1;
        if($begin % $columns == 1){// new row
            echo '<div class="clearfix board-row">';
        }
        $cell_data = crossboard_cell_data($words, $i);        
        echo '<a class="btn" data-word="' . $cell_data['word'] . '" data-index="' . $i . '">' . $cell_data['char'] . '</a>';
        if($begin % $columns == 0){// end new row
            echo '</div>';
        }
    }
}

function crossboard_cell_data($words, $data_index){
    $allchars = "abcdefghijklmnopqrstuvwxyz";    
    $data = array(
        'char' => strtolower( substr($allchars, rand(0, strlen($allchars) - 1), 1) ),
        'word' => ''
    );
    $data_words = array();
    foreach($words as $word){                
        if(isset($word[$data_index])){
            array_push($data_words, (strtolower(implode('',$word))));
            $data['char'] = strtolower($word[$data_index]);
        }
    }
    $data['word'] = implode(';',$data_words);
    
    return $data;
}

function get_matched_words(){
    global $data_game;
    $list = [];
    foreach ($data_game as $data){
        $value = str_split($data->word); //hien
        //$chars = explode(',', substr($data->chars, 1, sizeof($data->chars)-2));
        $chars = json_decode($data->chars);
        $word = array();
        for($i = 0, $len = sizeof($chars) ; $i<$len; $i ++){
            $word[$chars[$i]] = ucwords($value[$i]);
        }
        array_push($list, $word);
    }
    return $list;

}

function build_matched_words_json(){

    $matched_words = get_matched_words();
    $data = array();
    foreach($matched_words as $word_data){
        $data[] = get_matched_word_data($word_data, true);
    }

    return wp_json_encode($data);
}

function get_matched_word_data($word_data, $arr_return = false){
    $word = '';
    $chars = array();
    foreach($word_data as $key => $value){
        $word .= $value;
        $chars[] = $key;
    }
    if($arr_return) return array(
        'word' => strtolower($word),
        'chars' => $chars
    );
    return strtolower($word);
}
?>
<div class="game-4">
    <div class="title">
        <img src="<?php echo $game_options['title']; ?>" alt="">
    </div>
    <div class="crossboard">
        <?php generate_crossboard(); ?>
    </div>
    <div class="game-guide">
        <img src="<?php echo $game_options['description']; ?>" alt="">
        <p><?php echo $game_options['disclaimer']; ?></p>
    </div>
    <div class="rotate-game">
        <p>Xoay thiết bị để tiếp tục chơi</p>
    </div>
    <div class="img-result" style="display: none">
        <a href="javascript:void(0);" class="rank-img rank4" data-dismiss="modal">
            <img src="<?php echo $game_options['first_rank']; ?>" alt="" />
        </a>
        <a href="javascript:void(0);" class="rank-img rank3" data-dismiss="modal">
            <img src="<?php echo $game_options['second_rank']; ?>" alt="" />
        </a>
        <a href="javascript:void(0);" class="rank-img rank2" data-dismiss="modal">
            <img src="<?php echo $game_options['third_rank']; ?>" alt="" />
        </a>
        <a href="javascript:void(0);" class="rank-img rank1" data-dismiss="modal">
            <img src="<?php echo $game_options['final_rank']; ?>" alt="" />
        </a>
        <div class="congrat" style="background: none!important;">
            <img src="<?php echo  $game_options['congratulation_banner'];?>" class="congratulation-banner" alt="" />
            <a class="congratulation-button" href="<?php echo bf_gameflow_redirect(); ?>">
                <img src="<?php echo $game_options['congratulation_button']; ?>" alt="">
            </a>
        </div>

    </div>
    <div class="modal bd-example-modal-lg fade" id="modal-crossboard" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

            </div>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript">
(function( $ ) {
    var CrossWordGame = CrossWordGame || {};
    var $crossboard = $('.crossboard');
    var boardRow = $crossboard.find('.board-row')[0];
    var boardItem = $(boardRow).find('.btn');
    var board = $('#modal-crossboard');
    CrossWordGame = {
        words: new Array(), // words
        selected_cells: new Array(), // selected cells
        arrayIntersect: function(long_arr, short_arr){
            if(long_arr.length < short_arr.length) return false;
            // if(long_arr.length > short_arr.length) return false;
                        
            for(let i = 0; i < short_arr.length; i++){
                if(long_arr.indexOf(short_arr[i]) === -1){
                    return false;
                }
            }
            return true;
        },
        addGameWord: function(word){
            this.words.push(word);
        },
        removeGameWord: function(word){
            let new_words = new Array();
            for(let i = 0; i< this.words.length; i++){
                if(word['word'] !== this.words[i]['word']){
                    new_words.push(this.words[i]);
                }
            }
            this.words = new_words;
            // ok show valid word
            this.showValidWord(word);
            // continue
            this.continueGame();
        },
        continueGame: function(){
            // check left words

            // show popup
            let word_count = this.words.length;
            if(word_count >= 4){
                this.showPopup(4);
            }else if(word_count === 3){
                this.showPopup(3);
            }else if(word_count === 2){
                this.showPopup(2);
            }else if(word_count === 1){
                this.showPopup(1);
            }else{
                // show congratulation
                this.showPopup(0);
            }

            $('.crossboard .btn.selected').removeClass('selected');

        },
        getGameWords: function(){
            return this.words;
        },
        addSelectedCell: function(cell_index){
            cell_index = parseInt(cell_index);
            if(this.selected_cells.indexOf(cell_index) < 0){
                this.selected_cells.push(parseInt(cell_index));
                CrossWordGame.checkValidWords();
            }
        },
        removeSelectedCell: function(cell_index){
            let new_cells = [];
            cell_index = parseInt(cell_index);
            for(let i = 0; i< this.selected_cells.length; i++){
                if(this.selected_cells[i] !== cell_index){
                    new_cells.push(this.selected_cells[i]);
                }
            }
            this.selected_cells = new_cells;
            CrossWordGame.checkValidWords();
        },
        checkValidWords: function(){            
            for(var i = 0 ; i < this.words.length; i++){
                let word = this.words[i];
                if(this.arrayIntersect( this.selected_cells, word['chars'])){
                    // remove this word from list of words
                    this.removeGameWord(word);
                    // clean selected cells
                    this.selected_cells = new Array(); // selected cells
                }
            }
        },
        showValidWord: function(word){
            for(var i = 0; i< word['chars'].length; i++){
                $('.crossboard .btn[data-index="' + word['chars'][i] + '"]').addClass('disabled');
            }
        },
        showPopup: function(message){
            let img = '';
            if(message === 0){
                board.toggleClass('isCongrat');
                img =$('.congrat');
            }else {                 
                img = $(`.rank${message}`);
                setTimeout(function () {
                    board.modal('hide');
                }, 3000);
            }
            board.find('.modal-body').html(img);
            board.modal('show');
        },
        bootstrap: function(game_words){
            this.words = game_words;
            this.selected_cells = new Array(), // selected cells
            this.initGame();
        },
        initGame: function(){
            // handle event here
            let $cell_btn = $('.crossboard .btn');
            $cell_btn.click(function(e){
                e.preventDefault();
                let data_index = $(this).attr('data-index');
                if($(this).hasClass('.disabled')){
                    // do nothing
                }else{
                    if($(this).hasClass('selected')){
                        $(this).removeClass('selected');
                        CrossWordGame.removeSelectedCell(data_index);
                    }else{
                        $(this).addClass('selected');
                        CrossWordGame.addSelectedCell(data_index);
                    }
                }
            });
        }
    };

    function initBoard() {
        var boardWidth = $(boardItem[0]).outerWidth() * boardItem.length;
        setTimeout(function () {
            $crossboard.css({
                maxWidth: function () {
                    return boardWidth
                },
                outline: function () {
                    return '7px solid red'
                }
            }, 500);
        });

    }

    $(document).ready(()=>{
        initBoard();
        CrossWordGame.bootstrap(
            <?php
                echo build_matched_words_json();
            ?>);
    });

    $(window).resize(function () {
        initBoard();
    });

})(jQuery);
</script>
<?php
get_template_part('parts/foot');