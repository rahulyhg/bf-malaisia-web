var Game = Game || {};

(function( $ ) {
    Game = {
        bootstrap : function(){   
            this.gamePopup();
            // this.wheelGameInit(); 
            this.jigsawPuzzle();
        },
        wheelGameInit: function(){
            if (typeof Winwheel !== 'undefined') {
                this.wheelOfFortune();
            }            
        },
        wheelOfFortune: function() {
            var money = 0;
            var $currentQuestion = null;
            var theWheel = new Winwheel({
                'canvasId'          : 'wheel-canvas',
                'numSegments'       : 54,         // Specify number of segments.
                'outerRadius'       : 200,       // Set outer radius so wheel fits inside the background.
                'drawMode'          : 'image',   // drawMode must be set to image.
                'drawText'          : true,      // Need to set this true if want code-drawn text on image wheels.                
                'innerRadius'     : 50,         // Make wheel hollow so segments don't go all way to center.
                'textFontSize'    : 24,         // Set default font size for the segments.
                'textOrientation' : 'vertical', // Make text vertial so goes down from the outside of wheel.
                'textAlignment'   : 'outer',    // Align text to outside of wheel.
                'numSegments'     : 10,         // Specify number of segments.
                'textStrokeStyle' : 0,
                'pointerAngle'    : 180,
                'pointerGuide'    : {
                    'display'     : false
                },
                'segments'     :                // Define segments.
                [
                    { 'value': 0 },
                    { 'value': 150 },
                    { 'value': 1 },
                    { 'value': 0.2 },
                    { 'value': 0 },
                    { 'value': 990 },
                    { 'value': 9 },
                    { 'value': 0.2 },
                    { 'value': 500 },
                    { 'value': 0.5 }                   
                ],
                'animation' : {
                    'type'     : 'spinToStop',
                    'duration' : 9,     // Duration in seconds.
                    'spins'    : 3,     // Default number of complete spins.
                    'callbackFinished' : callbackFinishedSpin
                }
            });

            // Create new image object in memory.
            var loadedImg = new Image();
 
            // Create callback to execute once the image has finished loading.
            loadedImg.onload = function()
            {
                theWheel.wheelImage = loadedImg;    // Make wheelImage equal the loaded image object.
                theWheel.draw();                    // Also call draw function to render the wheel.
            }
 
            // Set the image source, once complete this will trigger the onLoad callback (above).
            loadedImg.src = "http://bluefox.lc/bf-content/themes/storefront-child/assets/images/common/wheel-bg.png";


            function callbackFinishedSpin(indicatedSegment) {
                console.log(indicatedSegment);
                resetWheel();
                // if (indicatedSegment.text == 'Good luck') {
                //     alert('Good luck for next time!');
                // }
                // else {
                //     var _money = Math.round(indicatedSegment.value * 1000000); // convert [K,M] to correct number.
                //     money += _money;
                //     alert("You have won " + formatVNDCurrency(_money) + ".\ Your current money: " + formatVNDCurrency(money));
                // }
                // $('.spin').removeClass('disabled');
                // resetWheel();

                // if ($currentQuestion.data('order') == '2') {
                //     finishGame();
                //     return ;
                // }
                // $currentQuestion.hide();
                // $currentQuestion.next().show();
            };

            $('.spin-trigger').click(function(){
                if (!$(this).hasClass('disabled')) {
                    $(this).addClass('disabled');

                    // wheel speed.
                    theWheel.animation.spins = getRandomInt(3, 10);

                    // Begin the spin animation by calling startAnimation on the wheel object.
                    theWheel.startAnimation();        
                }
            });
            
            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            };

            // function formatVNDCurrency (value) {
            //     return value + " Dong";
            // };
            function resetWheel() {
                theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
                theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
                theWheel.draw();                // Call draw to render changes to the wheel.
                $('.spin-trigger').removeClass('disabled'); // Reset to false to power buttons and spin can be clicked again.
            };
            // function finishGame() {
            //     var msg = 'Message to say something after user answered wrong all questions';
            //     if (money) {
            //         msg = "Congratulation.\nYou win the game.\nTotal money you can get: " + formatVNDCurrency(money);
            //     }
            //     alert(msg);

            //     // Redirect to landing page after finishing the game.
            //     window.location = '/';
            // };

            // $('.game-3 .game-content .spin').click(function(e) {
            //     if (!$(this).hasClass('disabled')) {
            //         $(this).addClass('disabled');

            //         // wheel speed.
            //         theWheel.animation.spins = getRandomInt(3, 10);

            //         // Begin the spin animation by calling startAnimation on the wheel object.
            //         theWheel.startAnimation();
            //     }
            // });

            // $('.game-3 .questions .answer').click(function() {
            //     var $question = $(this).parents('.question');
            //     var answerCorrected = false;
            //     var msg = 'Your answer is not correctly.';

            //     // Flag corrected option.
            //     $question.find('.answer[value="' + $question.data('ok') + '"]').removeClass('btn-danger').addClass('btn-primary');

            //     // Check and show message.
            //     if ($question.data('ok') == $(this).attr('value')) {
            //         msg = 'Congratulation, you answer correctly. And start to spin';
            //         answerCorrected = true;
            //         resetWheel();
            //     }

            //     alert(msg);
            //     if (!answerCorrected) {
            //         if ($question.data('order') == '2') {
            //             finishGame();
            //             return ;
            //         }
            //         $question.hide();
            //         $question.next().show();
            //     }
            //     $currentQuestion = $question;
            // });
        },
        jigsawPuzzle: function () {
            let games = ['g18','g14', 'g10'];
            let windowWidth = window.innerWidth;

            function pop_item(arr, index){
                let new_arr = [];
                for(var i = 0; i<arr.length; i++){
                    if(i != index){
                        new_arr.push(arr[i]);
                    }
                }
                return new_arr;
            }


            $('.game-pieces').find('.img-pieces').each(function (e) {
                this.addEventListener('dragstart', handleDragStart, false);
                this.addEventListener('dragleave', handleDragLeave, false);
                $(this).on('dragstart', function (e) {
                    e.originalEvent.dataTransfer.setData("text", e.target.id);
                });
            });


            $('.game-blocks').find('.g-item').each(function () {
                this.addEventListener('dragover', handleDragOver, false);
                this.addEventListener('dragenter', handleDragEnter, false);
                this.addEventListener('dragend', handleDragEnd, false);

                $(this).on('dragover', function (e) {
                    e.preventDefault();
                });

                $(this).on('drop', function (e) {
                    
                    if (e.stopPropagation) {
                        e.stopPropagation();
                        e.preventDefault();
                    }
                                        
                    let data = e.originalEvent.dataTransfer.getData("text");
                    let $img =  $('#'+data);
                    if($img.data('game') === $(this).data('game')){
                        games = pop_item( games, games.indexOf($img.data('game')) );
                        $(e.target).closest('.game-blocks').append(document.getElementById(data));
                        games.length <= 2 && initPopUp(games.length);
                        initPosition(e.target, $img);
                        $img.attr('draggable', false);
                    }
                })

            });

            function initPosition(el, img) {
                let $gameBlock = $('.game-blocks');

                if(windowWidth >= 1024){
                    $(img).css({
                        top: function(){
                            return img.innerHeight()< 118 ? $(el).offset().top - $gameBlock.offset().top : $(el).offset().top - $gameBlock.offset().top - (img.innerHeight() - 118)*0.5;
                        },
                        left: function(){
                            return img.data('direction') === 'left' ? $(el).offset().left - $gameBlock.offset().left - (img.innerWidth() - 118)*0.75 : $(el).offset().left - $gameBlock.offset().left - (img.innerWidth() - 118)*0.25;
                        },
                        position: 'absolute'
                    })
                }else{
                    $(img).css({
                        top: function(){
                            return $(el).offset().top - $gameBlock.offset().top - (img.innerHeight() - 66)*0.5;
                        },
                        left: function(){
                            return img.data('direction') === 'right' ? $(el).offset().left - $gameBlock.offset().left - (img.innerWidth() - 66)*0.25 : $(el).offset().left - $gameBlock.offset().left - (img.innerWidth() - 66)*0.75;
                        },
                        position: 'absolute'
                    })
                }
            }

            function initPopUp($val) {
                let $popupWinner = $('#popupSuccess');
                let data = '';
                if($val === 0){
                    data = $('.games-success-data').html();
                    $('body').addClass('success-game1')
                }else {
                    data = $('#rank_' +  $val.toString());
                    setTimeout(()=>{
                        $popupWinner.modal('hide');
                    },2000);
                }

                $popupWinner.find('.modal-body').html(data);
                $popupWinner.modal('show');


            }

            let dragSrcEl = null;
            function handleDragStart(e) {
                dragSrcEl = e.target;
                let dt = e.dataTransfer;
                dt.effectAllowed = 'move';
                dt.setData('text', dragSrcEl);

                if (dt.setDragImage instanceof Function){
                    let data = e.target.id;
                    let img = new Image();
                    img.src = document.getElementById(data).src;
                    dt.setDragImage(img, img.width/2, img.height/2);
                }
            }

            function handleDragOver(e) {
                if (dragSrcEl) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                }
            }

            function handleDragLeave(e) {
                if (dragSrcEl) {
                    e.target.classList.remove('over');
                }
            }

            function handleDragEnter(e) {
                if (dragSrcEl) {
                    e.target.classList.add('over');
                }
            }

            function handleDragEnd(e) {
                dragSrcEl = null;
                e.style.opacity = '';
                e.classList.remove('over');
            }
        },
        gamePopup: function(){
            $('.game-popup').click(function(e){
                e.preventDefault();
                $('#modal-game .modal-header .modal-title').html('Open ' + $(this).attr('data-title'));
                $('#modal-game').modal('show');
            });
        }
    }
})(jQuery);

export default Game;
