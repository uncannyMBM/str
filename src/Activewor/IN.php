<?php


namespace StrIlluminate\StrIlluminate\Activewor;

use StrIlluminate\StrIlluminate\Activesol\Activetalk\TM;
use Facades\StrIlluminate\StrIlluminate\Activewor\{
    BS, RD, RR
};

class IN
{
    use TM;

    public function checkRequirements()
    {
        $extensions = config('requirements.php.extension');
        $requireVersion = config('requirements.php.version');
        $exts = [];
        $currentPhp = phpversion();
        $exts["Required PHP version $requireVersion"] = in_array(version_compare($requireVersion, $currentPhp), [-1, 0]) ? 1 : 0;
        foreach ($extensions as $extension) {
            $exts[$extension] = extension_loaded($extension) ? 1 : 0;
        }
        return $exts;
    }

    public function checkPermissions()
    {
        $exts = [];
        $grantPermission = 1;
        $direcotries = config('requirements.php.permissions');
        foreach ($direcotries as $key => $directory) {
            $oct = sprintf("%04d", $directory);
            $permission = substr(sprintf('%o', fileperms($key)), -4);
            $exts[$key] = ['required' => $oct, 'permission' => $permission, 'value' => (octdec($permission) >= octdec($oct) ? 1 : 0)];
            $grantPermission = ($grantPermission == 0 || $exts[$key]['value'] == 0) ? 0 : 1;
        }
        return compact('exts', 'grantPermission');
    }

    public function getToken($params)
    {
        $json = RD::strDec(config('json.json')) . '?' . http_build_query($params);
        $pid = BS::getPid();
        $how = $this->how();
        $headers = [
            "Authorization: Basic $pid",
            "www: $how"

        ];
        return RR::getResolve($json, $headers);
    }

    public function mydoc()
    {
        return BS::nextDoc();
    }

    public function setEnv($value)
    {
        $envPath = base_path('.env');
        $env = file($envPath);
        foreach ($env as $env_key => $env_value) {
            $entry = explode("=", $env_value, 2);
            if (array_key_exists($entry[0], $value)) {
                if ($entry[0] == 'DB_DATABASE' || $entry[0] == 'DB_USERNAME' || $entry[0] == 'DB_PASSWORD') {
                    $env[$env_key] = $entry[0] . '="' . $value[$entry[0]] . '"' . "\n";
                } else {
                    $env[$env_key] = $entry[0] . "=" . $value[$entry[0]] . "\n";
                }
            } else {
                $env[$env_key] = $env_value;
            }
        }
        $fp = fopen($envPath, 'w');
        fwrite($fp, implode($env));
        fclose($fp);
    }

    public function youAre()
    {
        return file_exists(BS::getTheHeck());
    }
}
