<?php
declare(strict_types=1);
 class linear{
	public $c0;
	public $c1;
	public $learningRate=0.001;
	public $loop = 3000;
	public $data=[];
	
	function getLinear(){
		$this->data = [
			[1,1,67],
			[1,2,66],
			[1,3,58],
			[1,4,76],
			[1,5,79],
			[1,6,83]
		];
		
		$this->c0=$this->data[0][1];
		$this->c1=$this->data[0][2];

		function linearFunction (float $c0, float $x0, float $c1, float $x1) : float {
			return $c0 * $x0 + $c1 * $x1;
		}

		function squaredError(float $c0, float $c1, array $data): float {
		  return array_sum(
			array_map(
			  function ($point) use ($c0, $c1) {
				return ($point[2] - linearFunction($c0, $point[0], $c1, $point[1])) ** 2;
			  },
			  $data
			)
		  ) / count($data);
		}

		var_dump(squaredError($this->c0, $this->c1, $this->data));

		function descent(int $m, float $c0, float $c1, array $data): float {
		  return (-2 / count($data)) * array_sum(
			array_map(
			  function ($point) use ($c0, $c1, $m) {
				return ($point[2] - linearFunction($c0, $point[0], $c1, $point[1])) * $point[$m];
			  },
			  $data
			)
		  );
		}
		function adaptC0(float $c0, float $c1, array $data, float $learningRate): float {
			return $c0 - $learningRate * descent(0, $c0, $c1, $data);
		}

		function adaptC1(float $c0, float $c1, array $data, float $learningRate): float {
			return $c1 - $learningRate * descent(1, $c0, $c1, $data);
		}

		$errors = [];
		for ($i = 0; $i < $this->loop; $i++) {
			// Keep the errors so we can graph them later.
			$errors[] = squaredError($this->c0, $this->c1, $this->data);

			// Do not assign immediately, because otherwise 
			// the result of $c0 would influence the descent 
			// of $c1!
			$newC0 = adaptC0($this->c0, $this->c1, $this->data, $this->learningRate);
			$newC1 = adaptC1($this->c0, $this->c1, $this->data, $this->learningRate);

			$this->c0 = $newC0;
			$this->c1 = $newC1;
		} 
		return $this->c0 . " , " . $this->c1;
	}
 }
 
 $a=new linear();
 echo $a->getLinear();