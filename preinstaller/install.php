<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* ++++++++++++++++++++++++++++++++++++++++ */
$repo_init = [
    'name' => 'musicman3/eMarket', // GitHub name & repo
    'target_folder' => '/src', // Target folder from which files are copied
    'release_php_version' => '8.0', // Release php version
    'master_php_version' => '8.2', // Master php version
    'redirect' => 'controller/install/' // Redirect after installation completed
];
/* ++++++++++++++++++++++++++++++++++++++++ */

// php.ini set
ini_set('memory_limit', -1);
ini_set('max_execution_time', 0);
// Init
init($repo_init);

/**
 * Init
 * 
 * @param array $repo_init Init data

 */
function init(array $repo_init): void {

    $repo_name = $repo_init['name'];
    $target_folder = $repo_init['target_folder'];

    $php_version = $repo_init['release_php_version'];
    $mode = 'release';

    if (inGET('install_type') == 'master') {
        $php_version = $repo_init['master_php_version'];
        $mode = 'master';
    }

    // Repo name
    $repo = explode('/', $repo_name)[1];

    if (inGET('step') == '1') {

        if (version_compare(PHP_VERSION, $php_version, '<')) {
            echo json_encode(['Error', 'Attention. Your PHP version < ' . $php_version . '.<br>Please use version >= ' . $php_version]);
            exit;
        }

        $download = gitHubData($repo_name);
        if ($download !== FALSE) {
            downloadArchive($repo_name, $download, $mode);
        } else {
            echo json_encode(['Error', 'No data received from GitHub. Please refresh the page to repeat the installation procedure.']);
            exit;
        }
    }
    if (inGET('step') == '2') {
        UnzipArchive(inGET('param'), $repo);
    }
    if (inGET('step') == '3') {
        copyingFiles($repo, $target_folder);
    }
    if (inGET('step') == '4') {
        downloadComposer();
    }
    if (inGET('step') == '5') {
        composerInstall();
    }
}

/**
 * GET validation
 *
 * @param string $input Input data
 * @return mixed
 */
