<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alumn extends Component {
  public $cycleActive;
  public $courseSurveySent;
  public $horaryTimes;

  public function __construct($cycleactive, $coursesurveysent, $horarytimes) {
    $this->cycleActive = $cycleactive;
    $this->courseSurveySent = $coursesurveysent;
    $this->horaryTimes = $horarytimes;
  }

  public function render(): View|Closure|string {
    return view('components.alumn');
  }
}