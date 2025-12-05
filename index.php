<?php

include('util/Router.php');
include('controllers/MuscleImageController.php');

Router::createRoute('get', '/getMuscleGroups', function() {
    MuscleImageController::getMuscleGroups();
});

Router::createRoute('get', '/getMuscleGroups?', function() {
    MuscleImageController::getMuscleGroups();
});

Router::createRoute('get', '/getBaseImage', function() {
    MuscleImageController::getBaseImage(0);
});

Router::createRoute('get', '/getBaseImage?', function() {
    MuscleImageController::getBaseImage(0);
});

Router::createRouteWithQueryParameters('get', '/getBaseImage', array(
    'transparentBackground' => Router::$PARAMETER_TYPE['number'],
    'view' => Router::$PARAMETER_TYPE['string']
),function($transparentBackground, $view) {
    $view = $view ?? 'both';
    MuscleImageController::getBaseImage($transparentBackground, $view);
});

Router::createRouteWithQueryParameters('get', '/getImage', array(
    'muscleGroups' => Router::$PARAMETER_TYPE['string'],
    'color' => Router::$PARAMETER_TYPE['string'],
    'transparentBackground' => Router::$PARAMETER_TYPE['number'],
    'view' => Router::$PARAMETER_TYPE['string']
), function($muscleGroups, $color, $transparentBackground, $view) {
    if ($muscleGroups == null) {
        http_response_code(400);
        exit;
    }
    $view = $view ?? 'both';
    if ($color == null) {
        MuscleImageController::getMuscleImage($muscleGroups, $transparentBackground, $view);
    } else {
        MuscleImageController::getMuscleImageWithCustomColor($muscleGroups, $color, $transparentBackground, $view);
    }
});

Router::createRouteWithQueryParameters('get', '/getMulticolorImage', array(
    'primaryMuscleGroups' => Router::$PARAMETER_TYPE['string'],
    'secondaryMuscleGroups' => Router::$PARAMETER_TYPE['string'],
    'primaryColor' => Router::$PARAMETER_TYPE['string'],
    'secondaryColor' => Router::$PARAMETER_TYPE['string'],
    'transparentBackground' => Router::$PARAMETER_TYPE['number'],
    'view' => Router::$PARAMETER_TYPE['string']
), function($primaryMuscleGroups, $secondaryMuscleGroups, $primaryColor, $secondaryColor, $transparentBackground, $view) {
    if ($primaryMuscleGroups == null || $secondaryMuscleGroups == null || $primaryColor == null || $secondaryColor == null) {
        http_response_code(400);
        exit;
    }
    $view = $view ?? 'both';
    MuscleImageController::getMuscleImageWithMultiColor($primaryMuscleGroups, $secondaryMuscleGroups, $primaryColor, $secondaryColor, $transparentBackground, $view);
});

Router::createRouteWithQueryParameters('get', '/getIndividualColorImage', array(
    'muscleGroups' => Router::$PARAMETER_TYPE['string'],
    'colors' => Router::$PARAMETER_TYPE['string'],
    'transparentBackground' => Router::$PARAMETER_TYPE['number'],
    'view' => Router::$PARAMETER_TYPE['string']
), function ($muscleGroups, $colors, $transparentBackground, $view) {
    $view = $view ?? 'both';
    if ( $muscleGroups == null || $colors == null) {
        MuscleImageController::getIndividualColorImage("", "", $transparentBackground, $view);
    } else {
        MuscleImageController::getIndividualColorImage($muscleGroups, $colors, $transparentBackground, $view);
    }
});

Router::createRouteWithQueryParameters('get', '/getMuscleLayer', array(
    'muscleGroup' => Router::$PARAMETER_TYPE['string'],
    'color' => Router::$PARAMETER_TYPE['string'],
    'view' => Router::$PARAMETER_TYPE['string']
), function ($muscleGroup, $color, $view) {
    if ($muscleGroup == null) {
        http_response_code(400);
        exit;
    }
    $view = $view ?? 'both';
    MuscleImageController::getMuscleLayer($muscleGroup, $color, $view);
});

Router::createRoute('get', '/getMuscleLayersInfo', function() {
    MuscleImageController::getMuscleLayersInfo('both', null);
});

Router::createRoute('get', '/getMuscleLayersInfo?', function() {
    MuscleImageController::getMuscleLayersInfo('both', null);
});

Router::createRouteWithQueryParameters('get', '/getMuscleLayersInfo', array(
    'view' => Router::$PARAMETER_TYPE['string'],
    'color' => Router::$PARAMETER_TYPE['string']
), function ($view, $color) {
    $view = $view ?? 'both';
    MuscleImageController::getMuscleLayersInfo($view, $color);
});

Router::createRoute('get', '/', function() {
    echo "Welcome to the muscle group image generator api.";
});

Router::createRoute('get', '/test', function() {
    MuscleImageController::testCreateImage();
});

// Start the Router
Router::run('/');