function inGET(string $input): mixed {
    if (filter_input(INPUT_GET, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE) {
        if (isset($_GET[$input])) {
            return $_GET[$input];
        }
    }
    return FALSE;
}

/**
 * Download GitHub archive
 * 
 * @param string $repo_name GitHub repo name
 * @param string $download file name
 * @param string $mode Mode
 */
function downloadArchive(string $repo_name, string $download, string $mode): void {
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
function UnzipArchive(string $file_name, string $repo): void {

    // ungz
    $gz = new PharData(getenv('DOCUMENT_ROOT') . '/' . $file_name);
    $gz->decompress();
    // untar
    try {
        $tarname = basename($file_name, 'tar.gz') . 'tar';
        $tar = new PharData(getenv('DOCUMENT_ROOT') . '/' . $tarname);
        $tar->extractTo(getenv('DOCUMENT_ROOT'));
    } catch (Exception $e) {
        echo json_encode(['Error', 'An error has occurred. Please check the permissions for the root directory. PHP message: ' . $e->getMessage()]);
        exit;
    }

    filesRemoving($file_name);
    filesRemoving($tarname);

    echo json_encode(['Install', 'Copying ' . $repo . ' files', '3', '0']);
    exit;
}

/**
 * Copying GutHub files
 *
 * @param string $repo GitHub repo name
 * @param string $target_folder target folder
 */
function copyingFiles(string $repo, string $target_folder): void {
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

    filesRemoving($source_dir);

    echo json_encode(['Install', 'Downloading composer.phar', '4', '0']);
    exit;
}

/**
 * Download composer.phar
 *
 */
function downloadComposer(): void {
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
function composerInstall(): void {
    $root = realpath(getenv('DOCUMENT_ROOT'));
    $vendor_dir = $root . '/temp/vendor';
    $composerPhar = new Phar($root . '/composer.phar');
    $composerPhar->extractTo($vendor_dir);
    require_once($vendor_dir . '/vendor/autoload.php');
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

    filesRemoving(getenv('DOCUMENT_ROOT') . '/composer.phar');
    filesRemoving(getenv('DOCUMENT_ROOT') . '/install.php');
    filesRemoving(getenv('DOCUMENT_ROOT') . '/temp');

    echo json_encode(['Done']);
    exit;
}

/**
 * Files removing
 *
 * @param string $path Path
 * @return mixed
 */
function filesRemoving($path): mixed {
    if (is_file($path)) {
        return unlink($path);
    }
    if (is_dir($path)) {
        foreach (scandir($path) as $p) {
            if (($p != '.') && ($p != '..')) {
                filesRemoving($path . DIRECTORY_SEPARATOR . $p);
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
function gitHubData(string $repo_name): mixed {
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
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow" />
        <meta name="generator" content="Netbeans" />
        <meta name="classification" content="software" />
        <meta name="author" content="eMarket" />
        <meta name="owner" content="eMarket" />
        <meta name="copyright" content="Copyright © 2018 by eMarket Team. All right reserved." />
        <title>Preparing to install</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script>
            /**
             * Ajax get
             *
             * @param url {String} (URL)
             */
            function getUpdate(url) {
                let xhr = new XMLHttpRequest();
                xhr.open('GET', url);
                xhr.send();
                xhr.onreadystatechange = function () {
                    if (this.readyState !== 4) {
                        return;
                    }
                    if (this.status === 200) {
                        success(xhr);
                    }
                };
            }

            /**
             * Success
             *
             * @param xhr {Object} (xhr object)
             */
            function success(xhr) {
                var data = xhr.response;
                var parse = JSON.parse(data);
                var progress_bar = document.querySelectorAll('.progress-bar');

                if (parse[0] === 'Install' && Number(parse[2]) < 6) {
                    document.querySelector('#step_data').innerHTML = parse[1];
                    document.querySelector('#step').innerHTML = 'Step ' + parse[2] + ' of 5';

                    progress_bar.forEach(e => e.style.width = (parse[2] - 1) * 20 + '%');
                    progress_bar.forEach(e => e.classList.add('bg-success', 'progress-bar-striped', 'progress-bar-animated'));

                    setTimeout(() => {
                        getUpdate(window.location.href + '?step=' + parse[2] + '&param=' + parse[3]);
                    }, 1250);
                }

                if (parse[0] === 'Error') {
                    document.querySelector('#attention').innerHTML = parse[1];
                    document.querySelector('#step_data').innerHTML = 'Installation problem!';
                    document.querySelector('#step_data').classList.replace('bg-success', 'bg-danger');
                }

                if (parse[0] === 'Done') {
                    progress_bar.forEach(e => e.style.width = '100%');
                    progress_bar.forEach(e => e.classList.add('bg-success', 'progress-bar-striped', 'progress-bar-animated'));
                    setTimeout(() => {
                        window.location.href = document.querySelector('#redirect').dataset.redirect;
                        ;
                    }, 2500);
                }
            }
        </script>
    </head>
    <body>
        <div id="redirect" class='hidden' data-redirect='<?php echo $repo_init['redirect'] ?>'></div>
        <div class="bd-highlight d-flex align-items-center min-vh-100">
            <div class="card w-25 text-center mx-auto p-2 bd-highlight">
                <div class="btn-group p-1" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="install_type" id="release" autocomplete="off" checked>
                    <label class="btn btn-outline-dark" for="release">GitHub Release</label>
                    <input type="radio" class="btn-check" name="install_type" id="master" autocomplete="off">
                    <label class="btn btn-outline-dark" for="master">GitHub Master</label>
                </div>

                <div class="btn-group p-1"><button type="button" id="install_button" class="btn btn-success">Install</button></div>

                <div class="card-body p-1">
                    <div id="attention" class="text-bg-warning p-1">Attention! The Installation is being prepared. Please do not refresh the page.
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-label="Animated striped" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                    </div>
                    <div id="parts" class="card-body p-1">
                        <div><span id="step_data" class="badge bg-success">Preparing for installation</span>&nbsp;</div>
                    </div>
                </div>
                <div class="card-footer bg-transparent"><div><span id="step" class="badge bg-danger">Step 1 of 5</span>&nbsp;</div></div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelector('#install_button').onclick = function () {
                    document.querySelector('#install_button').classList.add('disabled');
                    document.querySelector('#step_data').innerHTML = 'Requirements check';
                    setTimeout(() => {
                        setTimeout(() => {
                            var install_type = 'release';
                            if (document.querySelector('#master').checked) {
                                install_type = 'master';
                            }
                            getUpdate(window.location.href + '?step=1' + '&install_type=' + install_type);
                        }, 1500);
                        document.querySelector('#step_data').innerHTML = 'Downloading archive';
                        var progress_bar = document.querySelectorAll('.progress-bar');
                        progress_bar.forEach(e => e.style.width = '5%');
                        progress_bar.forEach(e => e.classList.add('bg-success', 'progress-bar-striped', 'progress-bar-animated'));
                    }, 1250);
                };
            }
            );
        </script>
    </body>
</html>