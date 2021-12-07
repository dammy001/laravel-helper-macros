<?php

use Illuminate\Database\Eloquent\Builder;

Builder::macro('map', fn (callable $callback) => $this->get()->map($callback));
Builder::macro('filter', fn (callable $callback) => $this->get()->filter($callback));
