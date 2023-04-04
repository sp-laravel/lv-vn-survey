<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alumn extends Component {
  public $cycleActive;
  public $courseSurveySent;

  public function __construct($cycleactive, $coursesurveysent) {
    $this->cycleActive = $cycleactive;
    $this->courseSurveySent = $coursesurveysent;
  }

  public function render(): View|Closure|string {
    return view('components.alumn');
  }
}