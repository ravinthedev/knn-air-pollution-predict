<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Phpml\Classification\KNearestNeighbors;
use Phpml\Dataset\CsvDataset;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PredictionController extends Controller
{


	public function getData() {

		$token = 'a9ddf51df366ce8f841c1876cfaa57fa53df2844';

		$lat1 = '23.787858,55.093857';
		$lat2 = '-9.728007,126.429842';

		$url = "http://api.waqi.info/map/bounds/?token=$token&latlng=$lat1,$lat2";



		return file_get_contents($url);

	}


	public function predict() {

		$dataset = new CsvDataset(storage_path('air2.csv'), 2, false, ';');

		foreach (range(1, 10) as $k) {
			$correct = 0;
			foreach ($dataset->getSamples() as $index => $sample) {
				$estimator = new KNearestNeighbors($k);
				$estimator->train($other = $this->removeIndex($index, $dataset->getSamples()), $this->removeIndex($index, $dataset->getTargets()));

				$predicted = $estimator->predict([$sample]);

				if ($predicted[0] === $dataset->getTargets()[$index]) {
					$correct++;
				}
			}

			echo sprintf('Accuracy (k=%s): %.02f%% correct: %s', $k, ($correct / count($dataset->getSamples())) * 100, $correct) . PHP_EOL;
		}



		}


	public function predictMore() {

		$minLat = 5.340190;
		$maxLat = 55.093857;
		$minLng = 10.286714;
		$maxLng = 85.073666;

		$step = 0.2;
		$k = 1;

		$dataset = new CsvDataset(storage_path('air2.csv'), 2, false, ';');

		$estimator = new KNearestNeighbors($k);
		$estimator->train($dataset->getSamples(), $dataset->getTargets());

		$lines = [];
		for($lat=$minLat; $lat<$maxLat; $lat+=$step) {
			for($lng=$minLng; $lng<$maxLng; $lng+=$step) {
				$lines[] = sprintf('%s;%s;%s', $lat, $lng, $estimator->predict([[$lat, $lng]])[0]);
			}
		}

//		dd($lines);


		file_put_contents(storage_path('airGrid.csv'), implode(PHP_EOL, $lines));

		}

	function removeIndex($index, $array): array
	{
		unset($array[$index]);
		return $array;
	}

		public function prepare() {

			$data = json_decode(file_get_contents(asset('air.json')), true);
			$lines = [];
			function getLabel(int $index): string {
				if($index <= 50) {
					return 'good';
				} elseif($index <= 100) {
					return 'moderate';
				} elseif ($index <= 150) {
					return 'unhealthy for sensitive';
				}  elseif ($index <= 200) {
					return 'unhealthy';
				} elseif ($index <= 300) {
					return 'very unhealthy';
				}
				return 'hazardous';
			}
			foreach ($data['data'] as $row) {
				$lines[] = sprintf('%s;%s;%s',
				 $row['lat'],
				 $row['lon'],
				 getLabel((int) $row['aqi'])
				);
			}



			file_put_contents(storage_path('air2.csv'), implode(PHP_EOL, $lines));

		}

		public function chart() {

    	$file = asset('pyscript/image.py');

			$process = new Process(['python', 'http://localhost/msc-air-pollution/public/pyscript/image.py']);
			$process->run();

// executes after the command finishes
			if (!$process->isSuccessful()) {
				throw new ProcessFailedException($process);
			}

			echo $process->getOutput();

		}

}
