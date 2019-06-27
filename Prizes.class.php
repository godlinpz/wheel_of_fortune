<?
    require_once('utils.php');

	class Prizes
	{
		private $names   = [];
		private $chances = [];
		private $images  = [];

		function __construct()
		{
			$prizes = json_decode(file_get_contents('prizes.json'), true);
			$this->names   = array_column($prizes, 'name');
			$this->chances = array_column($prizes, 'chance');
			$this->images  = array_column($prizes, 'image');
		}

		public function get_prizes_list()
		{
			$list = [];
			foreach ($this->names as $k => $name) {
				$list[] = 
				[ "name" => explode(',', str_replace('|', ' <br>', $name))
				, "image" => $this->images[$k] ];
			}

			return $list;
		}

		private function sum($carry, $item)
		{
		    $carry += $item;
		    return $carry;
		}
		
		private function chances_summ()
		{
			$chances_summ = array_reduce($this->chances, [$this, 'sum']);
			$n = rand(0, $chances_summ-1);
			return $n;
		}		
		
		public function roll()
		{
			return $this->win($this->chances_summ(), $this->chances);
		}

		private function win($n, $chances)
		{
			$from = 0;
			for ($i=0; $i < count($chances) ; $i++) { 
			  if($n >= $from &&  $n < $from + $chances[$i])
			    return $i;
			  $from += $chances[$i];
			}
			return -1;
		}

		public function announce($prize_number)
		{
			echo "Вы выиграли ".$this->names[$prize_number]." ($prize_number)";
		}
	}
