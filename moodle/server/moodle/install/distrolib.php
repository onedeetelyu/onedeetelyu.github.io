<?php 

function distro_get_config() {

    $config = new stdClass();

    $config->installername = 'Moodle Windows Installer';
    $config->installerversion = '2023040900';
    $config->packname = 'Xampp Portable';
    $config->packversion = '8.1.17-0 Portable (x64)';
    $config->webname = 'Apache';
    $config->webversion = '2.4.56';
    $config->phpname = 'PHP';
    $config->phpversion = '8.1.17 (VS16 X86 64bit thread safe) + PEAR';
    $config->dbname = 'MariaDB';
    $config->dbversion = '10.4.28';
    $config->moodlerelease = '4.2.1+ (Build: 20230623)';
    $config->moodleversion = '2023042401.03';
    $config->dbtype='mariadb';
    $config->dbhost='localhost';
    $config->dbuser='root';

    return $config;
}

function distro_pre_create_db($database, $dbhost, $dbuser, $dbpass, $dbname, $prefix, $dboptions, $distro) {

/// We need to change the database password in windows installer, only if != ''
    if ($dbpass !== '') {
        try {
            if ($database->connect($dbhost, $dbuser, '', 'mysql', $prefix, $dboptions)) {
                $sql = "UPDATE user SET password=password(?) WHERE user='root'";
                $params = array($dbpass);
                $database->execute($sql, $params);
                $sql = "flush privileges";
                $database->execute($sql);
            }
        } catch (Exception $ignore) {
        }
    }
}
?>
