<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: index
 * YEAR: 2022
 */

/*
 * ----------------------------------------------------------
 * Autoloader
 * ----------------------------------------------------------
 *
 *
 * Execute Autoloader for external libraries
 */
require __DIR__.'/../vendor/autoload.php';

/*
 * ----------------------------------------------------------
 * SkyRocket SureFrameWork
 * ----------------------------------------------------------
 *
 *
 * skyrocket the framework and run actions within it
 */
require __DIR__.'/../skyrocket/Application.php';

/*
 * ----------------------------------------------------------
 * SureFrameWork Runner
 * ----------------------------------------------------------
 *
 *
 * framework starter.
 */
Application::starter();
