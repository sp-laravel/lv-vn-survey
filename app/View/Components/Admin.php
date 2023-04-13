<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Admin extends Component {
  public $sedes;

  public function __construct($sedes) {
    $this->sedes = $sedes;
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render(): View|Closure|string {
    return view('components.admin');
  }
}