<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Update;

use eMarket\Core\{
    Valid
};

/**
 * Updater
 *
 * @package Core\Update
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Updater {

    public $repo_init = [
        'name' => 'musicman3/eMarket', // GitHub name & repo
        'target_folder' => '/src', // Target folder from which files are copied
        'release_php_version' => '8.0', // Release php version
        'master_php_version' => '8.2', // Master php version
        'redirect' => 'controller/install/' // Redirect after installation completed
    ];

    /**
     * Constructor
     *
     */
    function __construct() {

        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);

        //$this->init($this->repo_init);
    }

    /**
     * Init
     * 
     * @param array $repo_init Init data

     */
    public function init(array $repo_init): void {

        $repo_name = $repo_init['name'];
        $target_folder = $repo_init['target_folder'];

        $php_version = $repo_init['release_php_version'];
        $mode = 'release';

        if (Valid::inGET('install_type') == 'master') {
            $php_version = $repo_init['master_php_version'];
            $mode = 'master';
        }

        $repo = explode('/', $repo_name)[1];

        if (Valid::inGET('step') == '1') {

            if (version_compare(PHP_VERSION, $php_version, '<')) {
                echo json_encode(['Error', 'Attention. Your PHP version < ' . $php_version . '.<br>Please use version >= ' . $php_version]);
                exit;
            }

            $download = $this->gitHubData($repo_name);
            if ($download !== FALSE) {
                $this->downloadArchive($repo_name, $download, $mode);
            } else {
                echo json_encode(['Error', 'No data received from GitHub. Please refresh the page to repeat the installation procedure.']);
                exit;
            }
        }
        if (Valid::inGET('step') == '2') {
            $this->UnzipArchive(inGET('param'), $repo);
        }
        if (Valid::inGET('step') == '3') {
            $this->copyingFiles($repo, $target_folder);
        }
        if (Valid::inGET('step') == '4') {
            $this->downloadComposer();
        }
        if (Valid::inGET('step') == '5') {
            $this->composerInstall();
        }
    }

    /**
     * Download GitHub archive
     * 
     * @param string $repo_name GitHub repo name
     * @param string $download file name
     * @param string $mode Mode
     */
    public function downloadArchive(string $repo_name, string $download, string $mode): void {
        $download_path = 'heads/master';
        if ($mode == 'release') {
            $download_path = 'tags/' . $download;
        }
        $file = 'https://github.com/' . $repo_name . '/archive/refs/' . $download_path . '.tar.gz';
        $file_name = basename($file);
        file_put_contents(getenv('DOCUMENT_ROOT') . '/' . $file_name, file_get_contents($file));

        echo json_encode(['Install', 'Unzipping archive', '2', $file_name]);
        exit;
    }

    /**
     * Unzip GitHub archive
     *
     * @param string $file_name GutHub archive name
     * @param string $repo GitHub repo name
     */
    public function UnzipArchive(string $file_name, string $repo): void {

        $gz = new PharData(getenv('DOCUMENT_ROOT') . '/' . $file_name);
        $gz->decompress();

        try {
            $tarname = basename($file_name, 'tar.gz') . 'tar';
            $tar = new PharData(getenv('DOCUMENT_ROOT') . '/' . $tarname);
            $tar->extractTo(getenv('DOCUMENT_ROOT'));
        } catch (Exception $e) {
            echo json_encode(['Error', 'An error has occurred. Please check the permissions for the root directory. PHP message: ' . $e->getMessage()]);
            exit;
        }

        $this->filesRemoving($file_name);
        $this->filesRemoving($tarname);

        echo json_encode(['Install', 'Copying ' . $repo . ' files', '3', '0']);
        exit;
    }

    /**
     * Copying GutHub files
     *
     * @param string $repo GitHub repo name
     * @param string $target_folder target folder
     */
    public function copyingFiles(string $repo, string $target_folder): void {
        $source_dir = glob($repo . '*')[0];
        $copying_dir = $source_dir . $target_folder . '/' . $repo;
        $dest_dir = getenv('DOCUMENT_ROOT');

        if (!file_exists($dest_dir)) {
            mkdir($dest_dir, 0755, true);
        }

        $dir_iterator = new RecursiveDirectoryIterator($copying_dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $object) {
            $dest_path = $dest_dir . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            ($object->isDir()) ? mkdir($dest_path) : copy($object, $dest_path);
        }

        $this->filesRemoving($source_dir);

        echo json_encode(['Install', 'Downloading composer.phar', '4', '0']);
        exit;
    }

    /**
     * Download composer.phar
     *
     */
    public function downloadComposer(): void {
        $file_composer = 'https://getcomposer.org/download/latest-stable/composer.phar';
        $file_name_composer = basename($file_composer);
        file_put_contents(getenv('DOCUMENT_ROOT') . '/' . $file_name_composer, file_get_contents($file_composer));

        echo json_encode(['Install', 'Installing vendor packages', '5', '0']);
        exit;
    }

    /**
     * Composer install
     *
     */
    public function composerInstall(): void {
        $root = realpath(getenv('DOCUMENT_ROOT'));
        $vendor_dir = $root . '/temp/vendor';
        $composerPhar = new Phar($root . '/composer.phar');
        $composerPhar->extractTo($vendor_dir);

        putenv('COMPOSER_HOME=' . $vendor_dir . '/bin/composer');

        $params = [
            'command' => 'install'
        ];

        $input = new Symfony\Component\Console\Input\ArrayInput($params);
        $output = new Symfony\Component\Console\Output\BufferedOutput(
                Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL
        );

        $application = new Composer\Console\Application();
        $application->setAutoExit(false);
        $application->run($input, $output);

        $this->filesRemoving(getenv('DOCUMENT_ROOT') . '/composer.phar');
        $this->filesRemoving(getenv('DOCUMENT_ROOT') . '/install.php');
        $this->filesRemoving(getenv('DOCUMENT_ROOT') . '/temp');

        echo json_encode(['Done']);
        exit;
    }

    /**
     * Files removing
     *
     * @param string $path Path
     * @return mixed
     */
    public function filesRemoving($path): mixed {
        if (is_file($path)) {
            return unlink($path);
        }
        if (is_dir($path)) {
            foreach (scandir($path) as $p) {
                if (($p != '.') && ($p != '..')) {
                    $this->filesRemoving($path . DIRECTORY_SEPARATOR . $p);
                }
            }
            return rmdir($path);
        }
        return false;
    }

    /**
     * GitHub Data
     * 
     * @param string $repo_name GitHub repo name
     * @return mixed GitHub latest release name
     */
    public function gitHubData(string $repo_name): mixed {
        $connect = curl_init();
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($connect, CURLOPT_HTTPHEADER, ['User-Agent: Installer']);
        curl_setopt($connect, CURLOPT_URL, 'https://api.github.com/repos/' . $repo_name . '/releases/latest');
        $response_string = curl_exec($connect);
        curl_close($connect);
        
        if (!empty($response_string)) {
            $response = json_decode($response_string, 1);
            if (isset($response['tag_name'])) {
                return $response['tag_name'];
            }
        } else {
            return FALSE;
        }
    }
}
