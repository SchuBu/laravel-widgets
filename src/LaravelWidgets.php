<?php

namespace SchuBu\LaravelWidgets;

use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

abstract class LaravelWidgets
{
    protected $viewPath = null;

    protected function buildViewData()
    {
        $viewData = [];
        foreach ((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $viewData[$property->getName()] = $property->getValue($this);
        }

        foreach ((new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (!in_array($name = $method->getName(), collect((new ReflectionClass($this))->getParentClass()->getMethods())->pluck('name')->toArray())) {
                $viewData[$name] = $this->$name();
            }
        }

        return $viewData;
    }

    private function view()
    {
        $name = Str::kebab(class_basename($this));
        $path = ($this->viewPath) ?: "widgets.{$name}";
        return view($path);
    }

    public function loadView()
    {
        return $this->view()->with($this->buildViewData());
    }
}
