/* eslint-disable */

var modal = document.querySelector("#modal-form");
var modal_action = document.querySelector("#modal-action");
var modalBtn = document.querySelector("#modal-btn");
var closeBtn = document.querySelector("#modal-form .close");
var closeBtnAction = document.querySelector("#modal-action .close");

// modalBtn.addEventListener("click", openModal);
window.addEventListener("click", outsideClick);
closeBtn.addEventListener("click", closeModal);
closeBtnAction.addEventListener("click", closeModalAction);

function openModal() {
  modal.style.display = "block";
  // modal.style.backgroundColor = "rgba(0,0,0, 0.7)";
}

function closeModal() {
  document.querySelector(".modal").style.display = "none";
}

function openModalAction() {
  modal_action.style.display = "block";
  // modal.style.backgroundColor = "rgba(0,0,0, 0.7)";
}

function closeModalAction() {
  modal_action.style.display = "none";
}

function outsideClick(e) {
  if (e.target == modal.querySelector(".modal-dialog") || e.target == modal) {
    modal.style.display = "none";
  }
  else if (e.target == modal_action.querySelector(".modal-dialog") || e.target == modal_action) {
    modal_action.style.display = "none";
  }
}

function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}

$(function()
{
	var user = baraban_user;
	var waiting_server = false;

	function showError(msg)
	{
		alert(msg);
	}

	function queryServer(data, callback)
	{
		waiting_server = true;
		$.ajax({
			url: './play.php',
			type: 'POST',
			data: data,
		})
		.done(function(result) {
			waiting_server = false;
			try{
				result = $.parseJSON(result);

				if(result.debug)
					console.log(result.debug);

				if(callback)
					callback(result);
				else
					console.log("success", result);
			}
			catch(e)
			{
				showError('Ошибка соединения с сервером! Обратитесь к администратору.');
			}
		})
		.fail(function() {
			waiting_server = false;
			// console.log("error");
			showError('Ошибка соединения с сервером! Обратитесь к администратору.');
			// callback(false, result);
		})
		.always(function() {
			waiting_server = false;
			// console.log("complete");
		});	
	}

	function queryRun(run_type, callback)
	{
		queryServer({cmd: 'run', run_type: run_type}, callback);
	}

	function queryUseFreeRun(callback)
	{
		queryRun('free_run', callback);
	}

	function queryGetTicket(callback)
	{
		queryServer({cmd: 'get_ticket'}, callback);
	}

	function queryUseTicket(callback)
	{
		queryRun('ticket', callback);
	}

	function queryGetShare(callback)
	{
		queryServer({cmd: 'get_share'}, callback);
	}

	function queryUseShare(callback)
	{
		queryRun('share', callback);
	}


	// Загрузка

	var progress_time = 0;

	function runProgress()
	{
		if(progress_time <= 5000 )
		{
			var next = getRandomInt(0, 200);
			
			progress_time+=next;
			
			var progress = Math.floor(progress_time/50);
			if(progress > 100) progress=100;

			$('.progress__count').css('width', progress+'%');
			$('.progress__text').text(progress+'%');

			setTimeout(runProgress, next);
		}
		else
		{
			$('.load-box__text').hide();
			$('#baraban').show();
			$([document.documentElement, document.body]).animate({
		        scrollTop: $("#baraban").offset().top
		    }, 500);
		}
	}

	runProgress();


	function showGift(gift_id)
	{
		// получаем описание выигрыша
		var $item = $('.carousel__gift > *:nth-of-type('+(gift_id+1)+') ');
		var $res = $('.gift-result');

		// отображаем выигрыш
		$res.find('img')[0].src = $item.find('img')[0].src;
		$res.find('.gift-result-title').text($item.find('.gift-item__text').text());
		$res.find('.gift-result-sub').text($item.find('.gift-item__sub').text());

		// прячем вопросительный знак
		$('.gift-body__text').hide();

		$res.show();
	}

	// Барабан

	var $carousel = $('.carousel');
	var current_item = 0;
	var total_items = 10;
	var gift_recieved = user['last_prize'] !== false;
	var running = false;
	var rotations = 0;

	if( gift_recieved ) showGift(user['last_prize']);

	function spinBaraban (run_to_item) 
	{
		if(!running)
		{
			running = true;

			user['last_prize'] = run_to_item; //getRandomInt(0, total_items-1);

			// прячем кнопку
			$('#modal-btn').css('opacity', 0);

			// stopShake();
			// включаем размытие движения
			$carousel.addClass('running');

			++rotations;
			// запускаем анимацию вращения
			$('.carousel__gift').css('transform', 'rotate('+(rotations*1800 + 36*(10 - run_to_item))+'deg)');

			setTimeout(function(){
				// отключаем размытие движения
				$carousel.removeClass('running');
			}, 6200);

			setTimeout(function(){
				// выдаём приз по окончании анимации
				running = false;
				gift_recieved = true;

				showGift( run_to_item );

				$('#modal-btn').css('opacity', 1);
			}, 8200);
		}
	}

	function runGame()
	{
		if(!running && !waiting_server)
		{

			if( !user['free_run_used'] )
			{
				queryUseFreeRun(function(result){
					if(result.error)
						showError(result.error);
					else if(result['prize'] !== undefined )
					{
						user['free_run_used'] = 1;
						spinBaraban(result.prize);
					}
				})
			}
			else if( user['ticket_taken'] && !user['ticket_used'])
			{
				queryUseTicket(function(result){
					if(result.error)
						showError(result.error);
					else if(result['prize'] !== undefined)
					{
						user['ticket_used'] = 1;
						spinBaraban(result.prize);
					}
				})
			}
			else if( user['share_taken'] && !user['share_used'])
			{
				queryUseShare(function(result){
					if(result.error)
						showError(result.error);
					else if(result['prize'] !== undefined)
					{
						user['share_used'] = 1;
						spinBaraban(result.prize);
					}
				})
			}
			else if( !user['ticket_taken'] || !user['share_taken'])
			{
				openModalAction();
			}
			else 
			{
				showError('Ваши попытки закончились! Спасибо, что поиграли с Енотиком! ;)');
			}
		}
		
	}

	$('.carousel__start').click(runGame);

	//получить подарок
	$('.gift').click(function(event) {
		if(gift_recieved && !running)
		{
			openModal();
		}
	});

	// получить шанс
	$('#modal-btn').click(function(event) {
		if( !running )
		{
			openModalAction();
		}
	});

	// к покупке билета
    $('.buy-ticket').click(function(event) {
		queryGetTicket(function(res){
			if(res.error)
				showError(res.error);
			else
			{
				window.open('https://enotopolis.ru/?utm_source=yandex&utm_medium=cpc&utm_campaign=enotopolis&utm_content=cpc&utm_term=present', '_blank');
				closeModalAction();
				user['ticket_taken'] = 1;
			}
			$('#modal-btn').hide();
			if(res.warn) showError(res.warn);
		})
  	});

	// к поделиться ссылкой
    $('.share-link').click(function(event) {
		queryGetShare(function(res){
			if(res.error)
				showError(res.error);
			else
			{
				window.open('https://enotopolis.ru/?utm_source=yandex&utm_medium=cpc&utm_campaign=enotopolis&utm_content=cpc&utm_term=present', '_blank');
				closeModalAction();
				user['share_taken'] = 1;
			}
			$('#modal-btn').hide();
			if(res.warn) showError(res.warn);
		})

    });

    $('.reg-form').submit(function(event) {
    	var f = this;
    	queryServer({cmd: 'register', user_name: f.user_name.value, user_phone: f.user_phone.value}, function(res){
			if(res.error)
				showError(res.error);
			else
			{
				closeModal();
				showError('Спасибо за регистрацию!');
			}
    	});
    });

	// SHAKER
	
    //listen to shake event
    var shakeEvent = new Shake({threshold: 15});
    shakeEvent.start();
    window.addEventListener('shake', runGame, false);

    //stop listening
    function stopShake(){
        shakeEvent.stop();
    }

    //check if shake is supported or not.
    if(!("ondevicemotion" in window)){alert("Not Supported");}

	// /SHAKER

})