<?php

# <php-modules>

# https://cdn.jsdelivr.net/gh/minimalist-php/list-find@2024.05.1/index.php
define("minimalist-php/list-find@2024.05.1", function () {
return function ($parameters) {
    $list = $parameters["list"];
    $iteration = $parameters["iteration"];
    $entry = 0;
    $element = null;

    $find_in_list = function ($list) use (&$iteration, &$entry, &$element) {
        $found = $iteration([
            "element" => $list[$entry],
            "entry" => $entry
        ]);

        if ($found) {
            $element = $list[$entry];
            $entry = count($list);

            return true;
        };
        if ($entry < count($list)) {
            $entry = $entry + 1;
    };  };
    for(; $entry < count($list); $find_in_list($list));

    return $element;
};
});

# </php-modules>

$find = constant("minimalist-php/list-find@2024.05.1")();

return function ($parameters) use ($find) {
    $value = $parameters["value"];
    $default = $parameters["default"];
    $list = $parameters["list"];
    $matched = $find([
        "list" => $list,

        "iteration" => function ($parameters) use ($value) {
            $element = $parameters["element"];

            return $element["case"] === $value;
        }
    ]);

    if (! $matched) {

        return $default;
    };
    return $matched["assign"];
};
