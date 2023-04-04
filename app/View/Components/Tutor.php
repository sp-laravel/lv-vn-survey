<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tutor extends Component {
  public $horaries;
  public $horaryTimes;

  public function __construct($horaries, $horarytimes) {
    $this->horaries = $horaries;
    $this->horaryTimes = $horarytimes;
  }

  public function render(): View|Closure|string {
    return view('components.tutor');
  }
}