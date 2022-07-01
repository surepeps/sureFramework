<?php
/**
 * sureframe
 * Created by SureCoder
 * FILE NAME: View
 * YEAR: 2022
 */


namespace sFrameApp\View;

use sFrameApp\FileHandling\Filehandling;
use Jenssegers\Blade\Blade;

class View
{
    /**
     *
     * constructor
     */
    private function __constructor() {}

    /**
     * Render pager method
     *
     * @param string $viewPath
     * @param array $data
     * @return string
     */
    public static function render(string $viewPath, array $data = []): string
    {
        return static::templateBlade($viewPath,$data);
    }


    /**
     * View Template Engine (Blade) Initialization
     *
     * @param string $viewPath
     * @param array $data
     * @return string
     */
    public static function templateBlade(string $viewPath, array $data = [])
    {
        $blade = new Blade(Filehandling::filePath('application/views'), Filehandling::filePath('storage/cache'));
        return $blade->make($viewPath, $data)->render();
    }
    
    
    /**
     * Render pager method without no Template (Pure PHP)
     *
     * @param string $viewPath
     * @param array $data
     * @return string
     */
    public static function templatePhp(string $viewPath, array $data = []): string
    {
        $viewPath = 'application\Views' . Filehandling::ds() . str_replace(['/', '\\', '.'], Filehandling::ds(), $viewPath ). '.php';
        if (! Filehandling::fileChecker($viewPath)){
            throw new \Exception("The view file {$viewPath} is not found");
        }

        ob_start();
        extract($data);
        Filehandling::include_file($viewPath);
        $viewContent = ob_get_contents();
        ob_end_clean();
        return $viewContent;
    }


}   