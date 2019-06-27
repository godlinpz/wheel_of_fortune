<?
    require_once('utils.php');

    class Player
    {
        private $players_file = 'players/list.json';
        private $players = false;

        public function checkData($player)
        {
            return  ( $player['name'] && $player['phone'] )
                ? $this->exists($player)
                : 'Необходимо указать Имя и Телефон!';
        }

        private function exists($player)
        {   
            if(! ($msg = $this->checkPlayer($player)) )
                $msg = $this->savePlayer($player);

            return $msg;
        }

        private function savePlayer($player)
        {
            $write = file_put_contents($this->players_file, ','.json_encode($player), LOCK_EX | FILE_APPEND);

            return $write ? 'OK' : 'Ошибка записи! Обратитесь к администратору!';
        }

        private function findTries($phone)
        {
            $tries = [];
            foreach($this->registeredPlayers() as $k=>$player)
                if( $player['phone'] === $phone )
                    $tries[] = $player;

            return $tries;
        }

        private function findPlayer($player)
        {
            $tries = $this->findTries($player['phone']);
            $player_old = [];

            if ($tries)
                foreach ($tries as $try) {
                    foreach ($try as $k=>$v) {
                        if( empty($player_old[$k]) && $v)
                            $player_old[$k] = $v;
                    }
                }
                
            return $player_old;
        }

        private function checkPlayer($player)
        {
            $msg = "";

            // проверим, есть ли такой игрок в базе
            if( $player_old = $this->findPlayer($player) ) 
            {
                $tries_left = intval($player_old['tries_left']) - intval($player['tries']);
                if($tries_left <= 0)
                    $msg = "Ваши попытки закончились";  
            }

            return $msg;
        }

        public function registeredPlayers()
        {
            if( $this->players === false )
            {
                $players_txt = file_get_contents($this->players_file, LOCK_EX );
                $this->players =  $players_txt ? json_decode('['.$players_txt.']', true) : [];
            }
            return $this->players;
        }


        public function answer($message)
        {
            echo $message;
        }
    }
