<?php
global $charsGroup;
global $listWord;
global $arrIndex;
global $list;

$arrIndex = [];
$charsGroup = [];

$list = [];
$listWord = [];

foreach ($data_game as $data){
    $dataWord = empty($data->word) ? $data['word'] : $data->word;
    $dataChars = empty($data->chars) ? $data['chars'] : $data->chars;    
    // $dataChars = json_decode($dataChars);
    
    $value = str_split($dataWord); //hien
    $chars = json_decode($dataChars);//explode(',', substr($dataChars, 1, sizeof($dataChars)-2));
    array_push($listWord, $dataWord);
    array_push($charsGroup, $chars);
    $word = [];
    for($i = 0, $len = sizeof($chars) ; $i<$len; $i ++){
        $word[$chars[$i]] = ucwords($value[$i]);
        $list[$chars[$i]] = ucwords($value[$i]);
        array_push($arrIndex, (int)$chars[$i]);
    }
}
sort($arrIndex);
ksort($list);
?>
<div class="wrap">
    <h1>Game 4 settings</h1>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-1">
            <div class="postbox-container">
                <div class="postbox acf-postbox">
                    <button type="button" class="handlediv button-link" aria-expanded="true">
                        <span class="screen-reader-text">Toggle panel</span>
                        <span class="toggle-indicator" aria-hidden="true"></span>
                    </button>
                    <h2 class="hndle ui-sortable-handle">
                        <span>Crossboard data</span>
                    </h2>
                    <div class="crossboard-words">
                        <div class="crossboard">
                            <?php
                            $rows = 10;
                            $columns = 10;
                            for ($i = 0; $i < $rows * $columns; $i++) {
                                $disabled = '';
                                $w= '';
                                $begin = $i + 1;
                                if ($begin % $columns == 1) {// new row
                                    echo '<div class="clearfix board-row">';
                                }

                                if(in_array($i,$arrIndex)){
                                    $disabled = 'disabled';
                                    $w = $list[$i];
                                }
                                $w = $w != '' ? $w : (string)($i+1);
                                echo "<a href=\"javascript:void(0);\" class='btn $disabled' data-word='$i' data-index='$i'>$w</a>";
                                if ($begin % $columns == 0) {// end new row
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                        
                        <form id="form-data" method="POST" class="crossboard-form-data">
                            <input type="hidden" value="1" name="is_submit_form"/>
                            <input name="chars" value="" type="hidden"/>          
                            <table class="form-table">
                                <tbody>
                                    <tr>                                        
                                        <td>
                                            <label><strong>New word</strong></label>
                                            <input type="text" name="word" value="" />                                                                                        
                                            <input id="game-data" type="button" value="Add" class="button button-primary"/>
                                            <br/>
                                            <span class="description">Enter new word and choose its position in the board</span>
                                        </td>
                                    </tr>                                    
                                </tbody>
                            </table>
                        </form>
                        <div class="crossboard-form-data">
                            <ul>
                                <?php
                                $count = 0;
                                foreach ($data_game as $data): $count++; ?>
                                    <li>
                                        <form id="delete-data<?php echo $count ?>" method="POST">
                                            <span class="saved_word"><?php echo empty($data->word) ? $data['word'] : $data->word; ?></span>
                                            <input name="is_delete" type="hidden"/>
                                            <input name="word_id" value="<?php echo $data->id; ?>" type="hidden"/>
                                            <input value="delete" class="delete-btn" type="submit"/>
                                        </form>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>


                </div><!-- end .postbox -->
            </div><!-- end .postbox-container -->
        </div>
    </div>
</div>

<script type="text/javascript">
    (function ($) {
        var CrossWordGame = CrossWordGame || {};
        CrossWordGame = {
            selected_cells: new Array(), // selected cells
            initGame: function () {
                // handle event here
                var $cell_btn = $('.crossboard .btn');
                $cell_btn.click(function (e) {
                    e.preventDefault();
                    var data_index = $(this).attr('data-index');
                    if ($(this).hasClass('.disabled')) {
                        // do nothing
                    } else {
                        if ($(this).hasClass('selected')) {
                            CrossWordGame.removeSelectedCell(data_index);
                            $(this).removeClass('selected');
                        } else {
                            CrossWordGame.addSelectedCell(data_index);
                            $(this).addClass('selected');
                        }
                    }
                });
                this.submitWords();
            },
            bootstrap: function (group, listWord) {
                this.group = group;
                this.listWord = listWord;
                this.initGame();
            },

            removeSelectedCell: function (cell_index) {
                var new_cells = [];
                cell_index = parseInt(cell_index);
                for (var i = 0; i < this.selected_cells.length; i++) {
                    if (this.selected_cells[i] !== cell_index) {
                        new_cells.push(this.selected_cells[i+1]);
                    }
                }
                this.selected_cells = new_cells;
            },
            addSelectedCell: function (cell_index) {
                cell_index = parseInt(cell_index);
                if (this.selected_cells.indexOf(cell_index) < 0) {
                    this.selected_cells.push(parseInt(cell_index));
                }
            },

            checkNumberSequential: function(arr) {
                arr.sort(function (a, b) {
                    return a - b;
                });
                for (var i = 0, len = arr.length; i < len - 1; ++i) {
                    if (arr[i] + 1 !== arr[i + 1] && arr[i] + 10 !== arr[i + 1]) {
                        return false;
                    }
                }
                return true;
            },

            matchResult: function(arr1,arr2){
                var ret = [];
                arr1.sort();
                arr2.sort();
                for(var i = 0; i < arr1.length; i += 1) {
                    if(arr2.indexOf(arr1[i]) > -1){
                        ret.push(arr1[i]);
                    }
                }
                return ret;
            },

            submitWords: function() {
                var $gameData = $('#form-data');
                var word = $('input[name="word"]');
                var seft = this;

                $('#game-data').on('click', function (events) {
                    events.preventDefault();
                    events.stopPropagation();
                    seft.selected_cells = seft.selected_cells.sort(function (a,b) {
                       return a-b;
                    });

                    var chars = JSON.stringify(seft.selected_cells);
                    var value = word.val();

                    if(/\s/g.test(value)){
                        alert("This keyword without any whitespaces !!!");
                        return;
                    }

                    if(seft.listWord.indexOf(value) !== -1 ){
                        alert("This keyword has been selected !!!");
                        return;
                    }

                    $('input[name="chars"]').val(chars);

                    if (seft.selected_cells.length === 0) {
                        alert('Please select the placements of the selected keywords !!!');
                        return;
                    } else if (value === "") {
                        alert('Please enter keywords!!!');
                        return;
                    }

                    if (value.length !== seft.selected_cells.length && seft.selected_cells.length <= 10) {
                        alert('Keywords and placements are not the same length or you choose to exceed the specified length !!!');
                        return;
                    }

                    if (CrossWordGame.checkNumberSequential(seft.selected_cells) === -1) {
                        alert(' Keyword position must be consecutive !!!');
                        return;
                    }

                    for(var i=0, len = seft.group.length; i<len; i++ ){
                        var g = seft.group[i].map(function(item) {
                            return parseInt(item, 10);
                        });
                        var mLen = CrossWordGame.matchResult(seft.selected_cells,g);
                        if(mLen.length  === g.length){
                            alert("This keyword's position has been selected !!!");
                            return;
                        }
                    }

                    $gameData.submit();
                });
            }
        };

        $(document).ready(() => {
            CrossWordGame.bootstrap(<?php echo wp_json_encode($charsGroup); ?>, <?php echo wp_json_encode($listWord); ?>);
        });

    })(jQuery);
</script>