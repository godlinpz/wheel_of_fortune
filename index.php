<?php
  require_once('Prizes.class.php');

  start_session();

  $game = new Prizes;

  $prizes = $game->get_prizes_list();

  $user = sess('user');
  if(!$user) $user = [];

  // print_r($user['free_run_used']);
  // print_r($user);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Поиграй с енотиком!</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#fff" />
    <meta name="format-detection" content="telephone=no" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500&display=swap&subset=cyrillic" rel="stylesheet">
    <link rel="stylesheet" media="all" href="css/app.css" />
    <script type="text/javascript">
        var baraban_user = {
<?php
            foreach (['free_run_used', 'ticket_taken', 'share_taken', 'ticket_used', 'share_used'] as $c) 
            {
                $v = intval(  isset($user[$c])  ? $user[$c] : ( cookie($c) ? cookie($c) : 0 ));
                echo "\t\t\t$c : $v,\n";
            }
            foreach (['user_name', 'user_phone'] as $c) 
            {
                $v =  isset($user[$c])  ? $user[$c] : ( cookie($c) ? cookie($c) : '' );
                echo "\t\t\t$c : '$v',\n";
            }
            if( isset($user['last_prize']) )
                 echo "\t\t\tlast_prize : {$user['last_prize']},\n";
            else echo "\t\t\tlast_prize : false,\n";
          ?>
            test: 0
        }

    </script>
  </head>
  <body>
    <!-- BEGIN content -->
    <div class="out">
      <div class="alert">
        <div class="alert__img">
          <img class="phone" src="img/phone.png" srcset="img/phone@2x.png 2x, img/phone@3x.png 3x">
          <img class="phone-title" src="img/rotate-title.png" srcset="img/rotate-title@2x.png 2x, img/rotate-title@3x.png 3x">
          <img class="phone phone-2" src="img/phone.png" srcset="img/phone@2x.png 2x, img/phone@3x.png 3x">
        </div>
      </div>
      <div class="alert-backdrop"></div>
      <div class="preloader text-center">
        <header class="preloader-header">
          <div class="container">
            <div class="logo">
              <div class="logo__img">
                <img src="img/logo.png" srcset="img/logo@2x.png 2x, img/logo@3x.png 3x">
              </div>
            </div>
          </div>
        </header>
        <div class="preloader-body">
          <div class="container">
            <h2 class="preloader-title"> Тряси телефон и выигрывай <br /> ценные призы </h2>
            <div class="load-box">
              <div class="load-box__rect">
                <div class="progress">
                  <span class="progress__line">
                    <span style="width: 0%" class="progress__count"></span>
                  </span>
                  <div class="progress__text">0%</div>
                </div>
              </div>
              <span class="load-box__text"> Загрузка... </span>
            </div>
          </div>
        </div>
        <div class="preloader-footer">
          <div class="container">
            <div class="preloader-img">
              <img src="img/preloader-img.png" srcset="img/preloader-img@2x.png 2x, img/preloader-img@3x.png 3x">
            </div>
          </div>
        </div>
      </div>
      <section class="section main" id="baraban">
        <div class="main__img-1">
          <img src="img/main-img-1.png" srcset="img/main-img-1@2x.png 2x, img/main-img-1@3x.png 3x">
        </div>
        <div class="main__img-3">
          <img src="img/main-img-3.png" srcset="img/main-img-3@2x.png 2x, img/main-img-3@3x.png 3x">
        </div>
        <div class="container">
          <div class="main-content">
            <div class="spin">
              <div class="spin-container">
                <span class="spin-container__btn">
                  <img src="img/shift.png" srcset="img/shift@2x.png 2x, img/shift@3x.png 3x">
                </span>
                <div class="carousel">
                  <div class="carousel__bg">
                    <svg width="300" height="300" viewBox="0 0 300 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M149.5 299C232.067 299 299 232.067 299 149.5C299 66.9334 232.067 0 149.5 0C133.273 0 117.651 2.58516 103.021 7.3661L148.934 147.318L193.818 7.12657L194.77 7.43148L149.882 147.639L269.03 61.1871L269.618 61.9965L150.481 148.44H297.32V149.44H150.478L270.178 236.444L269.59 237.253L149.887 150.247L195.33 291.007L194.378 291.315L148.937 150.559L102.942 291.316L101.991 291.006L147.994 150.225L27.4514 235.86C54.5341 274.065 99.1051 299 149.5 299ZM26.8758 235.042L147.373 149.44H1.16825e-05C3.8147e-06 149.46 0 149.48 0 149.5C0 181.313 9.93674 210.805 26.8758 235.042ZM0.0036788 148.44H147.394L28.0758 62.266C10.5989 86.5499 0.226916 116.289 0.0036788 148.44ZM28.6627 61.4563L147.985 147.634L102.072 7.67994C72.3421 17.6179 46.7735 36.6423 28.6627 61.4563Z" fill="#FF8318" />
                    </svg>
                  </div>
                  <ul class="carousel__gift">
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[0]["image"];?>" srcset="img/airpod@2x.png 2x, img/airpod@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[0]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[0]["name"][1];?></div>
                    </li>
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[1]["image"];?>" srcset="img/coffe@2x.png 2x, img/coffe@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[1]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[1]["name"][1];?></div>
                    </li>
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[2]["image"];?>" srcset="img/magnet@2x.png 2x, img/magnet@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[2]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[2]["name"][1];?></div>
                    </li>
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[3]["image"];?>" srcset="img/airpod@2x.png 2x, img/airpod@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[3]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[3]["name"][1];?></div>
                    </li>
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[4]["image"];?>" srcset="img/secret-gift@2x.png 2x, img/secret-gift@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[4]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[4]["name"][1];?></div>
                    </li>
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[5]["image"];?>" srcset="img/cup@2x.png 2x, img/cup@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[5]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[5]["name"][1];?></div>
                    </li>
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[6]["image"];?>" srcset="img/secret-gift@2x.png 2x, img/secret-gift@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[6]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[6]["name"][1];?></div>
                    </li>
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[7]["image"];?>" srcset="img/ticket@2x.png 2x, img/ticket@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[7]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[7]["name"][1];?></div>
                    </li>
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[8]["image"];?>" srcset="img/two-ticket@2x.png 2x, img/two-ticket@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[8]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[8]["name"][1];?></div>
                    </li>
                    <li class="gift-item">
                      <div class="gift-item__img">
                        <img src="<?=$prizes[9]["image"];?>" srcset="img/film@2x.png 2x, img/film@3x.png 3x">
                      </div>
                      <div class="gift-item__text"><?=$prizes[9]["name"][0];?></div>
                      <div class="gift-item__sub"><?=$prizes[9]["name"][1];?></div>
                    </li>
                  </ul>
                  <div class="carousel__center">
                    <span class="carousel__start">ПУСК</span>
                    <span class="carousel__arrow">
                      <img src="img/arrow.png" srcset="img/arrow@2x.png 2x, img/arrow@3x.png 3x">
                    </span>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <button id="modal-btn" class="btn btn--primary">ПОЛУЧИТЬ ВРАЩЕНИЕ</button>
              </div>
            </div>
            <div class="gift">
              <h4 class="gift__title">
                <span>ВАШ ПРИЗ</span>
              </h4>
              <div class="gift-body">
                <span class="gift-body__text">?</span>
                <div class="gift-result">
                    <img src="" alt="">
                    <div class="gift-result-text">
                      <span class="gift-result-title"></span>
                      <span class="gift-result-sub"></span>
                    </div>
                </div>
              </div>
              <a class="btn gift-body__btn btn--link" href="javascript:void(0)">Получить приз</a>
            </div>
          </div>
        </div>
      </section>
      <div id="modal-form" class="modal modal-form">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <h3 class="modal-title"> Оставьте свои контакты <br> и мы с вами свяжемся </h3>
              <span class="close">
                <i class="close__icon"></i>
              </span>
            </div>
            <div class="modal-body">
              <form action="" method='POST' class='reg-form'>
                <div class="form">
                  <div class="form-item">
                    <input value="<?=isset($user['user_name']) ? $user['user_name'] : '';?>" 
                           placeholder="Ваше имя" class="form-input" type="text" name="user_name" required="">
                  </div>
                  <div class="form-item">
                    <input value="<?=isset($user['user_phone']) ? $user['user_phone'] : '';?>" 
                           placeholder="Ваш номер телефона" class="form-input" type="tel" name="user_phone" required="">
                  </div>
                  <div class="form-item text-left d-flex">
                    <input id="agree" class="form-check-input" type="checkbox" value="">
                    <label class="form-check-label" for="agree"> Я ознакомился с политикой <a target="_blank" href="license.pdf">конфиденциальности</a> сайта и принимаю его условия </label>
                  </div>
                  <div class="form-item d-flex">
                    <button class="btn btn--primary mr-auto">Отправить</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div id="modal-action" class="modal modal-action">
        <div class="modal-dialog">
          <div class="modal-content text-center">
            <div class="modal-header">
              <span class="close">
                <i class="close__icon"></i>
              </span>
              <h3 class="modal-title">
                <img src="img/gift-box.png" srcset="img/gift-box@2x.png 2x, img/gift-box@3x.png 3x">
                <span> Выберите действие и получите шанс выиграть приз </span>
              </h3>
            </div>
            <div class="modal-body">
              <button class="btn btn--primary btn--block buy-ticket">КУПИТЬ БИЛЕТ К ЕНОТИКАМ</button>
              <button class="btn btn--primary btn--block share-link">Поделиться ссылкой с друзьями</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END content -->
    <!-- BEGIN scripts -->

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/shake.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <!-- END scripts -->
  </body>
</html>
